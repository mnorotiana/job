<?php

namespace RecruitmentBundle\Controller;

use RecruitmentBundle\Entity\SocieteUser;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Societeuser controller.
 *
 * @Route("societeuser")
 */
class SocieteUserController extends Controller
{
    /**
     * Lists all societeUser entities.
     *
     * @Route("/", name="societeuser_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $societeUsers = $em->getRepository('RecruitmentBundle:SocieteUser')->findAll();

        return $this->render('societeuser/index.html.twig', array(
            'societeUsers' => $societeUsers,
        ));
    }

    /**
     * Creates a new societeUser entity.
     *
     * @Route("/new", name="societeuser_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {       

        $em = $this->getDoctrine()->getManager();
        $currentUser = $this->getUser();

        $libelle = $request->request->get('libelle');

        $societe = $em->getRepository('UserBundle:User')->findByRoleAndName('ROLE_SOCIETE',$libelle);

        if($societe)
        {
            $societeUser = $em->getRepository('RecruitmentBundle:SocieteUser')->findOneBy(array('societe'=>$societe,'user'=>$currentUser));
            if(!$societeUser)
            {
                $societeUser = new SocieteUser();
                $societeUser->setSociete($societe);
                $societeUser->setUser($currentUser);
                $em->persist($societeUser);
                $em->flush();

                // update session domaines
                $commonService = $this->container->get('app.common_service');
                $commons = $commonService->getSettings($currentUser,$em);

                $this->get('session')->replace(array('regles'=>$commons['regles'],'societes'=>$commons['societes'],'domaines'=>$commons['domaines']));

                return new Response("ok");
            }
        }        

        return new Response("existant");
    }

    /**
     * Finds and displays a societeUser entity.
     *
     * @Route("/{id}", name="societeuser_show")
     * @Method("GET")
     */
    public function showAction(SocieteUser $societeUser)
    {
        $deleteForm = $this->createDeleteForm($societeUser);

        return $this->render('societeuser/show.html.twig', array(
            'societeUser' => $societeUser,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing societeUser entity.
     *
     * @Route("/{id}/edit", name="societeuser_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, SocieteUser $societeUser)
    {
        $deleteForm = $this->createDeleteForm($societeUser);
        $editForm = $this->createForm('RecruitmentBundle\Form\SocieteUserType', $societeUser);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('societeuser_edit', array('id' => $societeUser->getId()));
        }

        return $this->render('societeuser/edit.html.twig', array(
            'societeUser' => $societeUser,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a societeUser entity.
     *
     * @Route("/delete/{id_societe}", name="societeuser_delete",defaults={"id_societe":0})
     * @Method({"GET","POST"})
     */
    public function deleteAction(Request $request, $id_societe=0)
    {        
        $em = $this->getDoctrine()->getManager();
        if($id_societe != 0)
        {
            $societe = $em->getRepository('UserBundle:User')->find($id_societe);
            $societeUsers = $em->getRepository('RecruitmentBundle:SocieteUser')->findBySociete($societe);
            foreach ($societeUsers as $key => $societeUser) {                
                $em->remove($societeUser);
                $em->flush();
            }            
        }

        $currentUser = $this->getUser();

        $commonService = $this->container->get('app.common_service');
        $commons = $commonService->getSettings($currentUser,$em);
        $this->get('session')->replace(array('regles'=>$commons['regles'],'societes'=>$commons['societes'],'domaines'=>$commons['domaines']));
        
        
        return $this->redirectToRoute('offre_index');
    }

    /**
     * Creates a form to delete a societeUser entity.
     *
     * @param SocieteUser $societeUser The societeUser entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SocieteUser $societeUser)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('societeuser_delete', array('id' => $societeUser->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
