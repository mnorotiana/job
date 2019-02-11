<?php
/**
 * @copyright  Copyright (c) 2009-2014 Steven TITREN - www.webaki.com
 * @package    Webaki\UserBundle\Redirection
 * @author     Steven Titren <contact@webaki.com>
 */

namespace UserBundle\Redirection;


use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use \Doctrine\ORM\EntityManager;

class AfterLoginRedirection implements AuthenticationSuccessHandlerInterface
{
    /**
     * @var \Symfony\Component\Routing\RouterInterface
     */
    private $router;
    private $container;
    private static $key;
    private $em;

    /**
     * @param RouterInterface $router
     */
    public function __construct(RouterInterface $router, EntityManager $em, $container)
    {
        self::$key = '_security.main.target_path';

        $this->router = $router;
        $this->em = $em;
        $this->container = $container;
        $this->session = $container->get('session');
    }

    /**
     * @param Request $request
     * @param TokenInterface $token
     * @return RedirectResponse
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        $route = '';

        // enregistere dans la table History pour action login

        $ip = $request->getClientIp();

        $currentUser = $this->container->get('security.token_storage')->getToken()->getUser();

        $commonService = $this->container->get('app.common_service');
        $commons = $commonService->getSettings($currentUser,$this->em);

        $this->session->set('regles',$commons['regles']);
        $this->session->set('societes',$commons['societes']);
        $this->session->set('domaines',$commons['domaines']);

        if ($this->session->has( self::$key )) {

            //set the url based on the link they were trying to access before being authenticated
            $route = $this->session->get( self::$key );

            //remove the session key
            $this->session->remove( self::$key );
            //if the referer key was never set, redirect to a default route

        } else {  

            $redirection = new RedirectResponse($this->router->generate('offre_index'));                
            return $redirection;
        }

       

        return new RedirectResponse($route);
    }
} 