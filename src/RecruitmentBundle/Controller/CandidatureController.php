<?php

namespace RecruitmentBundle\Controller;

use RecruitmentBundle\Entity\Candidature;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Candidature controller.
 *
 * @Route("candidature")
 */
class CandidatureController extends Controller
{
    /**
     * Lists all candidature entities.
     *
     * @Route("/list/{type}", name="candidature_index",defaults={"type": "tous"})
     * @Method({"GET","POST"})
     */
    public function indexAction(Request $request,$type="tous")
    {
        $em = $this->getDoctrine()->getManager();

        $nbOffreDomaine = 0;
        $nbCandidatures = 0;

        $nbOffre = 0;
        $nbOpen = 0;
        $nbClosed = 0;
        $nbDraft = 0;

        $nbNew = 0;
        $nbOngoing = 0;
        $nbFinished = 0;

        $currentUser = $this->getUser();

        $candidatures = array();
        $listCandidatures = array();

        $profil = $em->getRepository('RecruitmentBundle:Profil')->findOneBy(array('candidat'=>$currentUser));

        $filtre = $request->request->get('filtre');
        $domaines = $this->get('session')->get('domaines');
        $societes = $this->get('session')->get('societes');
        $regles = $this->get('session')->get('regles');

        if($this->isGranted('ROLE_CANDIDAT'))
        {            
            $candidatures = $em->getRepository('RecruitmentBundle:Candidature')->getUserCandidatureByStatus($profil,$type,$filtre);

            foreach ($candidatures as $key => $candidature) {
                $offre = $candidature->getOffre()->getId();
                if(isset($listCandidatures["offre_".$offre]))
                {
                    $listCandidatures["offre_".$offre][] = $candidature;
                }
                else
                {
                    $listCandidatures["offre_".$offre] = array();
                    $listCandidatures["offre_".$offre][] = $candidature;   
                }
            }
            
        }
        elseif($this->isGranted('ROLE_SOCIETE'))
        {
        	$candidatures = $em->getRepository('RecruitmentBundle:Candidature')->getCandidatureSociete($currentUser,$type);  
            // classé par offre
            foreach ($candidatures as $key => $candidature) {
                $offre = $candidature->getOffre()->getId();
                if(isset($listCandidatures["offre_".$offre]))
                {
                    $listCandidatures["offre_".$offre][] = $candidature;
                }
                else
                {
                    $listCandidatures["offre_".$offre] = array();
                    $listCandidatures["offre_".$offre][] = $candidature;   
                }
            }
        }

        if($currentUser && $this->isGranted('ROLE_CANDIDAT'))
        {
            
            if($profil)
            {
                $domaineLib = $profil->getDomaineCompetence(); 
                $nbOffreDomaine = $em->getRepository('RecruitmentBundle:Offre')->countOffreDomaine($domaineLib,$currentUser);
                $nbNew = $em->getRepository('RecruitmentBundle:Candidature')->countUserCandidatureByStatus('new',$profil);
                $nbOngoing = $em->getRepository('RecruitmentBundle:Candidature')->countUserCandidatureByStatus('ongoing',$profil);
                $nbFinished = $em->getRepository('RecruitmentBundle:Candidature')->countUserCandidatureByStatus('finished',$profil);
                $nbCandidatures = $em->getRepository('RecruitmentBundle:Candidature')->countUserCandidature($profil);
            } 


            $nbOffre = $em->getRepository('RecruitmentBundle:Offre')->countOffreByStatus($ville,$domaine,$societe,'published');

        }
        elseif($currentUser && $this->isGranted('ROLE_SOCIETE'))
        {
            $nbOffre = $em->getRepository('RecruitmentBundle:Offre')->countOffre($ville,$domaine,$currentUser);
            $nbOpen = $em->getRepository('RecruitmentBundle:Offre')->countOffreByStatus($ville,$domaine,$currentUser,'published');
            $nbClosed = $em->getRepository('RecruitmentBundle:Offre')->countOffreByStatus($ville,$domaine,$currentUser,'closed');
            $nbDraft = $em->getRepository('RecruitmentBundle:Offre')->countOffreByStatus($ville,$domaine,$currentUser,'draft');

            $nbNew = $em->getRepository('RecruitmentBundle:Candidature')->countCandidatureByStatus('new',$currentUser);
            $nbOngoing = $em->getRepository('RecruitmentBundle:Candidature')->countCandidatureByStatus('ongoing',$currentUser);
            $nbFinished = $em->getRepository('RecruitmentBundle:Candidature')->countCandidatureByStatus('finished',$currentUser);

            $nbCandidatures = $em->getRepository('RecruitmentBundle:Candidature')->countSocieteCandidature($currentUser);
        }      

        $domaines_all = $em->getRepository('RecruitmentBundle:Domaine')->findAll();
        $societes_all = $em->getRepository('UserBundle:User')->findByRole('ROLE_SOCIETE');
        $regions_all = $em->getRepository('RecruitmentBundle:Region')->findAll();
        $onlines = $em->getRepository('UserBundle:User')->getActive();
        return $this->render('candidature/index.html.twig', array(
            'candidatures' => $candidatures,
            'nbOffre'=>$nbOffre,
            'nbOpen'=>$nbOpen,
            'nbClosed'=>$nbClosed,
            'nbDraft'=>$nbDraft,
            'nbCandidature'=>$nbCandidature,
            'nbNew'=>$nbNew,
            'nbOngoing'=>$nbOngoing,
            'nbFinished'=>$nbFinished,
            'nbOffreDomaine' => $nbOffreDomaine,
            'nbCandidatures' => $nbCandidatures,
            'listCandidatures'=>$listCandidatures,
            'type'=>$type,
            "filtre"=>$filtre,
            "domaines_session"=>$domaines,
            "societes_session"=>$societes,
            "regles_session"=>$regles,
            "domaines"=>$domaines_all,
            "societes"=>$societes_all,
            "regions"=>$regions_all,
            "onlines"=>$onlines
        ));
    }

    /**
     * Creates a new candidature entity.
     *
     * @Route("/new", name="candidature_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $candidature = new Candidature();
        $form = $this->createForm('RecruitmentBundle\Form\CandidatureType', $candidature);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($candidature);
            $em->flush();

            return $this->redirectToRoute('candidature_show', array('id' => $candidature->getId()));
        }

        return $this->render('candidature/new.html.twig', array(
            'candidature' => $candidature,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a new candidature entity.
     *
     * @Route("/treat", name="candidature_treat")
     * @Method({"GET", "POST"})
     */
    public function treatAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $id = $request->request->get('id');
        $motif = $request->request->get('motifs');
        $commentaire = $request->request->get('commentaire');
        $note = $request->request->get('note');
        $dateTest = $request->request->get('dateTest');
        $dateEntretien = $request->request->get('dateEntretien');
        $type_action = $request->request->get('type_action');

        $candidature = $em->getRepository("RecruitmentBundle:Candidature")->find($id);
        if($candidature)
        {
            if($type_action == "rejet")
            {
                $candidature->setMotifs($motif);
                $candidature->setNote($note);

                // envoi mail de rejet aux candidats
                $candidatInfo = $candidature->getCandidat();
                $offreInfo = $candidature->getOffre();
                $candidatEmail = $candidatInfo->getEmail();
                $candidatNom = $candidatInfo->getNom()." ".$candidatInfo->getPrenom();
                if($candidatEmail)
                {

                    $zHtml = "<p>Chèr(e) ".$candidatNom."</p>";
                    $zHtml .= "<p>Nous avons le regret de vous annoncer que votre candidature au poste de ".$offreInfo->getIntitule()." chez ".$offreInfo->getUser()->getNom()." n'a pas été retenue</p>";
                    $zHtml .= "Nous vous souhaitons bonne courage pour vos prochaines recherches.";
                    $zHtml = "<p>Cordialement,</p>";
                    $zHtml = "<p>".$offreInfo->getUser()->getNom()."</p>";

                    $message = \Swift_Message::newInstance()
                      ->setSubject("Suivi de votre candidature")
                      ->setFrom('admin@votresite.com')
                      ->setTo($candidatEmail)
                      ->setBody($zHtml);

                    $this->get('mailer')->send($message);
                }
            }
            elseif($type_action == "validation")
            {
                $candidature->setMotifs($commentaire);
                $candidature->setNote($note);
                // update statut offre en closed si nombre recherché atteint
                $offre = $candidature->getOffre();

                $nombre = $offre->getNombre();
                if($nombre == "")
                {
                    $nombre = 1;
                }

                // recuperation nombre candidature validé pour l'offre
                $candidatureOk = $em->getRepository('RecruitmentBundle:Candidature')->findBy(array('offre'=>$offre,'statut'=>$type_action));

                $nbOk = count($candidatureOk);

                if($nbOk == $nombre-1)
                {
                    $offre->setStatut('closed');
                    $em->persist($offre);
                    $em->flush();

                    // update candidature des autres candidats en rejeté avec motif "Poste déjà attribué"
                    $othersCandidature = $em->getRepository('RecruitmentBundle:Candidature')->getOthers($offre,$candidature);
                    foreach ($othersCandidature as $key => $oth) {

                        $candidatInfo = $oth->getCandidat();
                        $offreInfo = $oth->getOffre();
                        $oth->setStatut('rejeté');
                        $oth->setMotifs('Poste déjà attribué');
                        $em->persist($oth);
                        $em->flush();

                        // envoi mail de rejet aux candidats
                        $candidatEmail = $candidatInfo->getEmail();
                        $candidatNom = $candidatInfo->getNom()." ".$candidatInfo->getPrenom();
                        if($candidatEmail)
                        {

                            $zHtml = "<p>Chèr(e) ".$candidatNom."</p>";
                            $zHtml .= "<p>Nous avons le regret de vous annoncer que votre candidature au poste de ".$offreInfo->getIntitule()." chez ".$offreInfo->getUser()->getNom()." n'a pas été retenue</p>";
                            $zHtml .= "Nous vous souhaitons bonne courage pour vos prochaines recherches.";
                            $zHtml = "<p>Cordialement,</p>";
                            $zHtml = "<p>".$offreInfo->getUser()->getNom()."</p>";

                            $message = \Swift_Message::newInstance()
                              ->setSubject("Suivi de votre candidature")
                              ->setFrom('admin@votresite.com')
                              ->setTo($candidatEmail)
                              ->setBody($zHtml);

                            $this->get('mailer')->send($message);
                        }
                    }
                }  

                // envoi mail d'acceptation aux candidats
                $candidatInfo = $candidature->getCandidat();
                $offreInfo = $candidature->getOffre();
                $candidatEmail = $candidatInfo->getEmail();
                $candidatNom = $candidatInfo->getNom()." ".$candidatInfo->getPrenom();
                if($candidatEmail)
                {
                    $zHtml = "<p>Chèr(e) ".$candidatNom."</p>";
                    $zHtml .= "<p>Nous avons le plaisir de vous annoncer que votre candidature au poste de ".$offreInfo->getIntitule()." chez ".$offreInfo->getUser()->getNom()." a été retenue</p>";
                    $zHtml .= "Notre équipe vous contactera très prochainement pour la suite du procédure.";
                    $zHtml = "<p>Cordialement,</p>";
                    $zHtml = "<p>".$offreInfo->getUser()->getNom()."</p>";

                    $message = \Swift_Message::newInstance()
                      ->setSubject("Suivi de votre candidature")
                      ->setFrom('admin@votresite.com')
                      ->setTo($candidatEmail)
                      ->setBody($zHtml);

                    $this->get('mailer')->send($message);
                }
            }
            elseif($type_action == "test")
            {
                $candidature->setCommentaireTest($commentaire);
                $candidature->setDateTest(\DateTime::createFromFormat('d/m/Y',$dateTest));

                // envoi mail pour test aux candidats
                $candidatInfo = $candidature->getCandidat();
                $offreInfo = $candidature->getOffre();
                $candidatEmail = $candidatInfo->getEmail();
                $candidatNom = $candidatInfo->getNom()." ".$candidatInfo->getPrenom();
                $dateTest = $candidature->getDateTest()->format('d/m/Y');
                if($candidatEmail)
                {
                    $zHtml = "<p>Chèr(e) ".$candidatNom."</p>";
                    $zHtml .= "<p>Nous avons le plaisir de vous annoncer que votre profil a retenu notre attention pour le poste de ".$offreInfo->getIntitule()." chez ".$offreInfo->getUser()->getNom()."</p>";
                    $zHtml .= "<p>Ainsi, nous vous invitons à passer un test le ".$dateTest." afin de pouvoir démontrer votre compétences et pour mieux vous connaître.</p>";
                    $zHtml .= "Notre équipe vous contactera très prochainement pour plus de détails.";
                    $zHtml = "<p>Cordialement,</p>";
                    $zHtml = "<p>".$offreInfo->getUser()->getNom()."</p>";

                    $message = \Swift_Message::newInstance()
                      ->setSubject("Suivi de votre candidature")
                      ->setFrom('admin@votresite.com')
                      ->setTo($candidatEmail)
                      ->setBody($zHtml);

                    $this->get('mailer')->send($message);
                }

            }
            elseif ($type_action == "entretien") {
                $candidature->setCommentaireEntretien($commentaire);
                $candidature->setDateEntretien(\DateTime::createFromFormat('d/m/Y',$dateEntretien));

                // envoi mail pour test aux candidats
                $candidatInfo = $candidature->getCandidat();
                $offreInfo = $candidature->getOffre();
                $candidatEmail = $candidatInfo->getEmail();
                $candidatNom = $candidatInfo->getNom()." ".$candidatInfo->getPrenom();
                $dateTest = $candidature->getDateTest()->format('d/m/Y');
                if($candidatEmail)
                {
                    $zHtml = "<p>Chèr(e) ".$candidatNom."</p>";
                    $zHtml .= "<p>Nous avons le plaisir de vous annoncer que le résultat de votre test pour le poste de ".$offreInfo->getIntitule()." chez ".$offreInfo->getUser()->getNom()." est positif</p>";
                    $zHtml .= "<p>Ainsi, nous vous invitons à passer une entretien le ".$dateTest." afin de mieux vous connaître.</p>";
                    $zHtml .= "Notre équipe vous contactera très prochainement pour plus de détails.";
                    $zHtml = "<p>Cordialement,</p>";
                    $zHtml = "<p>".$offreInfo->getUser()->getNom()."</p>";

                    $message = \Swift_Message::newInstance()
                      ->setSubject("Suivi de votre candidature")
                      ->setFrom('admin@votresite.com')
                      ->setTo($candidatEmail)
                      ->setBody($zHtml);

                    $this->get('mailer')->send($message);
                }
            }  

            $candidature->setStatut($type_action);
            $em->persist($candidature);
            $em->flush();

            // @todo : envoie mail aux personnes pour l'avancement
        }        

        return $this->redirectToRoute('candidature_index');
    }

    /**
     * Finds and displays a candidature entity.
     *
     * @Route("/{id}", name="candidature_show")
     * @Method("GET")
     */
    public function showAction(Candidature $candidature)
    {
        $deleteForm = $this->createDeleteForm($candidature);

        return $this->render('candidature/show.html.twig', array(
            'candidature' => $candidature,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing candidature entity.
     *
     * @Route("/{id}/edit", name="candidature_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Candidature $candidature)
    {
        $deleteForm = $this->createDeleteForm($candidature);
        $editForm = $this->createForm('RecruitmentBundle\Form\CandidatureType', $candidature);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('candidature_edit', array('id' => $candidature->getId()));
        }

        return $this->render('candidature/edit.html.twig', array(
            'candidature' => $candidature,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a candidature entity.
     *
     * @Route("/{id}", name="candidature_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Candidature $candidature)
    {
        $form = $this->createDeleteForm($candidature);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($candidature);
            $em->flush();
        }

        return $this->redirectToRoute('candidature_index');
    }

    /**
     * Creates a form to delete a candidature entity.
     *
     * @param Candidature $candidature The candidature entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Candidature $candidature)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('candidature_delete', array('id' => $candidature->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
