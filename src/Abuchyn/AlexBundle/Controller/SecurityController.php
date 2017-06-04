<?php

namespace Abuchyn\AlexBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends Controller
{
    public function loginAction(Request $request)
    {
        /** @var AuthenticationUtils $authUtils */
        $authUtils = $this->get('security.authentication_utils');
        $error = $authUtils->getLastAuthenticationError();
        $lastUserName = $authUtils->getLastUsername();

        return $this->render('AbuchynAlexBundle::login.html.twig', [
            'lastUserName' => $lastUserName,
            'error' => $error,
        ]);
    }
}