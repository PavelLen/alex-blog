<?php

namespace Abuchyn\AlexBundle\Controller;


use Knp\Component\Pager\Paginator;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SearchController extends Controller
{
    public function searchAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $data = $request->query->get('search');

        $items = $em->getRepository('AbuchynAlexBundle:Items')
            ->createQueryBuilder('s')
            ->where('s.title LIKE :title')
            ->setParameter('title', '%'.$data.'%')
            ->getQuery()
            ->getResult();

        if (!$items) {
            return $this->redirectToRoute('not_found');
        }

        /** @var $paginator Paginator */
        $paginator = $this->get('knp_paginator');
        $result = $paginator->paginate(
            $items,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 5)
        );

        return $this->render('AbuchynAlexBundle:Pages:search.html.twig', [
           'items' => $result
        ]);
    }

    public function notFoundAction()
    {
        return $this->render('AbuchynAlexBundle:Pages/errors:not_found.html.twig');
    }
}