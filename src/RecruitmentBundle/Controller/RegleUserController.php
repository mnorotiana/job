<?php

namespace RecruitmentBundle\Controller;

use RecruitmentBundle\Entity\RegleUser;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Regleuser controller.
 *
 * @Route("regleuser")
 */
class RegleUserController extends Controller
{
    /**
     * Lists all regleUser entities.
     *
     * @Route("/", name="regleuser_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $regleUsers = $em->getRepository('RecruitmentBundle:RegleUser')->findAll();

        return $this->render('regleuser/index.html.twig', array(
            'regleUsers' => $regleUsers,
        ));
    }

    /**
     * Creates a new regleUser entity.
     *
     * @Route("/new", name="regleuser_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $type = $request->request->get('type');
        $dossier = $request->request->get('dossier');
        $motCle = $request->request->get('motCle');

        $id = $request->request->get('id');

        $currentUser = $this->getUser();

        $regleUser = null;

        if($id)
        {
            $regleUser = $em->getRepository('RecruitmentBundle:RegleUser')->find($id);
        }
        else
        {
            $regleUser = $em->getRepository('RecruitmentBundle:RegleUser')->findOneBy(array('user'=>$currentUser,'dossier'=>$dossier,'motCle'=>$motCle,'type'=>$type));
        }

        
        if(!$regleUser)
        {
            $regleUser = new RegleUser();
        }

        $regleUser->setUser($currentUser);
        $regleUser->setDossier($dossier);
        $regleUser->setMotCle($motCle);
        $regleUser->setType($type);
        $em->persist($regleUser);
        $em->flush();


        $commonService = $this->container->get('app.common_service');
        $commons = $commonService->getSettings($currentUser,$em);
        $this->get('session')->replace(array('regles'=>$commons['regles'],'societes'=>$commons['societes'],'domaines'=>$commons['domaines']));

        return $this->redirectToRoute('offre_index');
    }

    /**
     * Finds and displays a regleUser entity.
     *
     * @Route("/view", name="regleuser_view")
     * @Method({"GET", "POST"})
     */
    public function viewAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $id = $request->request->get('id');

        $regle = $em->getRepository('RecruitmentBundle:RegleUser')->find($id);

        return $this->render('regleuser/show.html.twig', array(
            'regle' => $regle,
        ));
    }

    /**
     * Displays a form to edit an existing regleUser entity.
     *
     * @Route("/{id}/edit", name="regleuser_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, RegleUser $regleUser)
    {
        $deleteForm = $this->createDeleteForm($regleUser);
        $editForm = $this->createForm('RecruitmentBundle\Form\RegleUserType', $regleUser);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('regleuser_edit', array('id' => $regleUser->getId()));
        }

        return $this->render('regleuser/edit.html.twig', array(
            'regleUser' => $regleUser,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a regleUser entity.
     *
     * @Route("/delete/{id}", name="regleuser_delete")
     * @Method({"GET", "POST"})
     */
    public function deleteAction(Request $request, RegleUser $regleUser)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($regleUser);
        $em->flush();

        $currentUser = $this->getUser();

        $commonService = $this->container->get('app.common_service');
        $commons = $commonService->getSettings($currentUser,$em);
        $this->get('session')->replace(array('regles'=>$commons['regles'],'societes'=>$commons['societes'],'domaines'=>$commons['domaines']));

        return $this->redirectToRoute('offre_index');
    }

    /**
     * Creates a form to delete a regleUser entity.
     *
     * @param RegleUser $regleUser The regleUser entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(RegleUser $regleUser)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('regleuser_delete', array('id' => $regleUser->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
