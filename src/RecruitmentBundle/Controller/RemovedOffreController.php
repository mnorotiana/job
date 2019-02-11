<?php

namespace RecruitmentBundle\Controller;

use RecruitmentBundle\Entity\RemovedOffre;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Removedoffre controller.
 *
 * @Route("removedoffre")
 */
class RemovedOffreController extends Controller
{
    /**
     * Lists all removedOffre entities.
     *
     * @Route("/", name="removedoffre_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $removedOffres = $em->getRepository('RecruitmentBundle:RemovedOffre')->findAll();

        return $this->render('removedoffre/index.html.twig', array(
            'removedOffres' => $removedOffres,
        ));
    }

    /**
     * Finds and displays a removedOffre entity.
     *
     * @Route("/{offre}", name="removedoffre_delete",defaults={"offre": ""})
     * @Method("GET")
     */
    public function deleteAction(Request $request,$offre ="")
    {
        $em = $this->getDoctrine()->getManager();
        $currentUser = $this->getUser();
        if($offre != "")
        {
            $offreObj = $em->getRepository('RecruitmentBundle:Offre')->find($offre);
            if($offreObj)
            {
                $removed = $em->getRepository('RecruitmentBundle:Removedoffre')->findOneBy(array('offre'=>$offreObj,'user'=>$currentUser));
                if(!$removed)
                {
                    $removed = new RemovedOffre();
                    $removed->setUser($currentUser);
                    $removed->setOffre($offreObj);
                    $em->persist($removed);
                    $em->flush();
                }
            }
        }
        return $this->redirectToRoute('offre_index');
    }
}
