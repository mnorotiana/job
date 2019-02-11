<?php

namespace RecruitmentBundle\Controller;

use RecruitmentBundle\Entity\Region;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Region controller.
 *
 * @Route("region")
 */
class RegionController extends Controller
{
    /**
     * Lists all region entities.
     *
     * @Route("/", name="region_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();         

        $regions = $em->getRepository('RecruitmentBundle:Region')->findAll();

        $nbOffre = 0;
        $nbOffre = $em->getRepository('RecruitmentBundle:Offre')->countAllOffre();        

        return $this->render('region/index.html.twig', array(
            'regions' => $regions,
            'nbOffre'=>$nbOffre
        ));
    }

    /**
     * Creates a new region entity.
     *
     * @Route("/new", name="region_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $region = new Region();
        $form = $this->createForm('RecruitmentBundle\Form\RegionType', $region);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($region);
            $em->flush();

            return $this->redirectToRoute('region_index');
        }

        $nbOffre = 0;

        $nbOffre = $em->getRepository('RecruitmentBundle:Offre')->countAllOffre();
        return $this->render('region/new.html.twig', array(
            'region' => $region,
            'form' => $form->createView(),
            'nbOffre'=>$nbOffre
        ));
    }

    /**
     * Finds and displays a region entity.
     *
     * @Route("/{id}", name="region_show")
     * @Method("GET")
     */
    public function showAction(Region $region)
    {
        $deleteForm = $this->createDeleteForm($region);

        return $this->render('region/show.html.twig', array(
            'region' => $region,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing region entity.
     *
     * @Route("/{id}/edit", name="region_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Region $region)
    {
        $deleteForm = $this->createDeleteForm($region);
        $editForm = $this->createForm('RecruitmentBundle\Form\RegionType', $region);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('region_index');
        }

        $em = $this->getDoctrine()->getManager();
        $nbOffre = 0;
        $nbOffre = $em->getRepository('RecruitmentBundle:Offre')->countAllOffre();
        return $this->render('region/edit.html.twig', array(
            'region' => $region,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'nbOffre'=>$nbOffre
        ));
    }

    /**
     * Deletes a region entity.
     *
     * @Route("/{id}/delete", name="region_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Region $region)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($region);
        $em->flush();

        return $this->redirectToRoute('region_index');
    }

    /**
     * Creates a form to delete a region entity.
     *
     * @param Region $region The region entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Region $region)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('region_delete', array('id' => $region->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
