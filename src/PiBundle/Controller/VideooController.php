<?php

namespace PiBundle\Controller;

use PiBundle\Entity\Video;
use PiBundle\Form\modifier;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class VideooController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $videos = $em->getRepository('PiBundle:Video')->findAll();
        return $this->render('PiBundle:Video:show.html.twig',array('videos'=>$videos));
    }

    public function AjoutAction(Request $request)
    {
        $videos = new Video();
        $form = $this->createFormBuilder($videos)
            ->add('titre')
            ->add('file',FileType::class)
            ->add('date')
            ->add('Ajouter',SubmitType::class)
            ->getForm();

        $form->handleRequest($request);
        if($form->isValid() && $form->isSubmitted())
        {
            $em = $this->getDoctrine()->getManager();

            $videos->upload();
            $em->persist($videos);
            $em->flush();
            return $this->redirectToRoute('video_show');
        }
        return $this->render('PiBundle:Video:ajout.html.twig', array('form'=>$form->createView()));
    }

    public function ModifierAction(Request $request ,Video $vdo)
    {
        $form = $this->createFormBuilder($vdo)
            ->add('titre')
            ->add('file',FileType::class)
            ->add('date')
            ->add('Modifier',SubmitType::class)
            ->getForm();
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {            $em = $this->getDoctrine()->getManager();

            $em->flush();
            return $this->redirectToRoute('video_show', array('id' => $vdo->getId()));

        }
        return $this->render('PiBundle:Video:modifier.html.twig',array('vdo'=>$vdo,
            'form'=>$form->createView()));
    }
    public function SupprimerAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $videos = $em->getRepository(Video::class)->find($id);
        $em->remove($videos);
        $em->flush();
        return $this->redirectToRoute('video_show');
    }

    public function LireAction($id){

        $em = $this->getDoctrine()->getManager();

        $video = $em->getRepository(Video::class)->find($id);

        return $this->render('PiBundle:Video:lireVideo.html.twig'
            , array('video' => $video));
    }
}
