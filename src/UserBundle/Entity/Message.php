<?php

namespace UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="message")
 * @ORM\Entity(repositoryClass="UserBundle\Repository\MessageRepository")
 */
class Message
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="string", length=255,nullable=true)
     */
    private $message;

    /**
       * @ORM\ManyToOne(targetEntity="\UserBundle\Entity\User")
       * @ORM\JoinColumn(nullable=false)
    */
    private $sender;

    /**
       * @ORM\ManyToOne(targetEntity="\UserBundle\Entity\User")

       * @ORM\JoinColumn(nullable=false)

    */
    private $receiver;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_envoi", type="datetime",nullable=true)
     */
    private $dateEnvoi;

    /**
     * @var int
     *
     * @ORM\Column(name="is_new", type="integer", nullable=true)
     */
    private $isNew;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set message.
     *
     * @param string|null $message
     *
     * @return Message
     */
    public function setMessage($message = null)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message.
     *
     * @return string|null
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set dateEnvoi.
     *
     * @param \DateTime|null $dateEnvoi
     *
     * @return Message
     */
    public function setDateEnvoi($dateEnvoi = null)
    {
        $this->dateEnvoi = $dateEnvoi;

        return $this;
    }

    /**
     * Get dateEnvoi.
     *
     * @return \DateTime|null
     */
    public function getDateEnvoi()
    {
        return $this->dateEnvoi;
    }

    /**
     * Set sender.
     *
     * @param \UserBundle\Entity\User $sender
     *
     * @return Message
     */
    public function setSender(\UserBundle\Entity\User $sender)
    {
        $this->sender = $sender;

        return $this;
    }

    /**
     * Get sender.
     *
     * @return \UserBundle\Entity\User
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * Set receiver.
     *
     * @param \UserBundle\Entity\User $receiver
     *
     * @return Message
     */
    public function setReceiver(\UserBundle\Entity\User $receiver)
    {
        $this->receiver = $receiver;

        return $this;
    }

    /**
     * Get receiver.
     *
     * @return \UserBundle\Entity\User
     */
    public function getReceiver()
    {
        return $this->receiver;
    }

    /**
     * Set isNew.
     *
     * @param int|null $isNew
     *
     * @return Message
     */
    public function setIsNew($isNew = null)
    {
        $this->isNew = $isNew;

        return $this;
    }

    /**
     * Get isNew.
     *
     * @return int|null
     */
    public function getIsNew()
    {
        return $this->isNew;
    }
}
