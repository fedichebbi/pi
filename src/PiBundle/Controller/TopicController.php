<?php

namespace PiBundle\Controller;

use PiBundle\Entity\Topic;
use PiBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Topic controller.
 *
 */
class TopicController extends Controller
{
    /**
     * Lists all topic entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $topics = $em->getRepository('PiBundle:Topic')->findAll();

        return $this->render('PiBundle:topic:index.html.twig', array(
            'topics' => $topics,
        ));
    }

    /**
     * Creates a new topic entity.
     *
     */
    public function newAction(Request $request)
    {
        $topic = new Topic();
        $form = $this->createForm('PiBundle\Form\TopicType', $topic);
        $form->handleRequest($request);
        //$topic->setIdUser(1);
        $topic->setDate(new \DateTime(date('Y-m-d H:i:s')));
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($topic);
            $em->flush();

            return $this->redirectToRoute('topic_show', array('id' => $topic->getId()));
        }

        return $this->render('PiBundle:topic:new.html.twig', array(
            'topic' => $topic,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a topic entity.
     *
     */
    public function showAction(Topic $topic)
    {
        $user = new User();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $deleteForm = $this->createDeleteForm($topic);
        $em=$this->getDoctrine()->getManager();
        $commentaires=$em->getRepository('PiBundle:Commentaire')->getbyTopic($topic->getId());
        return $this->render('PiBundle:topic:show.html.twig', array(
            'topic' => $topic,
            'delete_form' => $deleteForm->createView(),
            'commentaires'=>$commentaires,
            'user'=>$user,
        ));
    }

    /**
     * Displays a form to edit an existing topic entity.
     *
     */
    public function editAction(Request $request, Topic $topic)
    {
        $deleteForm = $this->createDeleteForm($topic);
        $editForm = $this->createForm('PiBundle\Form\TopicType', $topic);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('topic_edit', array('id' => $topic->getId()));
        }

        return $this->render('PiBundle:topic:edit.html.twig', array(
            'topic' => $topic,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a topic entity.
     *
     */
    public function deleteAction(Request $request, Topic $topic)
    {
        $form = $this->createDeleteForm($topic);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($topic);
            $em->flush();
        }

        return $this->redirectToRoute('topic_index');
    }

    /**
     * Creates a form to delete a topic entity.
     *
     * @param Topic $topic The topic entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Topic $topic)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('topic_delete', array('id' => $topic->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    public function ajouterAction(Request $request)
    {
        $Topic= new Topic();
        $user = new User();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        if($request->isMethod("post")) {
            $Topic->setTitre($request->get("titre"));
            $Topic->setContenu($request->get("contenu"));
            $Topic->setType($request->get("type"));
            $Topic->setDate(new \DateTime(date('Y-m-d H:i:s')));
            $Topic->setIdUser($user->getId());
            $EM = $this->getDoctrine()->getManager();
            $EM->persist($Topic);
            $EM->flush();
            return $this->redirectToRoute('topic_index');
        }
        return $this->render('PiBundle:topic:new.html.twig', array(

        ));
    }
}
