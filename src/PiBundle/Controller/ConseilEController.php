<?php

namespace PiBundle\Controller;

use PiBundle\Entity\ConseilE;
use PiBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class ConseilEController extends Controller
{
    public function ajouterConseilAction(Request $request)
    {
       // $user = new User();
       // $user = $this->container->get('security.token_storage')->getToken()->getUser();

        $Conseil = new ConseilE();
        if($request->isMethod('post')){
            $Conseil->setCategorie($request->get('categorie'));
            $Conseil->setTitre($request->get('titre'));
            $Conseil->setContenu($request->get('contenu'));
           // $Conseil->setIdUser($user);
            $EM = $this->getDoctrine()->getManager();//instancier la bd
            $EM->persist($Conseil);//initialiser l'objet dans la memoire
            $EM->flush();//executer la requête
            return $this->redirectToRoute('afficher_conseilExpert');
        }
        return $this->render('PiBundle:ConseilE:ajouter_conseil.html.twig', array(
            // ...
        ));
    }

    public function afficherConseilAction()
    {
        $EM =$this->getDoctrine()->getManager();
        $conseil=$EM->getRepository("PiBundle:ConseilE")->findAll();

        return $this->render('PiBundle:ConseilE:afficher_conseil.html.twig', array(
            'conseils'=>$conseil
        ));
    }

public function affichercateorieConseilAction()
{
    return $this->render('PiBundle:ConseilE:listeCategorie_conseil.html.twig', array(

    ));
}

    public function afficherPediatreConseilAction(Request $request)
    {
        $EM=$this->getDoctrine()->getManager();
        $conseil=$EM->getRepository("PiBundle:ConseilE")->DQLPediatre();
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $conseil, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            3/*limit per page*/
        );
        return $this->render('PiBundle:ConseilE:listePediatre_conseil.html.twig', array(
            'conseils'=>$conseil,'pagination' => $pagination
        ));
    }

    public function afficherGynecologueConseilAction(Request $request)
    {
        $EM=$this->getDoctrine()->getManager();
        $conseil=$EM->getRepository("PiBundle:ConseilE")->DQLGynecologue();
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $conseil, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            3/*limit per page*/
        );
        return $this->render('PiBundle:ConseilE:listeGynecologue_conseil.html.twig', array(
            'conseils'=>$conseil,'pagination' => $pagination
        ));
    }
    public function afficherNutritionnisteConseilAction(Request $request)
    {
        $EM=$this->getDoctrine()->getManager();
        $conseil=$EM->getRepository("PiBundle:ConseilE")->DQLNutritionniste();
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $conseil, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            3/*limit per page*/
        );
        return $this->render('PiBundle:ConseilE:listeNutritionniste_conseil.html.twig', array(
            'conseils'=>$conseil,'pagination' => $pagination
        ));
    }
    public function afficherSexologueConseilAction(Request $request)
    {
        $EM=$this->getDoctrine()->getManager();
        $conseil=$EM->getRepository("PiBundle:ConseilE")->DQLSexologue();
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $conseil, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            3/*limit per page*/
        );
        return $this->render('PiBundle:ConseilE:listeSexologue_conseil.html.twig', array(
            'conseils'=>$conseil,'pagination' => $pagination
        ));
    }
    public function afficherPsychologueConseilAction(Request $request)
    {
        $EM=$this->getDoctrine()->getManager();
        $conseil=$EM->getRepository("PiBundle:ConseilE")->DQLPsychologue();
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $conseil, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            3/*limit per page*/
        );
        return $this->render('PiBundle:ConseilE:listePsychologue_conseil.html.twig', array(
            'conseils'=>$conseil,'pagination' => $pagination
        ));
    }
    public function afficherConseilAdminAction(Request $request)
    {
        $EM =$this->getDoctrine()->getManager();
        $conseil=$EM->getRepository("PiBundle:ConseilE")->findAll();
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $conseil, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            3/*limit per page*/
        );
        return $this->render('PiBundle:ConseilE:afficher_conseilAdmin.html.twig', array(
            'conseils'=>$conseil,'pagination' => $pagination
        ));
    }
    public function afficherConseilExpertAction(Request $request)
    {
        $EM =$this->getDoctrine()->getManager();
        $conseil=$EM->getRepository("PiBundle:ConseilE")->findAll();
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $conseil, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            3/*limit per page*/
        );
        return $this->render('PiBundle:ConseilE:afficher_conseilExpert.html.twig', array(
            'conseils'=>$conseil,'pagination' => $pagination
        ));
    }

    public function detailsConseilAction(Request $request)
    {

        $titre=$request->get('titre');
        $contenu=$request->get('contenu');

        return $this->render('PiBundle:ConseilE:details_conseil.html.twig',
            array(
            'titre'=>$titre,'contenu'=>$contenu
        ));
    }
    public function detailsConseilAdminAction(Request $request)
    {

        $titre=$request->get('titre');
        $contenu=$request->get('contenu');

        return $this->render('PiBundle:ConseilE:details_conseilAdmin.html.twig',
            array(
                'titre'=>$titre,'contenu'=>$contenu
            ));
    }
    public function detailsConseilExpertAction(Request $request)
    {

        $titre=$request->get('titre');
        $contenu=$request->get('contenu');

        return $this->render('PiBundle:ConseilE:details_conseilExpert.html.twig',
            array(
                'titre'=>$titre,'contenu'=>$contenu
            ));
    }

    public function modifierConseilAction(Request $request ,$id)
    {
        var_dump($id);
        $em=$this->getDoctrine()->getManager();
        $Conseils=$em->getRepository("PiBundle:ConseilE")->find($id);
        if($request->isMethod('POST')) {
            $Conseils->setCategorie($request->get('categorie'));

            $Conseils->setTitre($request->get('titre'));
            $Conseils->setContenu($request->get('contenu'));

            $em->flush();
            return $this->redirectToRoute('afficher_conseilExpert');
        }
        return $this->render('PiBundle:ConseilE:modifier_conseil.html.twig', array(
            'conseils'=>$Conseils,
        ));
    }

    public function supprimerConseilAction($id)
    {
        $EM = $this->getDoctrine()->getManager();
        $conseil= $EM->getRepository("PiBundle:ConseilE")->find("$id");

        $EM->remove($conseil);
        $EM->flush();
        return $this->redirectToRoute('afficher_conseilExpert');

    }

}
