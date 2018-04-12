<?php

namespace PiBundle\Controller;

use PiBundle\Entity\Suggestion;
use PiBundle\Form\SuggestionType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use PiBundle\Entity\User;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\HttpFoundation\JsonResponse;




class SuggestionController extends Controller
{
    public function AfficherAction()
    {
        $EM =$this->getDoctrine()->getManager();
        $Suggestion = $EM->getRepository("PiBundle:Suggestion")->findAll();


        return $this->render('PiBundle:suggestion:AfficherSuggestion.html.twig', array(

            'suggestions'=>$Suggestion
        ));
    }

    public function AfficherSSlisteAdminAction(Request $request)
    {
        $EM =$this->getDoctrine()->getManager();
        $Suggestion = $EM->getRepository("PiBundle:Suggestion")->findAll();
        /**
         * @var $paginator \Knp\Component\Pager\Paginator
         */
        $paginator = $this->get('knp_paginator');
        $result = $paginator->paginate(
            $Suggestion,
            $request->query->getInt('page',1),
            $request->query->getInt('limit',5)
        );
        dump(get_class($paginator));
        return $this->render('PiBundle:Suggestion:SuggestionAdmin.html.twig', array(

            'suggestions'=>$result
        ));
      /*  return $this->render('PiBundle:Suggestion:SuggestionAdmin.html.twig', array(

            'suggestions'=>$Suggestion
        ));*/
    }


    public function afficherSuggestionAction(Request $request)
    {

        $equipe = new Equipe();

        $EM = $this->getDoctrine()->getManager();
        $equipes = $EM->getRepository("AppBundle:Equipe")->findAll();
        if ($request->isXmlHttpRequest()) {
            $serializer = new Serializer(array(new ObjectNormalizer()));
            $equipes = $EM->getRepository("AppBundle:Equipe")
                ->findEquipeDql($request->get('pays'));
            $data = $serializer->normalize($equipes);
            return new JsonResponse($data);
        }

        return $this->render('GestionEquipeBundle:Equipe:afficher.html.twig', array(
            'Equipes' => $equipes,
            // ...
        ));
    }

    public function  AjouterSuggestionAction(Request $request){
        //Resquest httpfoundation
        $Suggestion = new Suggestion();
        //$user = new User();
        //$user = $this->container->get('security.token_storage')->getToken()->getUser();

        if($request->isMethod('post')){
            $Suggestion->setNom($request->get('nom'));
            $Suggestion->setAdresse($request->get('adresse'));
            $Suggestion->setHoraire($request->get('horaire'));
            $Suggestion->setTelephone($request->get('telephone'));
            $Suggestion->setType($request->get('type'));
            //$Suggestion->setIdUser($user);

            //EM == EntityManager
            $EM = $this->getDoctrine()->getManager();//instancier la bd
            //$Suggestion->setDateDispo(new \DateTime());
            $EM->persist($Suggestion);//initialiser l'objet dans la memoire
            $EM->flush();//executer la requête
            return $this->redirectToRoute('afficher_suggestion_Admin_liste');
        }

        return $this->render('PiBundle:Suggestion:ajouterSuggestion.html.twig',array(
            //..
        ));
    }

    public function Ajouter2Action(Request $request){

        $Suggestion = new Suggestion();
        $form =$this->createForm(SuggestionType::class,$Suggestion);

        $form->handleRequest($request);
        if($form->isValid()){
            $EM = $this->getDoctrine()->getManager();
            $EM->persist($Suggestion);
            $EM->flush();
            return $this->redirectToRoute('afficher_suggestion');
        }


        return $this->render('PiBundle:suggestion:ajouterSuggestionForm.html.twig',array(
            'F' =>$form->createView()
        ));
    }


    public function DeleteSuggestionAction($id){

        $EM = $this->getDoctrine()->getManager();
        $Suggestion= $EM->getRepository("PiBundle:Suggestion")->find("$id");
        $EM->remove($Suggestion);
        $EM->flush();
        return $this->redirectToRoute('afficher_suggestion_Admin_liste');
    }

    public function updateSuggestionAction(Request $request,$id){

        $EM =$this->getDoctrine()->getManager();
        $Suggestion = $EM->getRepository("PiBundle:Suggestion")->find("$id");
        $form =$this->createForm(SuggestionType::class,$Suggestion);
        $form->handleRequest($request);
        if($form->isValid()){
            //$EM->persist($Modele);
            $EM->flush();
            return $this->redirectToRoute('afficher_suggestion_Admin_liste');}
        //


        return $this->render('PiBundle:suggestion:ajouterSuggestionForm.html.twig', array(
            // ...
            'F'=>$form->createView()
        ));



    }


    public function detailSuggestionAction(Request $request) {
        $nom = $request -> get('nom');
        $adresse = $request -> get('adresse');
        $horaire = $request -> get('horaire');
        $telephone = $request -> get('telephone');
        $type = $request -> get('type');
        return $this->render("PiBundle:suggestion:detailSuggestion.html.twig",
            array('nom'=>$nom,'adresse'=>$adresse,'horaire'=>$horaire,'telephone'=>$telephone,'type'=>$type)
        );

    }

    public function detailSuggestionAdminAction(Request $request) {
        $nom = $request -> get('nom');
        $adresse = $request -> get('adresse');
        $horaire = $request -> get('horaire');
        $telephone = $request -> get('telephone');
        $type = $request -> get('type');
        return $this->render("PiBundle:suggestion:detailSuggestionAdmin.html.twig",
            array('nom'=>$nom,'adresse'=>$adresse,'horaire'=>$horaire,'telephone'=>$telephone,'type'=>$type)
        );

    }

      /*  public function rechercherDQLAction(Request $request)
    {
        //var_dump($request->getRequestFormat());
        $Suggestion=new Suggestion();
        $em = $this->getDoctrine()->getManager();
        $Suggestions = $em->getRepository("EspritParcBundle:Suggestion")
            ->findAll();
        $form = $this->createForm(SuggestionType::class, $Suggestion);
        $form->handleRequest($request);
        if ($request->isXmlHttpRequest()) {
            $serializer = new Serializer(array(new ObjectNormalizer()));
            $Suggestions = $em->getRepository("PiBundle:suggestion:Voiture")
                ->findSerieDql($request->get('type'));
            $data = $serializer->normalize($Suggestions);
            return new JsonResponse($data);
        }

        return $this->render("PiBundle:suggestion:rechercheAjax.html.twig",
            array(
                'suggestions' => $Suggestions,
                'form' => $form->createView()

            ));


    }*/


    public function dqlAffichageFestivalAction ()
    {
        $em=$this->getDoctrine()->getManager();
        $SS=$em->getRepository("PiBundle:Suggestion")
            ->AfficherFestivalDql();
        return $this->render('PiBundle:suggestion:SuggestionFestival.html.twig',array(
            'suggestions'=>$SS
        ));
    }

    public function dqlAffichageEventAction ()
    {
        $em=$this->getDoctrine()->getManager();
        $SS=$em->getRepository("PiBundle:Suggestion")
            ->AfficherEventDql();
        return $this->render('PiBundle:suggestion:SuggestionEvent.html.twig',array(
            'suggestions'=>$SS
        ));
    }



    public function RechercherdqlSuggestionAction(Request $request)
    {

        //var_dump($request->getRequestFormat());
        $Suggestion = new Suggestion();
        $em = $this->getDoctrine()->getManager();
        $Suggestions = $em->getRepository("PiBundle:Suggestion")
            ->findAll();

        if ($request->isXmlHttpRequest()) {
            $serializer = new Serializer(array(new ObjectNormalizer()));
            $Suggestions = $em->getRepository("PiBundle:Suggestion")
                ->findSuggestionDql($request->get('adresse'));
            $data = $serializer->normalize($Suggestions);
            return new JsonResponse($data);
        }
    }




}
