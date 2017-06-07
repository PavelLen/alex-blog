<?php
/**
 * Created by PhpStorm.
 * User: pavellen
 * Date: 6/7/17
 * Time: 2:09 PM
 */

namespace Abuchyn\AlexBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ErrorsController extends Controller
{
    public function notFoundAction(Request $request)
    {
        return $this->render('AbuchynAlexBundle:Pages/errors:not_found.html.twig');
    }
}