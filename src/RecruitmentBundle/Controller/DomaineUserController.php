<?php

namespace RecruitmentBundle\Controller;

use RecruitmentBundle\Entity\DomaineUser;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Domaineuser controller.
 *
 * @Route("domaineuser")
 */
class DomaineUserController extends Controller
{
    /**
     * Lists all domaineUser entities.
     *
     * @Route("/", name="domaineuser_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $domaineUsers = $em->getRepository('RecruitmentBundle:DomaineUser')->findAll();

        return $this->render('domaineuser/index.html.twig', array(
            'domaineUsers' => $domaineUsers,
        ));
    }

    /**
     * Creates a new domaineUser entity.
     *
     * @Route("/new", name="domaineuser_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {        
        $em = $this->getDoctrine()->getManager();
        $currentUser = $this->getUser();

        $libelle = $request->request->get('libelle');
        $domaineUser = $em->getRepository('RecruitmentBundle:DomaineUser')->findOneBy(array('motCle'=>$libelle,'user'=>$currentUser));
        if(!$domaineUser)
        {
            $domaineUser = new DomaineUser();
            $domaineUser->setMotCle($libelle);
            $domaineUser->setUser($currentUser);
            $em->persist($domaineUser);
            $em->flush();

            // update session domaines
            
            $commonService = $this->container->get('app.common_service');
            $commons = $commonService->getSettings($currentUser,$em);            
            $this->get('session')->replace(array('regles'=>$commons['regles'],'societes'=>$commons['societes'],'domaines'=>$commons['domaines']));

            $path_delete = $this->generateUrl('domaineuser_delete',array('id'=>$domaineUser->getId()));
            
            return new Response("<p>".$libelle."<a href=\"".$path_delete."\">Supprimer</a></p>");
        }

        return new Response("existant");
       
    }

    /**
     * Finds and displays a domaineUser entity.
     *
     * @Route("/{id}", name="domaineuser_show")
     * @Method("GET")
     */
    public function showAction(DomaineUser $domaineUser)
    {
        $deleteForm = $this->createDeleteForm($domaineUser);

        return $this->render('domaineuser/show.html.twig', array(
            'domaineUser' => $domaineUser,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing domaineUser entity.
     *
     * @Route("/{id}/edit", name="domaineuser_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, DomaineUser $domaineUser)
    {
        $deleteForm = $this->createDeleteForm($domaineUser);
        $editForm = $this->createForm('RecruitmentBundle\Form\DomaineUserType', $domaineUser);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('domaineuser_edit', array('id' => $domaineUser->getId()));
        }

        return $this->render('domaineuser/edit.html.twig', array(
            'domaineUser' => $domaineUser,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a domaineUser entity.
     *
     * @Route("/delete/{id}", name="domaineuser_delete")
     * @Method({"GET","POST"})
     */
    public function deleteAction(Request $request, DomaineUser $domaineUser)
    {       
        $em = $this->getDoctrine()->getManager();
        $em->remove($domaineUser);
        $em->flush();

        $currentUser = $this->getUser();
        $commonService = $this->container->get('app.common_service');
        $commons = $commonService->getSettings($currentUser,$em);
        $this->get('session')->replace(array('regles'=>$commons['regles'],'societes'=>$commons['societes'],'domaines'=>$commons['domaines']));


        return $this->redirectToRoute('offre_index');
    }

    /**
     * Creates a form to delete a domaineUser entity.
     *
     * @param DomaineUser $domaineUser The domaineUser entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(DomaineUser $domaineUser)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('domaineuser_delete', array('id' => $domaineUser->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
