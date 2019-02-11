<?php

namespace RecruitmentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SocieteUser
 *
 * @ORM\Table(name="societe_user")
 * @ORM\Entity(repositoryClass="RecruitmentBundle\Repository\SocieteUserRepository")
 */
class SocieteUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
       * @ORM\ManyToOne(targetEntity="\UserBundle\Entity\User")

       * @ORM\JoinColumn(nullable=false)

    */
    private $societe;

    /**
       * @ORM\ManyToOne(targetEntity="\UserBundle\Entity\User")

       * @ORM\JoinColumn(nullable=false)

    */
    private $user;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set societe
     *
     * @param \UserBundle\Entity\User $societe
     *
     * @return SocieteUser
     */
    public function setSociete(\UserBundle\Entity\User $societe)
    {
        $this->societe = $societe;

        return $this;
    }

    /**
     * Get societe
     *
     * @return \UserBundle\Entity\User
     */
    public function getSociete()
    {
        return $this->societe;
    }

    /**
     * Set user
     *
     * @param \UserBundle\Entity\User $user
     *
     * @return SocieteUser
     */
    public function setUser(\UserBundle\Entity\User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
