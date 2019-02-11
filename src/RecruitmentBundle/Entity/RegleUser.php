<?php

namespace RecruitmentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RegleUser
 *
 * @ORM\Table(name="regle_user")
 * @ORM\Entity(repositoryClass="RecruitmentBundle\Repository\RegleUserRepository")
 */
class RegleUser
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
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="dossier", type="string", length=255)
     */
    private $dossier;

    /**
     * @var string
     *
     * @ORM\Column(name="mot_cle", type="string", length=255)
     */
    private $motCle;

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
     * Set type
     *
     * @param string $type
     *
     * @return RegleUser
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set dossier
     *
     * @param string $dossier
     *
     * @return RegleUser
     */
    public function setDossier($dossier)
    {
        $this->dossier = $dossier;

        return $this;
    }

    /**
     * Get dossier
     *
     * @return string
     */
    public function getDossier()
    {
        return $this->dossier;
    }

    /**
     * Set motCle
     *
     * @param string $motCle
     *
     * @return RegleUser
     */
    public function setMotCle($motCle)
    {
        $this->motCle = $motCle;

        return $this;
    }

    /**
     * Get motCle
     *
     * @return string
     */
    public function getMotCle()
    {
        return $this->motCle;
    }

    /**
     * Set user
     *
     * @param \UserBundle\Entity\User $user
     *
     * @return RegleUser
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
