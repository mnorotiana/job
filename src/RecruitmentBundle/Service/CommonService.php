<?php

namespace RecruitmentBundle\Service;
use \Doctrine\ORM\EntityManager;
use ReportingBundle\Entity\RegleUser;
use ReportingBundle\Entity\DomaineUser;
use ReportingBundle\Entity\SocieteUser;

class CommonService
{
    /**
     *
     * @var EntityManager 
     */
    protected $em;
    /**
     * @var \Symfony\Component\Routing\RouterInterface
     */
    private $router;

    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    public function getSettings($currentUser,$em)
    {    
        $regles = $em->getRepository('RecruitmentBundle:RegleUser')->findByUser($currentUser);
        $societes_regle = $em->getRepository('RecruitmentBundle:SocieteUser')->findByUser($currentUser);
        $domaines = $em->getRepository('RecruitmentBundle:DomaineUser')->findByUser($currentUser);

        $societes = array();
        foreach ($societes_regle as $key => $soc) {
            $societe = $soc->getSociete();
            if(!in_array($societe, $societes))
            {
                $societes[] = $societe;
            }
        }

        $settings = array();
        $settings['regles'] = $regles;
        $settings['societes'] = $societes;
        $settings['domaines'] = $domaines;


        return $settings;
    }

   
    
}

?>