<?php

namespace PiBundle\Controller;

use PiBundle\Entity\Produit;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * Produit controller.
 *
 */
class ProduitController extends Controller
{
    /**
     * Lists all produit entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $produits = $em->getRepository('PiBundle:Produit')->findAll();
$em=$this->get('doctrine.orm.entity_manager');
$dql="SELECT p FROM PiBundle:Produit p";
$query=$em->createQuery($dql);
$paginator=$this->get('knp_paginator');
$pagination=$paginator->paginate(
    $query,
    $request->query->getInt('page',1),6);

        return $this->render('produit/index.html.twig', array(
            'produits' => $pagination,
        ));
    }
    public function indexfrontAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $produits = $em->getRepository('PiBundle:Produit')->findAll();
        $em=$this->get('doctrine.orm.entity_manager');
        $dql="SELECT p FROM PiBundle:Produit p WHERE p.quantite>5";
        $query=$em->createQuery($dql);
        $paginator=$this->get('knp_paginator');
        $pagination=$paginator->paginate(
            $query,
            $request->query->getInt('page',1),6);

        return $this->render('produit/indexfront.html.twig', array(
            'produits' => $pagination,
        ));
    }


    /**
     * Creates a new produit entity.
     *
     */
    public function newAction(Request $request)
    {
        $produit = new Produit();
        $form = $this->createForm('PiBundle\Form\ProduitType', $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($produit);
            $em->flush();

            return $this->redirectToRoute('produit_show', array('designation' => $produit->getDesignation()));
        }

        return $this->render('produit/new.html.twig', array(
            'produit' => $produit,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a produit entity.
     *
     */
    public function showAction(Produit $produit)
    {
        $deleteForm = $this->createDeleteForm($produit);


        return $this->render('produit/show.html.twig', array(
            'produit' => $produit,
            'delete_form' => $deleteForm->createView(),
        ));
    }
    public function showfrontAction(Produit $produit)
    {
        $deleteForm = $this->createDeleteForm($produit);

        return $this->render('produit/showfront.html.twig', array(
            'produit' => $produit,
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Displays a form to edit an existing produit entity.
     *
     */
    public function editAction(Request $request, Produit $produit)
    {
        $deleteForm = $this->createDeleteForm($produit);
        $editForm = $this->createForm('PiBundle\Form\ProduitType', $produit);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('produit_edit', array('designation' => $produit->getDesignation()));
        }

        return $this->render('produit/edit.html.twig', array(
            'produit' => $produit,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a produit entity.
     *
     */
    public function deleteAction(Request $request, Produit $produit)
    {
        $form = $this->createDeleteForm($produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($produit);
            $em->flush();
        }

        return $this->redirectToRoute('produit_index');
    }

    /**
     * Creates a form to delete a produit entity.
     *
     * @param Produit $produit The produit entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Produit $produit)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('produit_delete', array('designation' => $produit->getDesignation())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    //-----------------------------------------------------------------------------------------------------------------------------------
    public function rechercheAjaxAction(Request $request)
    {
        if ($request->isMethod("POST")) {
            if ($request->isXmlHttpRequest()) {
                $em = $this->getDoctrine()->getManager();
                $produits = $em->getRepository('PiBundle:Produit')->findAjax($request->get('text'));
                $serializer = new Serializer(
                    array(
                        new ObjectNormalizer()
                    )
                );
                $data= $serializer->normalize($produits);
                return new JsonResponse($data);
            }
        }
        return new Response();
            }

}

