<?php
// myapp\src\yourBundle\Sockets\Chat.php;

// Change the namespace according to your bundle, and that's all !
namespace RecruitmentBundle\Sockets;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use UserBundle\Entity\User;
use UserBundle\Entity\Message;

class Chat implements MessageComponentInterface {
    
    protected $clients;
    private $users = [];
    private $botName = 'systeme';
    private $defaultChannel = 'general';
    private $em;

    public function __construct($em) {
        $this->clients = new \SplObjectStorage;
        $this->subscriptions = [];
        $this->users = [];
        $this->em = $em;
    }

    public function onOpen(ConnectionInterface $conn) {
        $this->clients->attach($conn);
        $this->users[$conn->resourceId] = [
            'connection' => $conn,
            'user' => '',
            'channels' => []
        ];

        return $conn->resourceId;
    }

    public function onMessage(ConnectionInterface $conn, $message) {
        $messageData = json_decode($message);
        if ($messageData === null) {
            return false;
        }

        $action = $messageData->action ?? 'unknown';
        $channel = $messageData->channel ?? $this->defaultChannel;
        $user = $messageData->user ?? $this->botName;
        $message = $messageData->message ?? '';
        $source = $messageData->source ?? $this->botName;
        $destinataire = $messageData->destinataire ?? $this->botName;

        switch ($action) {
            case 'subscribe':
                $this->subscribeToChannel($conn, $channel, $user);
                return true;
            case 'subscribe_dual':
                // get conn destinataire by client
                $this->subscribeToChannel($conn, $channel, $source);
                return true;
            case 'unsubscribe':
                $this->unsubscribeFromChannel($conn, $channel, $user);
                return true;
            case 'message':
                return $this->sendMessageToChannel($conn, $channel, $user, $message);
            default:
                echo sprintf('Action "%s" is not supported yet!', $action);
                break;
        }
        return false;
    }

    private function subscribeToChannel(ConnectionInterface $conn, $channel, $user)
    {
        $this->users[$conn->resourceId]['channels'][$channel] = $channel;
        /*$this->sendMessageToChannel(
            $conn,
            $channel,
            $this->botName,
            $user.' joined #'.$channel
        );
        */
    }

    private function unsubscribeFromChannel(ConnectionInterface $conn, $channel, $user)
    {
        if (array_key_exists($channel, $this->users[$conn->resourceId]['channels'])) {
            unset($this->users[$conn->resourceId]['channels']);
        }
        /*$this->sendMessageToChannel(
            $conn,
            $channel,
            $this->botName,
            $user.' left #'.$channel
        );
        */
    }

    private function sendMessageToChannel(ConnectionInterface $conn, $channel, $user, $message)
    {
        //echo("send : ".$message);
        //var_dump($this->users[$conn->resourceId]);
        if (!isset($this->users[$conn->resourceId]['channels'][$channel])) {
            echo "not found isset";
            return false;
        }
       foreach ($this->users as $connectionId => $userConnection) {
            if (array_key_exists($channel, $userConnection['channels'])) {
                $userConnection['connection']->send(json_encode([
                    'action' => 'message',
                    'channel' => $channel,
                    'user' => $user,
                    'message' => $message
                ]));
            }
        }

        $senders = explode("##", $user);
        $sender_id = $senders[1];

        // store in BDD
        $em = $this->em;
        $sender = $em->getRepository('UserBundle:User')->find($sender_id);
        $participants = explode("-", $channel);
        $nb = count($participants);
        $receiver_id = 0;
        for($i = $nb-1; $i > 0; $i--)
        {
            if($participants[$i] != $sender_id)
            {
                $receiver_id = $participants[$i];
            }
        }

        $messageObj = new Message();
        $messageObj->setMessage($message);

        if($receiver_id != 0)
        {
            $receiver = $em->getRepository('UserBundle:User')->find($receiver_id);
            $messageObj->setReceiver($receiver);
        }
        
        
        $messageObj->setSender($sender);
        $messageObj->setIsNew(1);
        $messageObj->setDateEnvoi(new \DateTime());
        $em->persist($messageObj);
        $em->flush();




        return true;
    }

    public function onClose(ConnectionInterface $conn) {
        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->detach($conn);
        unset($this->users[$closedConnection->resourceId]);

        //echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        //echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }
}