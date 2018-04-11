<?php

namespace PiBundle\Controller;

use PiBundle\Entity\Reclamation;
use PiBundle\Entity\Topic;
use PiBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Reclamation controller.
 *
 */
class ReclamationController extends Controller
{
    /**
     * Lists all reclamation entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $reclamations = $em->getRepository('PiBundle:Reclamation')->findAll();

        return $this->render('reclamation/index.html.twig', array(
            'reclamations' => $reclamations,
        ));
    }

    /**
     * Creates a new reclamation entity.
     *
     */
    public function newAction(Request $request,$topic)
    {
        $user = new User();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $Topic=new Topic();
        $Topic=$em->getRepository("PiBundle:Topic")->find($topic);
        $reclamation = new Reclamation();
        $reclamation->setIdTopic($Topic);
        $reclamation->setIdUser($user);
        $reclamation->setDate(new \DateTime(date('Y-m-d H:i:s')));
            $em->persist($reclamation);
            $em->flush();
            $total=$this->calculReclamations($Topic);
        $reclamation=$em->getRepository('PiBundle:Reclamation')->getbyRecUser($Topic->getId(),$user->getId());
            if($total[0][1]<4)
        return $this->redirectToRoute('topic_show',array(
            "id"=>$topic,
            "count"=>$this->calculReclamations($Topic),
            "reclamation"=>$reclamation
        ));
           else if ($this->calculReclamations($Topic)>3)
            {
                $em->remove($Topic);
                $em->flush();
                return $this->redirectToRoute('topic_index',array(
                    "count"=>$this->calculReclamations($Topic)
                ));
            }


    }
    public function calculReclamations($topic)
    {

        $em=$this->getDoctrine()->getManager();
        $total=$em->getRepository('PiBundle:Reclamation')->getbyTopic($topic->getId());
        return $total;

    }

    /**
     * Finds and displays a reclamation entity.
     *
     */
    public function showAction(Reclamation $reclamation)
    {
        $deleteForm = $this->createDeleteForm($reclamation);

        return $this->render('reclamation/show.html.twig', array(
            'reclamation' => $reclamation,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing reclamation entity.
     *
     */
    public function editAction(Request $request, Reclamation $reclamation)
    {
        $deleteForm = $this->createDeleteForm($reclamation);
        $editForm = $this->createForm('PiBundle\Form\ReclamationType', $reclamation);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('reclamation_edit', array('id' => $reclamation->getId()));
        }

        return $this->render('reclamation/edit.html.twig', array(
            'reclamation' => $reclamation,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a reclamation entity.
     *
     */
    public function deleteAction(Request $request, Reclamation $reclamation)
    {
        $form = $this->createDeleteForm($reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($reclamation);
            $em->flush();
        }

        return $this->redirectToRoute('reclamation_index');
    }

    /**
     * Creates a form to delete a reclamation entity.
     *
     * @param Reclamation $reclamation The reclamation entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Reclamation $reclamation)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('reclamation_delete', array('id' => $reclamation->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
