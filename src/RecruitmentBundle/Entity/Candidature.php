<?php

namespace RecruitmentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Candidature
 *
 * @ORM\Table(name="candidature")
 * @ORM\Entity(repositoryClass="RecruitmentBundle\Repository\CandidatureRepository")
 */
class Candidature
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
     * @ORM\Column(name="statut", type="string", length=255)
     */
    private $statut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_reception", type="datetime", nullable=true)
     */
    private $dateReception;

    /**
       * @ORM\ManyToOne(targetEntity="\RecruitmentBundle\Entity\Profil")

       * @ORM\JoinColumn(nullable=false)

    */
    private $candidat;

    /**
       * @ORM\ManyToOne(targetEntity="\RecruitmentBundle\Entity\Offre")

       * @ORM\JoinColumn(nullable=false)

    */
    private $offre;

    /**
     * @var string
     *
     * @ORM\Column(name="note", type="string", length=255, nullable=true)
     */
    private $note;

    /**
     * @var string
     *
     * @ORM\Column(name="motifs", type="text",nullable=true)
     */
    private $motifs;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_test", type="datetime",nullable=true)
     */
    private $dateTest;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_entretien", type="datetime",nullable=true)
     */
    private $dateEntretien;

    /**
     * @var string
     *
     * @ORM\Column(name="commentaire_test", type="text",nullable=true)
     */
    private $commentaireTest;

    /**
     * @var string
     *
     * @ORM\Column(name="commentaire_entretien", type="text",nullable=true)
     */
    private $commentaireEntretien;


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
     * Set dateReception
     *
     * @param string $dateReception
     *
     * @return Candidature
     */
    public function setDateReception($dateReception)
    {
        $this->dateReception = $dateReception;

        return $this;
    }

    /**
     * Get dateReception
     *
     * @return string
     */
    public function getDateReception()
    {
        return $this->dateReception;
    }

    /**
     * Set statut
     *
     * @param \DateTime $statut
     *
     * @return Candidature
     */
    public function setStatut($statut)
    {
        $this->statut = $statut;

        return $this;
    }

    /**
     * Get statut
     *
     * @return \DateTime
     */
    public function getStatut()
    {
        return $this->statut;
    }

    /**
     * Set note
     *
     * @param string $note
     *
     * @return Candidature
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note
     *
     * @return string
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set motifs
     *
     * @param string $motifs
     *
     * @return Candidature
     */
    public function setMotifs($motifs)
    {
        $this->motifs = $motifs;

        return $this;
    }

    /**
     * Get motifs
     *
     * @return string
     */
    public function getMotifs()
    {
        return $this->motifs;
    }

    /**
     * Set dateTest
     *
     * @param \DateTime $dateTest
     *
     * @return Candidature
     */
    public function setDateTest($dateTest)
    {
        $this->dateTest = $dateTest;

        return $this;
    }

    /**
     * Get dateTest
     *
     * @return \DateTime
     */
    public function getDateTest()
    {
        return $this->dateTest;
    }

    /**
     * Set dateEntretien
     *
     * @param \DateTime $dateEntretien
     *
     * @return Candidature
     */
    public function setDateEntretien($dateEntretien)
    {
        $this->dateEntretien = $dateEntretien;

        return $this;
    }

    /**
     * Get dateEntretien
     *
     * @return \DateTime
     */
    public function getDateEntretien()
    {
        return $this->dateEntretien;
    }

    /**
     * Set commentaireTest
     *
     * @param string $commentaireTest
     *
     * @return Candidature
     */
    public function setCommentaireTest($commentaireTest)
    {
        $this->commentaireTest = $commentaireTest;

        return $this;
    }

    /**
     * Get commentaireTest
     *
     * @return string
     */
    public function getCommentaireTest()
    {
        return $this->commentaireTest;
    }

    /**
     * Set commentaireEntretien
     *
     * @param string $commentaireEntretien
     *
     * @return Candidature
     */
    public function setCommentaireEntretien($commentaireEntretien)
    {
        $this->commentaireEntretien = $commentaireEntretien;

        return $this;
    }

    /**
     * Get commentaireEntretien
     *
     * @return string
     */
    public function getCommentaireEntretien()
    {
        return $this->commentaireEntretien;
    }

    /**
     * Set candidat
     *
     * @param \RecruitmentBundle\Entity\Profil $candidat
     *
     * @return Candidature
     */
    public function setCandidat(\RecruitmentBundle\Entity\Profil $candidat)
    {
        $this->candidat = $candidat;

        return $this;
    }

    /**
     * Get candidat
     *
     * @return \RecruitmentBundle\Entity\Profil
     */
    public function getCandidat()
    {
        return $this->candidat;
    }

    /**
     * Set offre
     *
     * @param \RecruitmentBundle\Entity\Offre $offre
     *
     * @return Candidature
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
