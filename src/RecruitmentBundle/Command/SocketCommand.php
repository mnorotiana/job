<?php
// myapplication/src/sandboxBundle/Command/SocketCommand.php
// Change the namespace according to your bundle
namespace RecruitmentBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Ratchet\App;

// Include ratchet libs
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

// Change the namespace according to your bundle
use RecruitmentBundle\Sockets\Chat;

class SocketCommand extends ContainerAwareCommand 
{
    protected function configure()
    {
        $this->setName('sockets:start-chat')
            // the short description shown while running "php bin/console list"
            ->addArgument('username', InputArgument::OPTIONAL, 'Utilisateur à contacter')
            ->setHelp("Starts the chat socket demo")
            // the full command description shown when running the command with
            ->setDescription('Starts the chat socket demo')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln([
            'Chat socket',// A line
            '============',// Another line
            'Starting chat, open your browser.',// Empty line
        ]);

        $username = $input->getArgument('username');

        /*$app = new App('localhost', 8080);
        // Add route to chat with the handler as second parameter
        $app->route('/chat', new Chat);      

        $app->run();
        */

        $em = $this->getContainer()->get('doctrine')->getManager();


        $server = IoServer::factory(
            new HttpServer(
                new WsServer(
                    new Chat($em)
                )
            ),
            8080
        );
        
        $server->run();
    }
}