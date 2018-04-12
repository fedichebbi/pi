<?php

namespace PiBundle\Controller;

use PiBundle\Entity\BabySitter;
use PiBundle\Form\BabySitterType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use PiBundle\Entity\User;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;

class babysitterController extends Controller
{
    public function detailsAction()
    {
        return $this->render('PiBundle:Babysitter:babysitter.html.twig');
    }

    public function AfficherAction()
    {
        $EM =$this->getDoctrine()->getManager();
        $Babysitter = $EM->getRepository("PiBundle:BabySitter")->findAll();
        return $this->render('PiBundle:BabySitter:babysitter.html.twig', array(

            'babysitters'=>$Babysitter
        ));

    }

    public function AfficherbblisteAdminAction()
    {
      /*  $EM =$this->getDoctrine()->getManager();
        $Babysitter = $EM->getRepository("PiBundle:BabySitter")->findAll();
        return $this->render('PiBundle:BabySitter:babysitterAdmin.html.twig', array(

            'babysitters'=>$Babysitter
        ));*/
        $EM =$this->getDoctrine()->getManager();
        $Baby = $EM->getRepository("PiBundle:BabySitter")->findAll();
        $pieChart = new PieChart();
        $em= $this->getDoctrine();
        $BabySitters = $em->getRepository(BabySitter::class)->findAll();
        $totalEtudiant=0;


        foreach($BabySitters as $BabySitter) {
            $totalEtudiant=$totalEtudiant+$BabySitter->getPrix();
        }
        $data= array();
        $stat=['BabySitter', 'prix'];
        $nb=0;
        array_push($data,$stat);
        foreach($BabySitters as $BabySitter) {
            $stat=array();
            array_push($stat,$BabySitter->getLieux(),(($BabySitter->getPrix()) *100)/$totalEtudiant);
            $nb=($BabySitter->getPrix() *100)/$totalEtudiant;
            $stat=[$BabySitter->getLieux(),$nb];
            array_push($data,$stat);
        }
        $pieChart->getData()->setArrayToDataTable(
            $data
        );
        $pieChart->getOptions()->setTitle('Pourcentages des Prix Par Lieux ');
        $pieChart->getOptions()->setHeight(500);
        $pieChart->getOptions()->setWidth(900);
        $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart->getOptions()->getTitleTextStyle()->setColor('#009900');
        $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);

        return $this->render('PiBundle:BabySitter:babysitterAdmin.html.twig', array(
            'babysitters'=>$Baby,'piechart'=>$pieChart
        ));
    }
    public function AfficherbbAdminAction()
    {
        $EM =$this->getDoctrine()->getManager();
        $Baby = $EM->getRepository("PiBundle:BabySitter")->findAll();
        $pieChart = new PieChart();
        $em= $this->getDoctrine();
        $BabySitters = $em->getRepository(BabySitter::class)->findAll();
        $total=0;


        foreach($BabySitters as $BabySitter) {
            $total=$total+$BabySitter->getPrix();
        }
        $data= array();
        $stat=['BabySitter', 'prix'];
        $nb=0;
        array_push($data,$stat);
        foreach($BabySitters as $BabySitter) {
            $stat=array();
            array_push($stat,$BabySitter->getLieux(),(($BabySitter->getPrix()) *100)/$total);
            $nb=($BabySitter->getPrix() *100)/$total;
            $stat=[$BabySitter->getLieux(),$nb];
            array_push($data,$stat);
        }
        $pieChart->getData()->setArrayToDataTable(
            $data
        );
        $pieChart->getOptions()->setTitle('Pourcentages des étudiants par niveau');
        $pieChart->getOptions()->setHeight(500);
        $pieChart->getOptions()->setWidth(900);
        $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart->getOptions()->getTitleTextStyle()->setColor('#009900');
        $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);

        return $this->render('PiBundle:BabySitter:babysitterAdmin.html.twig', array(
 'babysitters'=>$Baby,'pieChart'=>$pieChart
        ));
    }

    public function  AjouterAction(Request $request){

       // $user = new User();
       // $user = $this->container->get('security.token_storage')->getToken()->getUser();
        //Resquest httpfoundation
        $BabySitter = new BabySitter();

        if($request->isMethod('post')){
            $dateP=new \DateTime($request->get('date_dispo'));
            $BabySitter->setDateDispo($dateP);
            $BabySitter->setHoraire($request->get('horaire'));
            $BabySitter->setLieux($request->get('lieux'));
            $BabySitter->setNTel($request->get('n_tel'));
            $BabySitter->setPrix($request->get('prix'));
            $BabySitter->setDescription($request->get('description'));
           // $BabySitter->setIdUser($user);
            //EM == EntityManager
            $EM = $this->getDoctrine()->getManager();//instancier la bd
            //$BabySitter->setDateDispo(new \DateTime());
            $EM->persist($BabySitter);//initialiser l'objet dans la memoire
            $EM->flush();//executer la requête
            return $this->redirectToRoute('afficher_babysitter_date');
        }

        return $this->render('PiBundle:BabySitter:Ajouterbabysitter.html.twig',array(
           //..
        ));
    }

    public function Ajouter2Action(Request $request){

        $BabySitter = new BabySitter();
        $form =$this->createForm(BabysitterType::class,$BabySitter);
        $form->handleRequest($request);
        if($form->isValid()){
            $EM = $this->getDoctrine()->getManager();
            $EM->persist($BabySitter);
            $EM->flush();
            return $this->redirectToRoute('afficher_babysitter');
        }

       /* return $this->render('PiBundle:BabySitter:babysitter.html.twig',array(
            'Form' =>$form->createView()
        ));*/

        return $this->render('PiBundle:BabySitter:ajouterBabysitterForm.html.twig',array(
            'Form' =>$form->createView()
        ));



    }


    public function DeletebbAction($id){

        $EM = $this->getDoctrine()->getManager();
        $BabySitter= $EM->getRepository("PiBundle:BabySitter")->find("$id");
        $EM->remove($BabySitter);
        $EM->flush();
        return $this->redirectToRoute('afficher_babysitter_Admin_liste');
    }

    public function updatebbAction(Request $request,$id){

        $EM =$this->getDoctrine()->getManager();
        $Event = $EM->getRepository("PiBundle:BabySitter")->find("$id");

        $form =$this->createForm(BabySitterType::class,$Event);
        $form->handleRequest($request);
        if($form->isValid()){
        //$EM->persist($Modele);
        $EM->flush();
        return $this->redirectToRoute('afficher_babysitter_Admin_liste');}
       //


        return $this->render('PiBundle:BabySitter:AjouterBabysitterForm.html.twig', array(
            // ...
            'Form'=>$form->createView()
        ));


        /*//var_dump($id);
        $em=$this->getDoctrine()->getManager();
        $BabySitter=$em->getRepository("PiBundle:BabySitter")->find($id);
        if($request->isMethod('POST')) {
            $BabySitter->setDateDispo($request->get('date_dispo'));
            $BabySitter->setHoraire($request->get('horaire'));
            $BabySitter->setLieux($request->get('lieux'));
            $BabySitter->setNTel($request->get('n_tel'));
            $BabySitter->setPrix($request->get('prix'));
            $BabySitter->setDescription($request->get('description'));
            $em->flush();
            return $this->redirectToRoute('afficher_babysitter_Admin_liste');
        }
        return $this->render('PiBundle:BabySitter:AjouterBabysitter.html.twig', array(
            'babysitters'=>$BabySitter,
        ));*/


    }

    public function detailAction(Request $request) {
        $date = $request -> get('date_dispo');
        $prix = $request -> get('prix');
        $horaire = $request -> get('horaire');
        $lieux = $request -> get('lieux');
        $ntel = $request -> get('n_tel');
        $description = $request -> get('description');
        return $this->render("PiBundle:BabySitter:detailbabysitter.html.twig",
            array('date_dispo'=>$date,'horaire'=>$horaire,'lieux'=>$lieux,'n_tel'=>$ntel,'prix'=>$prix,'description'=>$description)
        );

    }
    public function detailAdminAction(Request $request) {
        $date = $request -> get('date_dispo');
        $prix = $request -> get('prix');
        $horaire = $request -> get('horaire');
        $lieux = $request -> get('lieux');
        $ntel = $request -> get('n_tel');
        $description = $request -> get('description');
        return $this->render("PiBundle:BabySitter:detailbabysitterAdmin.html.twig",
            array('date_dispo'=>$date,'horaire'=>$horaire,'lieux'=>$lieux,'n_tel'=>$ntel,'prix'=>$prix,'description'=>$description)
        );

    }

    public function dqlAffichagePardateAction ()
    {
        $em=$this->getDoctrine()->getManager();
        $BB=$em->getRepository("PiBundle:BabySitter")
            ->DQLAfficher();
        return $this->render('PiBundle:BabySitter:babysitter.html.twig',array(
            'babysitters'=>$BB
        ));
    }

}

