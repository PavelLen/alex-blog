<?php

namespace Abuchyn\AlexBundle\Controller;

use Abuchyn\AlexBundle\Entity\Enquiry;
use Abuchyn\AlexBundle\Form\EnquiryType;
use Knp\Component\Pager\Paginator;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PagesController extends Controller
{
    //Return all posts
    public function homeAction(Request $request)
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

        return $this->render('AbuchynAlexBundle:Pages:home.html.twig', array(
            'items' => $result,
        ));
    }

    //Return all the posts from the category photo
    public function photoAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $items = $em->getRepository('AbuchynAlexBundle:Items')->findBy(['category' => 'photo_bg'], ['created' => 'DESC']);

        /** @var $paginator Paginator */
        $paginator = $this->get('knp_paginator');
        $result = $paginator->paginate(
            $items,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 5)
        );

        return $this->render('AbuchynAlexBundle:Pages:photo.html.twig', array(
            'items' => $result,
        ));
    }

    //Return all the posts from the category science
    public function scienceAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $items = $em->getRepository('AbuchynAlexBundle:Items')->findBy(['category' => 'science_bg'], ['created' => 'DESC']);

        /** @var $paginator Paginator */
        $paginator = $this->get('knp_paginator');
        $result = $paginator->paginate(
            $items,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 5)
        );

        return $this->render('AbuchynAlexBundle:Pages:science.html.twig', array(
            'items' => $result,
        ));
    }

    public function aboutAction()
    {
        return $this->render('AbuchynAlexBundle:Pages:about.html.twig');
    }

    public function contactsAction(Request $request)
    {
        $enquiry = new Enquiry();

        $form = $this->createForm(EnquiryType::class, $enquiry);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $message = \Swift_Message::newInstance()
                ->setSubject('Сообщение от pavelbuchyn.in.ua')
                ->setFrom('no-reply@pavelbuchyn.in.ua')
                ->setTo($this->container->getParameter('abuchyn_alex.emails.contacts_email'))
                ->addPart($this->renderView('AbuchynAlexBundle:Pages/contacts:contactEmail.html.twig',
                    array('enquiry' => $enquiry)),
                    'text/html');

            $this->get('mailer')->send($message);

            $this->get('session')->getFlashBag()->add('abuchyn-notice', 'Ваше сообщение было успешно отправлено. Спасибо за обращение!');

            // Redirect - This is important to prevent users re-posting
            // the form if they refresh the page
            return $this->redirect($this->generateUrl('abuchyn_alex_contacts'));
        }

        return $this->render('AbuchynAlexBundle:Pages/contacts:contacts.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function ushowAction($id)
    {
        $item = $this->getDoctrine()
            ->getRepository('AbuchynAlexBundle:Items')
            ->find($id);

        if (!$item) {
            throw $this->createNotFoundException(
                'Unable to find Blog post.'
            );
        }

        return $this->render('AbuchynAlexBundle:Pages:ushow.html.twig', array(
            'item'      => $item,
        ));
    }
}
