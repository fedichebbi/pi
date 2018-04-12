<?php

namespace PiBundle\Controller;

use PiBundle\Entity\Produit;
use PiBundle\Entity\Promotion;
use PiBundle\Entity\rate;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Promotion controller.
 *
 */
class PromotionController extends Controller
{
    /**
     * Lists all promotion entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $promotions = $em->getRepository('PiBundle:Promotion')->findAll();

        return $this->render('promotion/index.html.twig', array(
            'promotions' => $promotions,
        ));
    }
    public function indexfrontAction()
    {
        $em = $this->getDoctrine()->getManager();

        $promotions = $em->getRepository('PiBundle:Promotion')->findAll();

        foreach($promotions as $r)
        {$datenow=new \DateTime();
            $d1=$datenow->format('Y-m-d');
            $d2=$r->getDateFin()->format('Y-m-d');

            if($d1>$d2)
            {
                $em=$this->getDoctrine()->getManager();
                $em->remove($r);
                $em->flush();
            }

        }
        $promotions=$this->getDoctrine()->getRepository('PiBundle:Promotion')->findAll();
        return $this->render('promotion/indexfront.html.twig', array(
            'promotions' => $promotions,
        ));
    }
    /**
     * Creates a new promotion entity.
     *
     */
    public function newAction(Request $request)
    {
        $promotion = new Promotion();
        $form = $this->createForm('PiBundle\Form\PromotionType', $promotion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $prod=$this->getDoctrine()->getRepository("PiBundle:Produit")->find($promotion->getProduit());
            $promotion->setNouvPrix($prod->getPrix()-(($prod->getPrix()/100)*$promotion->getRemise()));

            $em = $this->getDoctrine()->getManager();
            $em->persist($promotion);
            $em->flush();

            return $this->redirectToRoute('promotion_show', array('id' => $promotion->getId()));
        }

        return $this->render('promotion/new.html.twig', array(
            'promotion' => $promotion,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a promotion entity.
     *
     */
    public function showAction(Promotion $promotion)
    {
        $deleteForm = $this->createDeleteForm($promotion);

        return $this->render('promotion/show.html.twig', array(
            'promotion' => $promotion,
            'delete_form' => $deleteForm->createView(),
        ));
    }
    public function showfrontAction(Promotion $promotion)
    {
        $deleteForm = $this->createDeleteForm($promotion);

        return $this->render('promotion/showfront.html.twig', array(
            'promotion' => $promotion,
            'delete_form' => $deleteForm->createView(),
        ));
    }
    public function testAction()
    {

        return $this->render('promotion/test.html.twig');
    }
    public function rateAction(Request $request)
    {
        if($request->isXmlHttpRequest()||$request->request->get('some_var_name')){
            //make something curious, get some unbelieveable data
$promo=$this->getDoctrine()->getRepository('PiBundle:Promotion')->find($request->request->get('id'));
            $rateold=$this->getDoctrine()->getRepository("PiBundle:rate")->findOneBy(array('idpromo'=>1,"idpromo"=>$request->request->get('id')));//1 howa yetbadel b iduser+idpromo
            if($rateold!=null)
            {$rateold->setNote($request->request->get('some_var_name'));
                $this->getDoctrine()->getManager()->flush();
            }else{
                $rate=new rate();
                $rate->setIduser(1);
                $rate->setIdpromo($promo);
            $rate->setNote($request->request->get('some_var_name'));
            $this->getDoctrine()->getManager()->persist($rate);
            $this->getDoctrine()->getManager()->flush();}
            $arrData = ['output' => 'here the result which will appear in div'];
            return new JsonResponse($arrData);
        }
        return $this->render('promotion/test.html.twig');

    }

    /**
     * Displays a form to edit an existing promotion entity.
     *
     */
    public function editAction(Request $request, Promotion $promotion)
    {
        $deleteForm = $this->createDeleteForm($promotion);
        $editForm = $this->createForm('PiBundle\Form\PromotionType', $promotion);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('promotion_edit', array('id' => $promotion->getId()));
        }

        return $this->render('promotion/edit.html.twig', array(
            'promotion' => $promotion,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a promotion entity.
     *
     */
    public function deleteAction(Request $request, Promotion $promotion)
    {
        $form = $this->createDeleteForm($promotion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($promotion);
            $em->flush();
        }

        return $this->redirectToRoute('promotion_index');
    }

    /**
     * Creates a form to delete a promotion entity.
     *
     * @param Promotion $promotion The promotion entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Promotion $promotion)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('promotion_delete', array('id' => $promotion->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
