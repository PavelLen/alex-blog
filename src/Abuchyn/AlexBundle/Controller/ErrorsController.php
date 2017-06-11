<?php

namespace Abuchyn\AlexBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ErrorsController extends Controller
{
    public function notFoundAction()
    {
        return $this->render('AbuchynAlexBundle:Pages/errors:not_found.html.twig');
    }

    public function maintenanceAction()
    {
        return $this->render('AbuchynAlexBundle:Pages/errors:maintenance.html.twig');
    }
}