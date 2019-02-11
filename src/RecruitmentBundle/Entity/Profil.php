<?php

namespace RecruitmentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Profil
 *
 * @ORM\Table(name="profil")
 * @ORM\Entity(repositoryClass="RecruitmentBundle\Repository\ProfilRepository")
 */
class Profil
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
     * @ORM\Column(name="sexe", type="string", length=255)
     */
    private $sexe;

    /**
     * @var string
     *
     * @ORM\Column(name="situation_matrimoniale", type="string", length=255)
     */
    private $situationMatrimoniale;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255, nullable=true)
     */
    private $prenom;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_naissance", type="date", nullable=true)
     */
    private $dateNaissance;

    /**
     * @var string
     *
     * @ORM\Column(name="lieu_naissance", type="string", length=255, nullable=true)
     */
    private $lieuNaissance;

    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=255, nullable=true)
     */
    private $adresse;

    /**
     * @var string
     *
     * @ORM\Column(name="ville", type="string", length=255, nullable=true)
     */
    private $ville;

    /**
     * @var string
     *
     * @ORM\Column(name="code_postal", type="string", length=255, nullable=true)
     */
    private $codePostal;

    /**
     * @var string
     *
     * @ORM\Column(name="telephone", type="string", length=255, nullable=true)
     */
    private $telephone;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="pseudo_skype", type="string", length=255, nullable=true)
     */
    private $pseudoSkype;

    /**
     * @var string
     *
     * @ORM\Column(name="domaine_competence", type="string", length=255, nullable=true)
     */
    private $domaineCompetence;

    /**
     * @var string
     *
     * @ORM\Column(name="diplome1", type="string", length=255, nullable=true)
     */
    private $diplome1;

    /**
     * @var string
     *
     * @ORM\Column(name="etablissement1", type="string", length=255, nullable=true)
     */
    private $etablissement1;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_obtention1", type="date", nullable=true)
     */
    private $dateObtention1;

    /**
     * @var string
     *
     * @ORM\Column(name="diplome2", type="string", length=255, nullable=true)
     */
    private $diplome2;

    /**
     * @var string
     *
     * @ORM\Column(name="etablissement2", type="string", length=255, nullable=true)
     */
    private $etablissement2;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_obtention2", type="date", nullable=true)
     */
    private $dateObtention2;

    /**
     * @var string
     *
     * @ORM\Column(name="diplome3", type="string", length=255, nullable=true)
     */
    private $diplome3;

    /**
     * @var string
     *
     * @ORM\Column(name="etablissement3", type="string", length=255, nullable=true)
     */
    private $etablissement3;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_obtention3", type="date", nullable=true)
     */
    private $dateObtention3;

    /**
     * @var string
     *
     * @ORM\Column(name="intitule_poste1", type="string", length=255, nullable=true)
     */
    private $intitulePoste1;

    /**
     * @var string
     *
     * @ORM\Column(name="societe1", type="string", length=255, nullable=true)
     */
    private $societe1;

    /**
     * @var string
     *
     * @ORM\Column(name="duree1", type="string", length=255, nullable=true)
     */
    private $duree1;

    /**
     * @var string
     *
     * @ORM\Column(name="referent1", type="string", length=255, nullable=true)
     */
    private $referent1;

    /**
     * @var string
     *
     * @ORM\Column(name="mail_referent1", type="string", length=255, nullable=true)
     */
    private $mailReferent1;

    /**
     * @var string
     *
     * @ORM\Column(name="telephone_referent1", type="string", length=255, nullable=true)
     */
    private $telephoneReferent1;

    /**
     * @var string
     *
     * @ORM\Column(name="domaine_poste1", type="string", length=255, nullable=true)
     */
    private $domainePoste1;

    /**
     * @var string
     *
     * @ORM\Column(name="intitule_poste2", type="string", length=255, nullable=true)
     */
    private $intitulePoste2;

    /**
     * @var string
     *
     * @ORM\Column(name="societe2", type="string", length=255, nullable=true)
     */
    private $societe2;

    /**
     * @var string
     *
     * @ORM\Column(name="duree2", type="string", length=255, nullable=true)
     */
    private $duree2;

    /**
     * @var string
     *
     * @ORM\Column(name="referent2", type="string", length=255, nullable=true)
     */
    private $referent2;

    /**
     * @var string
     *
     * @ORM\Column(name="mail_referent2", type="string", length=255, nullable=true)
     */
    private $mailReferent2;

    /**
     * @var string
     *
     * @ORM\Column(name="telephone_referent2", type="string", length=255, nullable=true)
     */
    private $telephoneReferent2;

    /**
     * @var string
     *
     * @ORM\Column(name="domaine_poste2", type="string", length=255, nullable=true)
     */
    private $domainePoste2;

    /**
     * @var string
     *
     * @ORM\Column(name="cv", type="string", length=255, nullable=true)
     */
    private $cv;

    /**
     * @var string
     *
     * @ORM\Column(name="lm", type="string", length=255, nullable=true)
     */
    private $lm;

    /**
     * @var string
     *
     * @ORM\Column(name="diplome", type="string", length=255, nullable=true)
     */
    private $diplome;

    /**
     * @var string
     *
     * @ORM\Column(name="statut", type="string", length=255, nullable=true))
     */
    private $statut;

    /**
     * @var string
     *
     * @ORM\Column(name="duree_preavis", type="string", length=255, nullable=true))
     */
    private $dureePreavis;

    /**
       * @ORM\ManyToOne(targetEntity="\UserBundle\Entity\User")

       * @ORM\JoinColumn(nullable=false)

    */
    private $candidat;


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
     * Set sexe
     *
     * @param string $sexe
     *
     * @return Profil
     */
    public function setSexe($sexe)
    {
        $this->sexe = $sexe;

        return $this;
    }

    /**
     * Get sexe
     *
     * @return string
     */
    public function getSexe()
    {
        return $this->sexe;
    }

    /**
     * Set situationMatrimoniale
     *
     * @param string $situationMatrimoniale
     *
     * @return Profil
     */
    public function setSituationMatrimoniale($situationMatrimoniale)
    {
        $this->situationMatrimoniale = $situationMatrimoniale;

        return $this;
    }

    /**
     * Get situationMatrimoniale
     *
     * @return string
     */
    public function getSituationMatrimoniale()
    {
        return $this->situationMatrimoniale;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Profil
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     *
     * @return Profil
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set dateNaissance
     *
     * @param \DateTime $dateNaissance
     *
     * @return Profil
     */
    public function setDateNaissance($dateNaissance)
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    /**
     * Get dateNaissance
     *
     * @return \DateTime
     */
    public function getDateNaissance()
    {
        return $this->dateNaissance;
    }

    /**
     * Set lieuNaissance
     *
     * @param string $lieuNaissance
     *
     * @return Profil
     */
    public function setLieuNaissance($lieuNaissance)
    {
        $this->lieuNaissance = $lieuNaissance;

        return $this;
    }

    /**
     * Get lieuNaissance
     *
     * @return string
     */
    public function getLieuNaissance()
    {
        return $this->lieuNaissance;
    }

    /**
     * Set adresse
     *
     * @param string $adresse
     *
     * @return Profil
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get adresse
     *
     * @return string
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set ville
     *
     * @param string $ville
     *
     * @return Profil
     */
    public function setVille($ville)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville
     *
     * @return string
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Set codePostal
     *
     * @param string $codePostal
     *
     * @return Profil
     */
    public function setCodePostal($codePostal)
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    /**
     * Get codePostal
     *
     * @return string
     */
    public function getCodePostal()
    {
        return $this->codePostal;
    }

    /**
     * Set telephone
     *
     * @param string $telephone
     *
     * @return Profil
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * Get telephone
     *
     * @return string
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Profil
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set pseudoSkype
     *
     * @param string $pseudoSkype
     *
     * @return Profil
     */
    public function setPseudoSkype($pseudoSkype)
    {
        $this->pseudoSkype = $pseudoSkype;

        return $this;
    }

    /**
     * Get pseudoSkype
     *
     * @return string
     */
    public function getPseudoSkype()
    {
        return $this->pseudoSkype;
    }

    /**
     * Set domaineCompetence
     *
     * @param string $domaineCompetence
     *
     * @return Profil
     */
    public function setDomaineCompetence($domaineCompetence)
    {
        $this->domaineCompetence = $domaineCompetence;

        return $this;
    }

    /**
     * Get domaineCompetence
     *
     * @return string
     */
    public function getDomaineCompetence()
    {
        return $this->domaineCompetence;
    }

    /**
     * Set diplome1
     *
     * @param string $diplome1
     *
     * @return Profil
     */
    public function setDiplome1($diplome1)
    {
        $this->diplome1 = $diplome1;

        return $this;
    }

    /**
     * Get diplome1
     *
     * @return string
     */
    public function getDiplome1()
    {
        return $this->diplome1;
    }

    /**
     * Set etablissement1
     *
     * @param string $etablissement1
     *
     * @return Profil
     */
    public function setEtablissement1($etablissement1)
    {
        $this->etablissement1 = $etablissement1;

        return $this;
    }

    /**
     * Get etablissement1
     *
     * @return string
     */
    public function getEtablissement1()
    {
        return $this->etablissement1;
    }

    /**
     * Set dateObtention1
     *
     * @param \DateTime $dateObtention1
     *
     * @return Profil
     */
    public function setDateObtention1($dateObtention1)
    {
        $this->dateObtention1 = $dateObtention1;

        return $this;
    }

    /**
     * Get dateObtention1
     *
     * @return \DateTime
     */
    public function getDateObtention1()
    {
        return $this->dateObtention1;
    }

    /**
     * Set diplome2
     *
     * @param string $diplome2
     *
     * @return Profil
     */
    public function setDiplome2($diplome2)
    {
        $this->diplome2 = $diplome2;

        return $this;
    }

    /**
     * Get diplome2
     *
     * @return string
     */
    public function getDiplome2()
    {
        return $this->diplome2;
    }

    /**
     * Set etablissement2
     *
     * @param string $etablissement2
     *
     * @return Profil
     */
    public function setEtablissement2($etablissement2)
    {
        $this->etablissement2 = $etablissement2;

        return $this;
    }

    /**
     * Get etablissement2
     *
     * @return string
     */
    public function getEtablissement2()
    {
        return $this->etablissement2;
    }

    /**
     * Set dateObtention2
     *
     * @param string $dateObtention2
     *
     * @return Profil
     */
    public function setDateObtention2($dateObtention2)
    {
        $this->dateObtention2 = $dateObtention2;

        return $this;
    }

    /**
     * Get dateObtention2
     *
     * @return string
     */
    public function getDateObtention2()
    {
        return $this->dateObtention2;
    }

    /**
     * Set diplome3
     *
     * @param string $diplome3
     *
     * @return Profil
     */
    public function setDiplome3($diplome3)
    {
        $this->diplome3 = $diplome3;

        return $this;
    }

    /**
     * Get diplome3
     *
     * @return string
     */
    public function getDiplome3()
    {
        return $this->diplome3;
    }

    /**
     * Set etablissement3
     *
     * @param string $etablissement3
     *
     * @return Profil
     */
    public function setEtablissement3($etablissement3)
    {
        $this->etablissement3 = $etablissement3;

        return $this;
    }

    /**
     * Get etablissement3
     *
     * @return string
     */
    public function getEtablissement3()
    {
        return $this->etablissement3;
    }

    /**
     * Set dateObtention3
     *
     * @param \DateTime $dateObtention3
     *
     * @return Profil
     */
    public function setDateObtention3($dateObtention3)
    {
        $this->dateObtention3 = $dateObtention3;

        return $this;
    }

    /**
     * Get dateObtention3
     *
     * @return \DateTime
     */
    public function getDateObtention3()
    {
        return $this->dateObtention3;
    }

    /**
     * Set intitulePoste1
     *
     * @param string $intitulePoste1
     *
     * @return Profil
     */
    public function setIntitulePoste1($intitulePoste1)
    {
        $this->intitulePoste1 = $intitulePoste1;

        return $this;
    }

    /**
     * Get intitulePoste1
     *
     * @return string
     */
    public function getIntitulePoste1()
    {
        return $this->intitulePoste1;
    }

    /**
     * Set societe1
     *
     * @param string $societe1
     *
     * @return Profil
     */
    public function setSociete1($societe1)
    {
        $this->societe1 = $societe1;

        return $this;
    }

    /**
     * Get societe1
     *
     * @return string
     */
    public function getSociete1()
    {
        return $this->societe1;
    }

    /**
     * Set duree1
     *
     * @param string $duree1
     *
     * @return Profil
     */
    public function setDuree1($duree1)
    {
        $this->duree1 = $duree1;

        return $this;
    }

    /**
     * Get duree1
     *
     * @return string
     */
    public function getDuree1()
    {
        return $this->duree1;
    }

    /**
     * Set referent1
     *
     * @param string $referent1
     *
     * @return Profil
     */
    public function setReferent1($referent1)
    {
        $this->referent1 = $referent1;

        return $this;
    }

    /**
     * Get referent1
     *
     * @return string
     */
    public function getReferent1()
    {
        return $this->referent1;
    }

    /**
     * Set mailReferent1
     *
     * @param string $mailReferent1
     *
     * @return Profil
     */
    public function setMailReferent1($mailReferent1)
    {
        $this->mailReferent1 = $mailReferent1;

        return $this;
    }

    /**
     * Get mailReferent1
     *
     * @return string
     */
    public function getMailReferent1()
    {
        return $this->mailReferent1;
    }

    /**
     * Set telephoneReferent1
     *
     * @param string $telephoneReferent1
     *
     * @return Profil
     */
    public function setTelephoneReferent1($telephoneReferent1)
    {
        $this->telephoneReferent1 = $telephoneReferent1;

        return $this;
    }

    /**
     * Get telephoneReferent1
     *
     * @return string
     */
    public function getTelephoneReferent1()
    {
        return $this->telephoneReferent1;
    }

    /**
     * Set domainePoste1
     *
     * @param string $domainePoste1
     *
     * @return Profil
     */
    public function setDomainePoste1($domainePoste1)
    {
        $this->domainePoste1 = $domainePoste1;

        return $this;
    }

    /**
     * Get domainePoste1
     *
     * @return string
     */
    public function getDomainePoste1()
    {
        return $this->domainePoste1;
    }

    /**
     * Set intitulePoste2
     *
     * @param string $intitulePoste2
     *
     * @return Profil
     */
    public function setIntitulePoste2($intitulePoste2)
    {
        $this->intitulePoste2 = $intitulePoste2;

        return $this;
    }

    /**
     * Get intitulePoste2
     *
     * @return string
     */
    public function getIntitulePoste2()
    {
        return $this->intitulePoste2;
    }

    /**
     * Set societe2
     *
     * @param string $societe2
     *
     * @return Profil
     */
    public function setSociete2($societe2)
    {
        $this->societe2 = $societe2;

        return $this;
    }

    /**
     * Get societe2
     *
     * @return string
     */
    public function getSociete2()
    {
        return $this->societe2;
    }

    /**
     * Set duree2
     *
     * @param string $duree2
     *
     * @return Profil
     */
    public function setDuree2($duree2)
    {
        $this->duree2 = $duree2;

        return $this;
    }

    /**
     * Get duree2
     *
     * @return string
     */
    public function getDuree2()
    {
        return $this->duree2;
    }

    /**
     * Set referent2
     *
     * @param string $referent2
     *
     * @return Profil
     */
    public function setReferent2($referent2)
    {
        $this->referent2 = $referent2;

        return $this;
    }

    /**
     * Get referent2
     *
     * @return string
     */
    public function getReferent2()
    {
        return $this->referent2;
    }

    /**
     * Set mailReferent2
     *
     * @param string $mailReferent2
     *
     * @return Profil
     */
    public function setMailReferent2($mailReferent2)
    {
        $this->mailReferent2 = $mailReferent2;

        return $this;
    }

    /**
     * Get mailReferent2
     *
     * @return string
     */
    public function getMailReferent2()
    {
        return $this->mailReferent2;
    }

    /**
     * Set telephoneReferent2
     *
     * @param string $telephoneReferent2
     *
     * @return Profil
     */
    public function setTelephoneReferent2($telephoneReferent2)
    {
        $this->telephoneReferent2 = $telephoneReferent2;

        return $this;
    }

    /**
     * Get telephoneReferent2
     *
     * @return string
     */
    public function getTelephoneReferent2()
    {
        return $this->telephoneReferent2;
    }

    /**
     * Set domainePoste2
     *
     * @param string $domainePoste2
     *
     * @return Profil
     */
    public function setDomainePoste2($domainePoste2)
    {
        $this->domainePoste2 = $domainePoste2;

        return $this;
    }

    /**
     * Get domainePoste2
     *
     * @return string
     */
    public function getDomainePoste2()
    {
        return $this->domainePoste2;
    }

    /**
     * Set cv
     *
     * @param string $cv
     *
     * @return Profil
     */
    public function setCv($cv)
    {
        $this->cv = $cv;

        return $this;
    }

    /**
     * Get cv
     *
     * @return string
     */
    public function getCv()
    {
        return $this->cv;
    }

    /**
     * Set lm
     *
     * @param string $lm
     *
     * @return Profil
     */
    public function setLm($lm)
    {
        $this->lm = $lm;

        return $this;
    }

    /**
     * Get lm
     *
     * @return string
     */
    public function getLm()
    {
        return $this->lm;
    }

    /**
     * Set diplome
     *
     * @param string $diplome
     *
     * @return Profil
     */
    public function setDiplome($diplome)
    {
        $this->diplome = $diplome;

        return $this;
    }

    /**
     * Get diplome
     *
     * @return string
     */
    public function getDiplome()
    {
        return $this->diplome;
    }

    /**
     * Set statut
     *
     * @param string $statut
     *
     * @return Profil
     */
    public function setStatut($statut)
    {
        $this->statut = $statut;

        return $this;
    }

    /**
     * Get statut
     *
     * @return string
     */
    public function getStatut()
    {
        return $this->statut;
    }

    /**
     * Set dureePreavis
     *
     * @param string $dureePreavis
     *
     * @return Profil
     */
    public function setDureePreavis($dureePreavis)
    {
        $this->dureePreavis = $dureePreavis;

        return $this;
    }

    /**
     * Get dureePreavis
     *
     * @return string
     */
    public function getDureePreavis()
    {
        return $this->dureePreavis;
    }

    /**
     * Set candidat
     *
     * @param UserBundle\Entity\User $candidat
     *
     * @return Profil
     */
    public function setCandidat(\UserBundle\Entity\User $candidat)
    {
        $this->candidat = $candidat;

        return $this;
    }

    /**
     * Get candidat
     *
     * @return UserBundle\Entity\User
     */
    public function getCandidat()
    {
        return $this->candidat;
    }
}
