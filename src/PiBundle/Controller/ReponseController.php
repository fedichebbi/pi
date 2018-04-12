<?php

namespace PiBundle\Controller;

use PiBundle\Entity\Reponce;
use PiBundle\Form\modifierR;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class ReponseController extends Controller
{
    public function indexAction()
{
    $em = $this->getDoctrine()->getManager();
    $reponses = $em->getRepository('PiBundle:Reponce')->findAll();
    return $this->render('PiBundle:Reponse:show.html.twig',array('reponses'=>$reponses));
}

    public function DetailAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $reponses = $em->getRepository('PiBundle:Reponce')->findBy(array('idQuestion'=>$id));
        return $this->render('PiBundle:Reponse:showDetailR.html.twig',array('reponses'=>$reponses,'id'=>$id));
    }


    public function AjoutAction(Request $request,$id)
    {
        $reponses = new Reponce();
        $em = $this->getDoctrine()->getManager();
        $ques=$em->find('PiBundle:Question',$id);
        $reponses->setIdQuestion($ques);

        $form = $this->createFormBuilder($reponses)
            ->add('text')
            ->add('correction')
            ->add('Ajouter',SubmitType::class)
            ->getForm();

        $form->handleRequest($request);
        if($form->isValid() && $form->isSubmitted())
        {
            $em->persist($reponses);
            $em->flush();
            return $this->redirectToRoute('reponse_detail', ['id' => $id]);
        }
        return $this->render('PiBundle:Reponse:ajout.html.twig', array('form'=>$form->createView()));
    }

    public function ModifierAction(Request $request ,Reponce $rep,$id)
    {

        $form = $this->createFormBuilder($rep)
            ->add('text')
            ->add('correction')
            ->add('Modifier',SubmitType::class)
            ->getForm();

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('reponse_show');
        }
        return $this->render('PiBundle:Reponse:modifier.html.twig',array('rep'=>$rep,
            'form'=>$form->createView()));
    }
    public function SupprimerAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $reponses = $em->getRepository(Reponce::class)->find($id);
        $em->remove($reponses);
        $em->flush();
        return $this->redirectToRoute('reponse_show');
    }
}
