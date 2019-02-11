<?php

namespace RecruitmentBundle\Controller;

use RecruitmentBundle\Entity\Profil;
use RecruitmentBundle\Entity\Candidature;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Profil controller.
 *
 * @Route("profil")
 */
class ProfilController extends Controller
{
    /**
     * Lists all profil entities.
     *
     * @Route("/list/{type}", name="profil_index",defaults={"type": "tous"})
     * @Method({"GET","POST"})
     */
    public function indexAction(Request $Request,$type="candidat")
    {
        $em = $this->getDoctrine()->getManager();

        $profils = $em->getRepository('RecruitmentBundle:Profil')->findAll();

        $em = $this->getDoctrine()->getManager();

        $nbCandidatures = 0;

        $nbOffre = 0;
        $nbOpen = 0;
        $nbClosed = 0;
        $nbDraft = 0;

        $nbNew = 0;
        $nbOngoing = 0;
        $nbFinished = 0;

        $currentUser = $this->getUser();

        $domaines = $this->get('session')->get('domaines');
        $societes = $this->get('session')->get('societes');
        $regles = $this->get('session')->get('regles');

        $profils = array();

        if($type == "candidat")
        {
            if($this->isGranted('ROLE_SOCIETE'))
            {
                $profils = $em->getRepository('RecruitmentBundle:Profil')->getCandidatSociete($currentUser);
            }
            elseif($this->isGranted('ROLE_DGPE') || $this->isGranted('ROLE_ADMIN'))
            {
                $profils = $em->getRepository('RecruitmentBundle:Profil')->findAll();
            }
        }
        else
        {
        	$profils = $em->getRepository('UserBundle:User')->findByRole('ROLE_SOCIETE');
        }        

        if($currentUser && $this->isGranted('ROLE_SOCIETE'))
        {
        	$nbOffre = $em->getRepository('RecruitmentBundle:Offre')->countOffre(null,null,$currentUser);
            $nbOpen = $em->getRepository('RecruitmentBundle:Offre')->countOffreByStatus(null,null,'published',$currentUser);
            $nbClosed = $em->getRepository('RecruitmentBundle:Offre')->countOffreByStatus(null,null,'closed',$currentUser);
            $nbDraft = $em->getRepository('RecruitmentBundle:Offre')->countOffreByStatus(null,null,'draft',$currentUser);

            $nbNew = $em->getRepository('RecruitmentBundle:Candidature')->countCandidatureByStatus('new',$currentUser);
            $nbOngoing = $em->getRepository('RecruitmentBundle:Candidature')->countCandidatureByStatus('ongoing',$currentUser);
            $nbFinished = $em->getRepository('RecruitmentBundle:Candidature')->countCandidatureByStatus('finished',$currentUser);
            $nbCandidatures = $em->getRepository('RecruitmentBundle:Candidature')->countSocieteCandidature($currentUser);
        }       

        $domaines_all = $em->getRepository('RecruitmentBundle:Domaine')->findAll();
        $societes_all = $em->getRepository('UserBundle:User')->findByRole('ROLE_SOCIETE');
        $regions_all = $em->getRepository('RecruitmentBundle:Region')->findAll();
        $onlines = $em->getRepository('UserBundle:User')->getActive();
        return $this->render('profil/index.html.twig', array(
            'profils' => $profils,
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
            'type'=>$type,
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
     * Creates a new profil entity.
     *
     * @Route("/new", name="profil_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $nbCandidatures = 0;

        $nbOffre = 0;
        $nbOpen = 0;
        $nbClosed = 0;
        $nbDraft = 0;
        $nbNew = 0;
        $nbOngoing = 0;
        $nbFinished = 0;

        $currentUser = $this->getUser();
        $domaines = $this->get('session')->get('domaines');
        $societes = $this->get('session')->get('societes');
        $regles = $this->get('session')->get('regles');

        if($currentUser && $this->isGranted('ROLE_SOCIETE'))
        {
            $nbOffre = $em->getRepository('RecruitmentBundle:Offre')->countOffre(null,null,$currentUser);
            $nbOpen = $em->getRepository('RecruitmentBundle:Offre')->countOffreByStatus(null,null,'published',$currentUser);
            $nbClosed = $em->getRepository('RecruitmentBundle:Offre')->countOffreByStatus(null,null,'closed',$currentUser);
            $nbDraft = $em->getRepository('RecruitmentBundle:Offre')->countOffreByStatus(null,null,'draft',$currentUser);

            $nbNew = $em->getRepository('RecruitmentBundle:Candidature')->countCandidatureByStatus('new',$currentUser);
            $nbOngoing = $em->getRepository('RecruitmentBundle:Candidature')->countCandidatureByStatus('ongoing',$currentUser);
            $nbFinished = $em->getRepository('RecruitmentBundle:Candidature')->countCandidatureByStatus('finished',$currentUser);
            $nbCandidatures = $em->getRepository('RecruitmentBundle:Candidature')->countSocieteCandidature($currentUser);
        }

        $currentUser = $this->getUser();
        $profil = $em->getRepository('RecruitmentBundle:Profil')->findOneBy(array('candidat'=>$currentUser));
        if(!$profil)
        {
            $profil = new Profil();            
        } 

        $form = $this->createForm('RecruitmentBundle\Form\ProfilType', $profil);
        $form->handleRequest($request);
        $offre = null;
        $profil->setCandidat($currentUser);

        if ($form->isSubmitted() && $form->isValid()) {
            $directory = $request->server->get('DOCUMENT_ROOT').$request->getBasePath()."/upload";            
            $cv = $form['cv']->getData();

            $offre_id = $request->request->get('offre');
            if($offre_id)
            {
                $offre = $em->getRepository('RecruitmentBundle:Offre')->find($offre_id);
            }

            if($cv)
            {
                $cv->move($directory, $cv->getClientOriginalName());
                $profil->setCv($cv->getClientOriginalName()); 
            }   

            $lm = $form['lm']->getData();
            if($lm)
            {
                $lm->move($directory, $lm->getClientOriginalName());
                $profil->setLm($lm->getClientOriginalName()); 
            }

            $diplome = $form['diplome']->getData();
            if($diplome)
            {
                $diplome->move($directory, $diplome->getClientOriginalName());
                $profil->setDiplome($diplome->getClientOriginalName()); 
            }      


            $domaine = $profil->getDomaineCompetence();
            if($domaine)
            {
                $domaine_libelle = $domaine->getLibelle();
                $profil->setDomaineCompetence($domaine_libelle);
            }

            $domaine1 = $profil->getDomainePoste1();
            if($domaine1)
            {
                $domaine_libelle1 = $domaine1->getLibelle();
                $profil->setDomainePoste1($domaine_libelle1);
            }

            $domaine2 = $profil->getDomainePoste2();
            if($domaine2)
            {
                $domaine_libelle2 = $domaine2->getLibelle();
                $profil->setDomainePoste2($domaine_libelle2);
            }            
           
            $em = $this->getDoctrine()->getManager();
            $em->persist($profil);
            $em->flush();

            if($form->get('step4')->isClicked())
            {
                $candidature = $em->getRepository('RecruitmentBundle:Candidature')->findOneBy(array('offre'=>$offre,'candidat'=>$profil));     
                if(!$candidature)
                {
                    $candidature = new Candidature();
                    $candidature->setOffre($offre);
                    $candidature->setCandidat($profil);
                }
                $candidature->setStatut('new');
                $candidature->setDateReception(new \DateTime());
                $em->persist($candidature);
                $em->flush();


                // envoi mail pour confirmation reception candidature aux candidats
                $candidatInfo = $candidature->getCandidat();
                $offreInfo = $candidature->getOffre();
                $candidatEmail = $candidatInfo->getEmail();
                $candidatNom = $candidatInfo->getNom()." ".$candidatInfo->getPrenom();
                if($candidatEmail)
                {
                    $zHtml = "<p>Chèr(e) ".$candidatNom."</p>";
                    $zHtml .= "<p>Nous accusons réception de votre candidature au poste de ".$offreInfo->getIntitule()." chez ".$offreInfo->getUser()->getNom()."</p>";
                     $zHtml .= "<p>Nous vous remercions pour l'intérêt que vous portez à notre Société.</p>";
                    $zHtml = "<p>Cordialement,</p>";
                    $zHtml = "<p>".$offreInfo->getUser()->getNom()."</p>";

                    $message = \Swift_Message::newInstance()
                      ->setSubject("Suivi de votre candidature")
                      ->setFrom('admin@votresite.com')
                      ->setTo($candidatEmail)
                      ->setBody($zHtml);

                    $this->get('mailer')->send($message);
                }

                return $this->redirectToRoute('candidature_index');
            }
            else
            {
                $candidature = $em->getRepository('RecruitmentBundle:Candidature')->findOneBy(array('offre'=>$offre,'candidat'=>$profil));
                if(!$candidature)
                {
                    $candidature = new Candidature();
                    $candidature->setOffre($offre);
                    $candidature->setCandidat($profil);
                }
                $candidature->setStatut('draft');
                $em->persist($candidature);
                $em->flush();
            }

           //return $this->redirectToRoute('profil_new');
        }

        $domaines_all = $em->getRepository('RecruitmentBundle:Domaine')->findAll();
        $societes_all = $em->getRepository('UserBundle:User')->findByRole('ROLE_SOCIETE');
        $regions_all = $em->getRepository('RecruitmentBundle:Region')->findAll();
        $onlines = $em->getRepository('UserBundle:User')->getActive();
        return $this->render('profil/new.html.twig', array(
            'profil' => $profil,
            'form' => $form->createView(),
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
            'offre'=>$offre,
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
     * Finds and displays a profil entity.
     *
     * @Route("/{id}", name="profil_show")
     * @Method("GET")
     */
    public function showAction(Profil $profil)
    {
        $deleteForm = $this->createDeleteForm($profil);

        return $this->render('profil/show.html.twig', array(
            'profil' => $profil,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing profil entity.
     *
     * @Route("/{id}/edit", name="profil_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Profil $profil)
    {
        $deleteForm = $this->createDeleteForm($profil);
        $editForm = $this->createForm('RecruitmentBundle\Form\ProfilType', $profil);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('profil_edit', array('id' => $profil->getId()));
        }

        return $this->render('profil/edit.html.twig', array(
            'profil' => $profil,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a profil entity.
     *
     * @Route("/delete/{id_user}", name="profil_delete")
     * @Method({"GET","POST"})
     */
    public function deleteAction(Request $request,$id_user=0)
    {        
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('UserBundle:User')->find($id_user);
        $user->setEnabled(0);
        $em->persist($user);
        $em->flush();

        return $this->redirectToRoute('profil_index');
    }

    /**
     * Deletes a profil entity.
     *
     * @Route("/activate/{id_user}", name="profil_activate")
     * @Method({"GET","POST"})
     */
    public function activateAction(Request $request,$id_user=0)
    {        
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('UserBundle:User')->find($id_user);
        $user->setEnabled(1);
        $em->persist($user);
        $em->flush();

        return $this->redirectToRoute('profil_index');
    }

    /**
     * Creates a form to delete a profil entity.
     *
     * @param Profil $profil The profil entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Profil $profil)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('profil_delete', array('id' => $profil->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
