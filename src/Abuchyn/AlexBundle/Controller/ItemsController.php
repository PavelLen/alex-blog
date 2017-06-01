<?php

namespace Abuchyn\AlexBundle\Controller;

use Abuchyn\AlexBundle\Entity\Items;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;

/**
 * Item controller.
 *
 * @Route("admin")
 */
class ItemsController extends Controller
{
    /**
     * Creates a new item entity.
     *
     * @Route("/new", name="items_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $item = new Items();
        $form = $this->createForm('Abuchyn\AlexBundle\Form\ItemsType', $item);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $item->setCreated(new \DateTime());

            /** @var UploadedFile $file */
            $file = $item->getImage();

            // Generate a unique name for the file before saving it
            $fileName = md5(uniqid()).'.'.$file->guessExtension();

            // Move the file to the directory where images are stored
            $file->move(
                $this->getParameter('images_directory'),
                $fileName
            );

            // Update the 'image' property
            // instead of its contents
            $item->setImage($fileName);

            $em->persist($item);
            $em->flush();

            return $this->redirectToRoute('items_show', array('id' => $item->getId()));
        }

        return $this->render('AbuchynAlexBundle:Admin/items:new.html.twig', array(
            'item' => $item,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a item entity.
     *
     * @Route("/{id}", name="items_show")
     * @Method("GET")
     */
    public function showAction(Items $item)
    {
        $deleteForm = $this->createDeleteForm($item);

        return $this->render('AbuchynAlexBundle:Admin/items:show.html.twig', array(
            'item' => $item,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing item entity.
     *
     * @Route("/{id}/edit", name="items_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Items $item)
    {
        $deleteForm = $this->createDeleteForm($item);

        /**
         * Find old image name
         * @var $em
         */
        $em = $this->getDoctrine()->getManager();
        $a = $em->find(Items::class, $item);
        $oldImg = $a->getImage();

        $editForm = $this->createForm('Abuchyn\AlexBundle\Form\ItemsType', $item);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $item->setUpdated(new \DateTime());

            if (!is_null($item->getImage())){
                /** @var UploadedFile $file */
                $file = $item->getImage();

                // Generate a unique name for the file before saving it
                $fileName = md5(uniqid()).'.'.$file->guessExtension();

                // Move the file to the directory where images are stored
                $file->move(
                    $this->getParameter('images_directory'),
                    $fileName
                );

                // Update the 'image' property
                // instead of its contents
                $item->setImage($fileName);
            } else {
                $item->setImage($oldImg);
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('items_edit', array('id' => $item->getId()));
        }

        return $this->render('AbuchynAlexBundle:Admin/items:edit.html.twig', array(
            'item' => $item,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a item entity.
     *
     * @Route("/{id}", name="items_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Items $item)
    {
        $form = $this->createDeleteForm($item);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($item);
            $em->flush();
        }

        return $this->redirectToRoute('abuchyn_alex_admin');
    }

    /**
     * Creates a form to delete a item entity.
     *
     * @param Items $item The item entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Items $item)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('items_delete', array('id' => $item->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
