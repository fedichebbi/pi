<?php

namespace PiBundle\Controller;

use PiBundle\Entity\Question;
use PiBundle\Form\modifierQ;
use PiBundle\Entity\Video;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class QuestionController extends Controller
{
    public function indexAction()
{
    $em = $this->getDoctrine()->getManager();
    $questions = $em->getRepository('PiBundle:Question')->findAll();
    return $this->render('PiBundle:Question:show.html.twig',array('questions'=>$questions));
}
    public function DetailAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $questions = $em->getRepository('PiBundle:Question')->findBy(array('idVideo'=>$id));
        return $this->render('PiBundle:Question:showDetail.html.twig',array('questions'=>$questions,'id'=>$id));
    }
    public function AjoutAction(Request $request,$id)
    {
        $questions = new Question();
        $em = $this->getDoctrine()->getManager();
        $vid=$em->find('PiBundle:Video',$id);
        $questions->setIdVideo($vid);

        $form = $this->createFormBuilder($questions)
            ->add('score')
            ->add('quest')
            ->add('Ajouter',SubmitType::class)
            ->getForm();

        $form->handleRequest($request);
        if($form->isValid() && $form->isSubmitted())
        {
            $em->persist($questions);
            $em->flush();

            return $this->redirectToRoute('question_detail', ['id' => $id]);
        } else {
            return $this->render('PiBundle:Question:ajout.html.twig', array('form'=>$form->createView()));
        }
    }

    public function ModifierAction(Request $request ,Question $qst)
    {

        $form = $this->createFormBuilder($qst)
            ->add('score')
            ->add('quest')
            ->add('Modifier',SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('question_show');
        }
        return $this->render('PiBundle:Question:modifier.html.twig',array('qst'=>$qst,
            'form'=>$form->createView()));
    }
    public function SupprimerAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $questions = $em->getRepository(Question::class)->find($id);
        $em->remove($questions);
        $em->flush();
        return $this->redirectToRoute('question_show');
    }


}
