<?php

namespace Abuchyn\AlexBundle\Controller;

use Knp\Component\Pager\Paginator;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends Controller
{

    public function adminAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $items = $em->getRepository('AbuchynAlexBundle:Items')->findBy([], ['created' => 'DESC']);

        /** @var $paginator Paginator */
        $paginator = $this->get('knp_paginator');
        $result = $paginator->paginate(
            $items,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 5)
        );

        return $this->render('AbuchynAlexBundle:Admin:admin.html.twig', array(
            'items' => $result,
        ));
    }

}