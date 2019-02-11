<?php

namespace RecruitmentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RemovedOffre
 *
 * @ORM\Table(name="removed_offre")
 * @ORM\Entity(repositoryClass="RecruitmentBundle\Repository\RemovedOffreRepository")
 */
class RemovedOffre
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
    private $user;

    /**
       * @ORM\ManyToOne(targetEntity="\RecruitmentBundle\Entity\Offre")

       * @ORM\JoinColumn(nullable=false)

    */
    private $offre;


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
     * Set user
     *
     * @param \UserBundle\Entity\User $user
     *
     * @return RemovedOffre
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

    /**
     * Set offre
     *
     * @param \RecruitmentBundle\Entity\Offre $offre
     *
     * @return RemovedOffre
     */
    public function setOffre(\RecruitmentBundle\Entity\Offre $offre)
    {
        $this->offre = $offre;

        return $this;
    }

    /**
     * Get offre
     *
     * @return \RecruitmentBundle\Entity\Offre
     */
    public function getOffre()
    {
        return $this->offre;
    }
}
