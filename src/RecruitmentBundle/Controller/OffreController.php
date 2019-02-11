<?php

namespace RecruitmentBundle\Controller;

use RecruitmentBundle\Entity\Offre;
use RecruitmentBundle\Entity\Profil;
use RecruitmentBundle\Entity\Domaine;
use RecruitmentBundle\Entity\Region;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Offre controller.
 *
 * @Route("offre")
 */
class OffreController extends Controller
{
    /**
     * Liste de toutes les offres
     *
     * @Route("/list/{type}/{keyword}", name="offre_index",defaults={"type": "tous","keyword":""})
     * @Method({"GET","POST"})
     */
    public function indexAction(Request $request,$type="tous",$keyword="")
    {
        $em = $this->getDoctrine()->getManager();
        $nbOffreDomaine = 0;
        $nbOffreCandidatures = 0;
        $nbOffre = 0;
        $nbOpen = 0;
        $nbClosed = 0;
        $nbDraft = 0;

        $host = $this->container->getParameter('web_socket_server.host');

        $nbNew = 0;
        $nbOngoing = 0;
        $nbFinished = 0;

        $taux_retenu = 0;
        $taux_closed = 0;
        $taux_test = 0;
        $taux_entretien = 0;
        $nb_chercheur = 0;

        $search = 0;
        $currentUser = $this->getUser();

        $regles = $this->get('session')->get('regles');
        $societes = $this->get('session')->get('societes');
        $domaines = $this->get('session')->get('domaines');

        $ville = $request->request->get('ville');
        $domaine = $request->request->get('domaine');     
        $filtre = $request->request->get('filtre');    

        $offres = array();
        $countCandidats = array();
        $noteCandidats = array();

        $offre_candidature = array();

        if ($request->isMethod('post')) {
            // recherche
            $search = 1;
        }

        $offre_candidature = $em->getRepository('RecruitmentBundle:Candidature')->getUserCandidature($currentUser);

        if($search || ($type == "tous" && ($this->isGranted('ROLE_CANDIDAT') || !$currentUser)) || $type == "opened"  )
        {
        	$offres = $em->getRepository('RecruitmentBundle:Offre')->getOffreByStatus($ville,$domaine,$filtre,'published',$currentUser);
        }
        elseif ($type == "selection_domaine") {
            $domaineLib = array();
            if($keyword != "")
            {
                $domaineLib[] = $keyword;
            }
            else
            {
                foreach ($domaines as $key => $domain) {
                    $lib = $domain->getMotCle();
                    if(!in_array($lib, $domaineLib))
                    {
                        $domaineLib[] = $lib;
                    }
                }
            }
            if(count($domaineLib) > 0)
            {
                $offres = $em->getRepository('RecruitmentBundle:Offre')->getOpenOffreDomaine($domaineLib,$currentUser);
            }
        }
        elseif ($type == "selection_societe") {     
            $societes_filtre = array();
            if($keyword != "")
            {
                $societeFilter = $em->getRepository('UserBundle:User')->findByRoleAndName("ROLE_SOCIETE",$keyword);
                $societes_filtre = $societeFilter;
            }
            else
            {
                $societes_filtre = $societes;
            }

            if(count($societes_filtre) > 0)
            {
                $offres = $em->getRepository('RecruitmentBundle:Offre')->getOpenOffreSociete($societes_filtre,$currentUser);
            }            
        }
        elseif ($type == "selection") {
            $domaineLib = array();

            foreach ($domaines as $key => $domain) {
                $lib = $domain->getMotCle();
                if(!in_array($lib, $domaineLib))
                {
                    $domaineLib[] = $lib;
                }
            }

            if(count($societes) > 0 || count($domaineLib) > 0)
            {
                $offres = $em->getRepository('RecruitmentBundle:Offre')->getOpenOffreSocietesOrDomaines($societes,$domaineLib,$currentUser);
            }
        }
        elseif ($type == "tous" && $this->isGranted('ROLE_SOCIETE')) {
        	$offres = $em->getRepository('RecruitmentBundle:Offre')->findBy(array('user'=>$currentUser));
            // recuperation nombre de candidature et note moyenne
            $candidature_offre = $em->getRepository('RecruitmentBundle:Candidature')->countCandidatureByOffre($offres);    
            foreach ($candidature_offre as $key => $value) {
                $id = $value['id'];
                $nb = $value['nb'];
                $countCandidats['offre_'.$id] = $nb;
            }

            $note_offre = $em->getRepository('RecruitmentBundle:Candidature')->getNoteAvgByOffre($offres);
            foreach ($note_offre as $key => $value) {
                $id = $value['id'];
                $nb = $value['nb'];
                $noteCandidats['offre_'.$id] = $nb;
            }
        }
        elseif($type == "tous" && ($this->isGranted('ROLE_DGPE') || $this->isGranted('ROLE_ADMIN')))
        {
            $offres = $em->getRepository('RecruitmentBundle:Offre')->getAllOffre();
            // recuperation nombre de candidature et note moyenne
            $candidature_offre = $em->getRepository('RecruitmentBundle:Candidature')->countCandidatureByOffre($offres);    
            foreach ($candidature_offre as $key => $value) {
                $id = $value['id'];
                $nb = $value['nb'];
                $countCandidats['offre_'.$id] = $nb;
            }

            $note_offre = $em->getRepository('RecruitmentBundle:Candidature')->getNoteAvgByOffre($offres);
            foreach ($note_offre as $key => $value) {
                $id = $value['id'];
                $nb = $value['nb'];
                $noteCandidats['offre_'.$id] = $nb;
            }
        }
        elseif($type == "closed")
        {
        	$offres = $em->getRepository('RecruitmentBundle:Offre')->getOffreByStatus($ville,$domaine,$societe,'closed',$currentUser);
            // recuperation nombre de candidature et note moyenne
            $candidature_offre = $em->getRepository('RecruitmentBundle:Candidature')->countCandidatureByOffre($offres);            
            $note_offre = $em->getRepository('RecruitmentBundle:Candidature')->getNoteAvgByOffre($offres);
            // recuperation nombre de candidature et note moyenne
            $candidature_offre = $em->getRepository('RecruitmentBundle:Candidature')->countCandidatureByOffre($offres);    
            foreach ($candidature_offre as $key => $value) {
                $id = $value['id'];
                $nb = $value['nb'];
                $countCandidats['offre_'.$id] = $nb;
            }

            $note_offre = $em->getRepository('RecruitmentBundle:Candidature')->getNoteAvgByOffre($offres);
            foreach ($note_offre as $key => $value) {
                $id = $value['id'];
                $nb = $value['nb'];
                $noteCandidats['offre_'.$id] = $nb;
            }
        }
        elseif($type == "draft")
        {
        	$offres = $em->getRepository('RecruitmentBundle:Offre')->getOffreByStatus($ville,$domaine,$societe,'draft',$currentUser);
        }
        
        $domaines_all = $em->getRepository('RecruitmentBundle:Domaine')->findAll();
        $societes_all = $em->getRepository('UserBundle:User')->findByRole('ROLE_SOCIETE');
        $regions_all = $em->getRepository('RecruitmentBundle:Region')->findAll();

        if($currentUser && $this->isGranted('ROLE_CANDIDAT'))
        { 
            $profilUser = $em->getRepository('RecruitmentBundle:Profil')->findOneBy(array('candidat'=>$currentUser));
            if($profilUser)
            {
                $domaineLib = $profilUser->getDomaineCompetence(); 
                $nbOffreDomaine = $em->getRepository('RecruitmentBundle:Offre')->countOffreDomaine($domaineLib,$currentUser);
                $nbNew = $em->getRepository('RecruitmentBundle:Candidature')->countUserCandidatureByStatus('new',$profilUser);
                $nbOngoing = $em->getRepository('RecruitmentBundle:Candidature')->countUserCandidatureByStatus('ongoing',$profilUser);
                $nbFinished = $em->getRepository('RecruitmentBundle:Candidature')->countUserCandidatureByStatus('finished',$profilUser);
            }                      

            $nbOffre = $em->getRepository('RecruitmentBundle:Offre')->countOffreByStatus($ville,$domaine,$societe,'published');            
            $nbCandidatures = $em->getRepository('RecruitmentBundle:Candidature')->countUserCandidature($profilUser);            

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
        elseif($currentUser && ($this->isGranted('ROLE_DGPE') || $this->isGranted('ROLE_ADMIN')))
        {
            $nbOffre = $em->getRepository('RecruitmentBundle:Offre')->countAllOffre();
            $nbOpen = $em->getRepository('RecruitmentBundle:Offre')->countAllOffreByStatus('published');
            $nbClosed = $em->getRepository('RecruitmentBundle:Offre')->countAllOffreByStatus('closed');

            if($nbOffre != 0)
            {
                $taux_closed = $nbClosed*100/$nbOffre;
            }

            $nbCandidatures = $em->getRepository('RecruitmentBundle:Candidature')->countAllCandidature();

            if($nbCandidatures != 0)
            {
                $nb_retenu = $em->getRepository('RecruitmentBundle:Candidature')->countAllOkCandidature();
                $taux_retenu = $nb_retenu*100/$nbCandidatures;

                $nb_entretien = $em->getRepository('RecruitmentBundle:Candidature')->countAllEntretienCandidature();
                $taux_entretien = $nb_entretien*100/$nbCandidatures;

                $nb_test = $em->getRepository('RecruitmentBundle:Candidature')->countAllTestCandidature();
                $taux_test = $nb_test*100/$nbCandidatures;

            }

            // nb candidat : profil en statut chercheur d'emploi
            $nb_chercheur = $em->getRepository('RecruitmentBundle:Profil')->countChercheur();
        }

        $offre = new Offre();
        $form = $this->createForm('RecruitmentBundle\Form\OffreType', $offre);

        return $this->render('offre/index.html.twig', array(
            'offres' => $offres,
            'nbOffreDomaine' => $nbOffreDomaine,
            'nbCandidatures' => $nbCandidatures,
            'nbOpen'=>$nbOpen,
            'nbClosed'=>$nbClosed,
            'nbDraft'=>$nbDraft,
            'nbOffre' => $nbOffre,
            'currentUser'=>$currentUser,
            'domaines'=>$domaines_all,
            'societes'=>$societes_all,
            'regions'=>$regions_all,
            'nbNew'=>$nbNew,
            'nbOngoing'=>$nbOngoing,
            'nbFinished'=>$nbFinished,
            'countCandidats'=>$countCandidats,
            'noteCandidats'=>$noteCandidats,
            'form' => $form->createView(),
            'offre_candidature'=>$offre_candidature,
            "taux_test"=>$taux_test,
            "taux_entretien"=>$taux_entretien,
            "taux_retenu"=>$taux_retenu,
            "taux_closed"=>$taux_closed,
            "nb_chercheur"=>$nb_chercheur,
            "search"=>$search,
            "filtre"=>$filtre,
            "domaine"=>$domaine,
            "ville"=>$ville,
            "keyword"=>$keyword,
            "type"=>$type,
            "domaines_session"=>$domaines,
            "societes_session"=>$societes,
            "regles_session"=>$regles,
            "onlines"=>$onlines
        ));        
    }

    
    /**
     * Creates a new offre entity.
     *
     * @Route("/new", name="offre_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $offre = new Offre();
        $form = $this->createForm('RecruitmentBundle\Form\OffreType', $offre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $proprio = $this->getUser();
            $offre->setUser($proprio); 
            $offre->setStatut('draft');

            $domaine = $offre->getDomaine();
            $lieu = $offre->getLieu();
            $nombre = $offre->getNombre();

            if($nombre == "")
            {
                $nombre = 1;
                $offre->setNombre($nombre);
            }

            $domaineObj = $em->getRepository('RecruitmentBundle:Domaine')->findOneByLibelle($domaine);
            if(!$domaineObj && $domaine != "")
            {
                $domaineObj = new Domaine();
                $domaineObj->setLibelle($domaine);
                $em->persist($domaineObj);
                $em->flush();
            }

            $lieuObj = $em->getRepository('RecruitmentBundle:Region')->findOneByNom($lieu);
            if(!$domaineObj && $lieu != "")
            {
                $lieuObj = new Region();
                $lieuObj->setNom($lieu);
                $em->persist($lieuObj);
                $em->flush();
            }

            $em->persist($offre);
            $em->flush();            
        }

        return $this->redirectToRoute('offre_index');
    }

    /**
     * Finds and displays a offre entity.
     *
     * @Route("/show", name="offre_show")
     * @Method("GET")
     */
    public function showAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $offre_id = $request->request->get('id');
        $offre = $em->getRepository('RecruitmentBundle:Offre')->find($offre_id);

        $editForm = $this->createForm('RecruitmentBundle\Form\OffreType', $offre);
        return $this->render('offre/edit.html.twig', array(
            'offre' => $offre,
            'edit_form' => $editForm->createView()
        ));
    }

    /**
     * Finds and displays a offre entity.
     *
     * @Route("/view", name="offre_view")
     * @Method("GET")
     */
    public function viewAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $onlines = $em->getRepository('UserBundle:User')->getActive();
        $currentUser = $this->getUser();
        $offre_id = $request->request->get('id');
        $offre = $em->getRepository('RecruitmentBundle:Offre')->find($offre_id);    
        $offre_candidature = $em->getRepository('RecruitmentBundle:Candidature')->getUserCandidature($currentUser);    
        return $this->render('offre/view.html.twig', array(
            'offre' => $offre,
            'offre_candidature'=>$offre_candidature,
            "onlines"=>$onlines
        ));
    }

    /**
     * Displays a form to edit an existing offre entity.
     *
     * @Route("/{id}/edit", name="offre_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Offre $offre)
    {
        $deleteForm = $this->createDeleteForm($offre);
        $editForm = $this->createForm('RecruitmentBundle\Form\OffreType', $offre);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            
            $this->getDoctrine()->getManager()->flush();            
        }

        return $this->redirectToRoute('offre_index');
    }

    /**
     * Displays a form to edit an existing offre entity.
     *
     * @Route("/{id}/publish", name="offre_publish")
     * @Method({"GET", "POST"})
     */
    public function publishAction(Request $request, Offre $offre)
    {
        $offre->setStatut('published');
        $offre->setDatePublication(new \DateTime());
        $em = $this->getDoctrine()->getManager();
        $em->persist($offre);
        $em->flush();

        // @todo : envoie mail aux profil ayant les compétences demandées (domaine activité)


        return $this->redirectToRoute('offre_index');
    }

    /**
     * Displays a form to edit an existing offre entity.
     *
     * @Route("/{id}/cancel", name="offre_cancel")
     * @Method({"GET", "POST"})
     */
    public function cancelAction(Request $request, Offre $offre)
    {
        $offre->setStatut('canceled');
        $em = $this->getDoctrine()->getManager();
        $em->persist($offre);
        $em->flush();
        return $this->redirectToRoute('offre_index');
    }

    /**
     * Deletes a offre entity.
     *
     * @Route("/{id}/delete", name="offre_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Offre $offre)
    {
        $form = $this->createDeleteForm($offre);
        $form->handleRequest($request);

        //if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($offre);
            $em->flush();
        //}

        return $this->redirectToRoute('offre_index');
    }

    /**
     * Creates a form to delete a offre entity.
     *
     * @param Offre $offre The offre entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Offre $offre)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('offre_delete', array('id' => $offre->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Displays a form to edit an existing offre entity.
     *
     * @Route("/{id}/apply", name="offre_apply")
     * @Method({"GET", "POST"})
     */
    public function applyAction(Request $request, Offre $offre)
    {
        // creation de dossier de candidature
        $em = $this->getDoctrine()->getManager();

        $nbOffreDomaine = 0;
        $nbOffreCandidatures = 0;
        $nbOffre = 0;
        $nbOpen = 0;
        $nbClosed = 0;
        $nbDraft = 0;

        $nbNew = 0;
        $nbOngoing = 0;
        $nbFinished = 0;

        $taux_retenu = 0;
        $taux_closed = 0;
        $taux_test = 0;
        $taux_entretien = 0;
        $nb_chercheur = 0;

        $currentUser = $this->getUser();
        $regles = $this->get('session')->get('regles');
        $societes = $this->get('session')->get('societes');
        $domaines = $this->get('session')->get('domaines');

        $domaines_all = $em->getRepository('RecruitmentBundle:Domaine')->findAll();
        $societes_all = $em->getRepository('UserBundle:User')->findByRole('ROLE_SOCIETE');
        $regions_all = $em->getRepository('RecruitmentBundle:Region')->findAll();

        $profil = $em->getRepository('RecruitmentBundle:Profil')->findOneBy(array('candidat'=>$currentUser));

        if(!$profil)
        {
            $profil = new Profil();
        }     

        $form = $this->createForm('RecruitmentBundle\Form\ProfilType', $profil);
        $form->handleRequest($request);

        if($currentUser && $this->isGranted('ROLE_CANDIDAT'))
        {
            $domaineLib = $profil->getDomaineCompetence(); 
            $nbOffreDomaine = $em->getRepository('RecruitmentBundle:Offre')->countOffreDomaine($domaineLib,$currentUser);

            if($profil && $profil->getId())
            {   
                $nbNew = $em->getRepository('RecruitmentBundle:Candidature')->countUserCandidatureByStatus('new',$profil);

                $nbOngoing = $em->getRepository('RecruitmentBundle:Candidature')->countUserCandidatureByStatus('ongoing',$profil);

                $nbFinished = $em->getRepository('RecruitmentBundle:Candidature')->countUserCandidatureByStatus('finished',$profil);
                $nbCandidatures = $em->getRepository('RecruitmentBundle:Candidature')->countUserCandidature($profil);
            }             

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
        elseif($currentUser && ($this->isGranted('ROLE_DGPE') || $this->isGranted('ROLE_ADMIN')))
        {
            $nbOffre = $em->getRepository('RecruitmentBundle:Offre')->countAllOffre();
            $nbOpen = $em->getRepository('RecruitmentBundle:Offre')->countAllOffreByStatus('published');
            $nbClosed = $em->getRepository('RecruitmentBundle:Offre')->countAllOffreByStatus('closed');

            if($nbOffre != 0)
            {
                $taux_closed = $nbClosed*100/$nbOffre;
            }

            $nbCandidatures = $em->getRepository('RecruitmentBundle:Candidature')->countAllCandidature();

            if($nbCandidatures != 0)
            {
                $nb_retenu = $em->getRepository('RecruitmentBundle:Candidature')->countAllOkCandidature();
                $taux_retenu = $nb_retenu*100/$nbCandidatures;

                $nb_entretien = $em->getRepository('RecruitmentBundle:Candidature')->countAllEntretienCandidature();
                $taux_entretien = $nb_entretien*100/$nbCandidatures;

                $nb_test = $em->getRepository('RecruitmentBundle:Candidature')->countAllTestCandidature();
                $taux_test = $nb_test*100/$nbCandidatures;

            }

            // nb candidat : profil en statut chercheur d'emploi
            $nb_chercheur = $em->getRepository('RecruitmentBundle:Profil')->countChercheur();

        }

        $domaines_all = $em->getRepository('RecruitmentBundle:Domaine')->findAll();
        $societes_all = $em->getRepository('UserBundle:User')->findByRole('ROLE_SOCIETE');
        $regions_all = $em->getRepository('RecruitmentBundle:Region')->findAll();
        $onlines = $em->getRepository('UserBundle:User')->getActive();

        return $this->render('profil/new.html.twig', array(
            'profil' => $profil,
            'offre'=>$offre,
            'form' => $form->createView(),
            'nbOffreDomaine' => $nbOffreDomaine,
            'nbCandidatures' => $nbCandidatures,
            'nbOpen'=>$nbOpen,
            'nbClosed'=>$nbClosed,
            'nbDraft'=>$nbDraft,
            'nbOffre' => $nbOffre,
            'currentUser'=>$currentUser,
            'nbNew'=>$nbNew,
            'nbOngoing'=>$nbOngoing,
            'nbFinished'=>$nbFinished,
            "taux_test"=>$taux_test,
            "taux_entretien"=>$taux_entretien,
            "taux_retenu"=>$taux_retenu,
            "taux_closed"=>$taux_closed,
            "nb_chercheur"=>$nb_chercheur,
            "domaines"=>$domaines_all,
            "societes"=>$societes_all,
            "regions"=>$regles_all,
            "domaines_session"=>$domaines,
            "societes_session"=>$societes,
            "regles_session"=>$regles,
            "onlines"=>$onlines
        ));
    }
}
