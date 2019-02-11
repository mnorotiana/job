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
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Http\Logout\LogoutSuccessHandlerInterface;
use \Doctrine\ORM\EntityManager;

class AfterLogoutRedirection implements LogoutSuccessHandlerInterface
{
    /**
     * @var \Symfony\Component\Routing\RouterInterface
     */
    private $router;

    /**
     * @var \Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage
     */
    private $security;
    private $em;

    /**
     * @param SecurityContextInterface $security
     */
    public function __construct(RouterInterface $router, EntityManager $em, TokenStorage $security)
    {
        $this->router = $router;
        $this->security = $security;
        $this->em = $em;
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function onLogoutSuccess(Request $request)
    {        
        $ip = $request->getClientIp();
        $currentUser = $this->security->getToken()->getUser();        
        $response = new RedirectResponse($this->router->generate('offre_index')); 
        return $response;
    }
} 