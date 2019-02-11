<?php

namespace UserBundle\Controller;

use UserBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use RecruitmentBundle\Command\SocketCommand;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\NullOutput;

/**
 * User controller.
 *
 * @Route("utilisateur")
 */
class UserController extends Controller
{
    /**
     * Lists all user entities.
     *
     * @Route("/list", name="user_list")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $users = $em->getRepository('UserBundle:User')->findAll();

        $user = new User();
        $form = $this->createForm('UserBundle\Form\RegistrationType', $user);

        return $this->render('user/index.html.twig', array(
            'users' => $users,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a new user entity.
     *
     * @Route("/new", name="user_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = new User();
        $id = $request->request->get('id_user');
        if($id)
        {
            $user = $em->getRepository('UserBundle:User')->find($id);
        }
        
        $form = $this->createForm('UserBundle\Form\RegistrationType', $user);
        $form->handleRequest($request);

        $role_user = $request->request->get('role_user');

        if ($form->isSubmitted() && $form->isValid()) {
            $roles = array();
            $roles[] = $role_user;
            $user->setRoles($roles);
            $user->setEnabled(1);
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('user_list');
        }

        return $this->render('user/new.html.twig', array(
            'user' => $user,
            'form' => $form->createView(),
        ));
    }


    /**
     * Displays a form to edit an existing user entity.
     *
     * @Route("/edit", name="user_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $id = $request->request->get('id');
        $user = $em->getRepository('UserBundle:User')->find($id);
        $editForm = $this->createForm('UserBundle\Form\RegistrationType', $user);
        $editForm->handleRequest($request);

        return $this->render('user/edit.html.twig', array(
            'user' => $user,
            'form' => $editForm->createView(),
        ));
    }

    /**
     * Deletes a user entity.
     *
     * @Route("/delete/{id}", name="user_delete")
     * @Method({"GET","POST"})
     */
    public function deleteAction(Request $request, User $user)
    {       
        $em = $this->getDoctrine()->getManager();
        $user->setEnabled(0);
        $em->persist($user);
        $em->flush();

        return $this->redirectToRoute('user_list');
    }

    /**
     * Activate a user entity.
     *
     * @Route("/activate/{id}", name="user_activate")
     * @Method({"GET","POST"})
     */
    public function activateAction(Request $request, User $user)
    {       
        $em = $this->getDoctrine()->getManager();
        $user->setEnabled(1);
        $em->persist($user);
        $em->flush();

        return $this->redirectToRoute('user_list');
    }

    /**
     * Init chat.
     *
     * @Route("/init-chat", name="init_chat")
     * @Method({"GET","POST"})
     */
    public function initChatAction(Request $request)
    {       
        $username = $request->request->get('username');

        $command = new SocketCommand();
        $command->setContainer($this->container);
        $input = new ArrayInput(array('username' => $username));
        $output = new NullOutput();
        $resultCode = $command->run($input, $output);

        return $this->render('user/chat.html.twig', array(
            'username' => $username
        ));
    }

    /**
     * Creates a form to delete a user entity.
     *
     * @param User $user The user entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(User $user)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('user_delete', array('id' => $user->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Lists all user entities.
     *
     * @Route("/list_message", name="message_list")
     * @Method({"GET","POST"})
     */
    public function messageAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $channel = $request->request->get('channel');
        $infos = explode("-", $channel);
        $nb = count($infos);
        $sender = $infos[$nb-1];
        $receiver = $infos[$nb-2];      

        $user = $this->getUser();
        $user_id = $user->getId();
        $correspondant = null;
        if($user_id == $sender)
        {
            $correspondant = $em->getRepository('UserBundle:User')->find($receiver);
        }
        else
        {
            $correspondant = $em->getRepository('UserBundle:User')->find($sender);
        }

        $discussions = $em->getRepository('UserBundle:Message')->getDiscussion($sender,$receiver);
        $messages[$channel] = $discussions;

        return $this->render('user/message.html.twig', array(
            'messages' => $messages,
            'channel'=>$channel,
            'online'=>$correspondant
        ));
    }

    /**
     * Lists all online user entities.
     *
     * @Route("/list_online/{id}", name="online_list")
     * @Method("GET")
     */
    public function onlineAction($id=0)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $role_user = 'ROLE_CANDIDAT';
        if($this->isGranted('ROLE_SOCIETE'))
        {
            $role_user = 'ROLE_SOCIETE';
        }
        elseif($this->isGranted('ROLE_DGPE'))
        {
            $role_user = 'ROLE_DGPE';
        }
        $onlines = $em->getRepository('UserBundle:User')->getActive($role_user);
        
        return $this->render('user/online.html.twig', array(
            'onlines'=>$onlines
        ));
    }
}
