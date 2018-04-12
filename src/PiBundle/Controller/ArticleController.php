<?php

namespace PiBundle\Controller;


use PiBundle\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class ArticleController extends Controller
{

    public function ajouterArticleAction(Request $request)
    {

         $dateajout=new \DateTime();
        $Article = new Article();
        if($request->isMethod('post')) {

            $Article->setCategorie($request->get('categorie'));
            $Article->setTitre($request->get('titre'));
            $Article->setContenu($request->get('contenu'));

            $Article->setDateCreation($dateajout);
            $Article->setNote(0);
            $Article->setNbrVue(0);
            $EM = $this->getDoctrine()->getManager();//instancier la bd
            $EM->persist($Article);//initialiser l'objet dans la memoire
            $EM->flush();//executer la requête
            return $this->redirectToRoute('liste_articleAdmin');
        }

        return $this->render('PiBundle:Article:ajouter_article.html.twig',
            array(

        ));
    }

    public function modifierArticleAction(Request $request ,$id)
    {
        var_dump($id);
        $em=$this->getDoctrine()->getManager();
        $Article=$em->getRepository("PiBundle:Article")->find($id);
        if($request->isMethod('POST')) {
            $Article->setCategorie($request->get('categorie'));
            $time = new \DateTime("now");
            $Article->setDateCreation($time);
            $Article->setTitre($request->get('titre'));

            $Article->setContenu($request->get('contenu'));
            $Article->setNote($Article->getNote());
            $em->flush();
            return $this->redirectToRoute('liste_articleAdmin');
        }
        return $this->render('PiBundle:Article:modifier_article.html.twig', array(
            'articles'=>$Article,
        ));
    }

    public function supprimerArticleAction($id)
    {
        $EM = $this->getDoctrine()->getManager();
        $article= $EM->getRepository("PiBundle:Article")->find("$id");

        $EM->remove($article);
        $EM->flush();
        return $this->redirectToRoute('liste_articleAdmin');

    }

    public function listeArticleAction(Request $request)
    {
        $EM =$this->getDoctrine()->getManager();
        $article=$EM->getRepository("PiBundle:Article")->findAll();
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $article, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            3/*limit per page*/
        );
        return $this->render('PiBundle:Article:liste_article.html.twig', array(
            'articles'=>$article,'pagination' => $pagination
        ));
    }
    public function listeArticleAdminAction(Request $request)
    {


        $EM =$this->getDoctrine()->getManager();
        $article=$EM->getRepository("PiBundle:Article")->findAll();
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $article, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            5/*limit per page*/
        );
        return $this->render('PiBundle:Article:liste_articleAdmin.html.twig', array(
            'articles'=>$article,'pagination' => $pagination
        ));
    }
    public function detailsArticleAdminAction(Request $request)
    {
        $categorie=$request->get('categorie');
        $titre=$request->get('titre');
        $contenu=$request->get('contenu');
        $note=$request->get('note');
        $date=($request->get('dateCreation'));
        $nbr_vue=$request->get('nbr_vue');
        return $this->render('PiBundle:Article:details_articleAdmin.html.twig', array(
            'categorie'=>$categorie,
            'titre'=>$titre,'contenu'=>$contenu,'note'=>$note,'dateCreation'=>$date,'nbr_vue'=>$nbr_vue
        ));
    }
    public function detailsArticleAction($id,Request $request)
    {
        $Article = new Article();

        $em=$this->getDoctrine()->getManager();
        $Article=$em->getRepository("PiBundle:Article")->find($id);
        $idArticle=$request->get('idArticle');
        $categorie=$request->get('categorie');
        $titre=$request->get('titre');
        $contenu=$request->get('contenu');
        $note=$request->get('note');
        $nbr_vue=$request->get('nbr_vue');
        $Article->setNbrVue($nbr_vue+1);
        $em->flush();

        $date=($request->get('dateCreation'));
            return $this->render('PiBundle:Article:details_article.html.twig', array(
            'categorie'=>$categorie,
            'titre'=>$titre,'contenu'=>$contenu,'note'=>$note,'dateCreation'=>$date,'idArticle'=>$idArticle,'nbr_vue'=>$nbr_vue
        ));
    }


    public function rechercherArticleAction(Request $request)
    {
        //var_dump($request->getRequestFormat());
        $article = new Article();
        $em = $this->getDoctrine()->getManager();
        $articles = $em->getRepository("PiBundle:Article")->findAll();

        if ($request->isXmlHttpRequest()) {
            $serializer = new Serializer(array(new ObjectNormalizer()));
            $articles = $em->getRepository("PiBundle:Article")
                ->RechercheCategorieDql($request->get('categorie'));
            $data = $serializer->normalize($articles);
            return new JsonResponse($data);
        }

    }
    public function pdfAction(Request $request){

        $snappy = $this->get('knp_snappy.pdf');
        $snappy->setOption('no-outline', true);
        $snappy->setOption('page-size','LETTER');
        $snappy->setOption('encoding', 'UTF-8');

        $idArticle=$request->get('idArticle');
        $categorie=$request->get('categorie');
        $titre=$request->get('titre');
        $contenu=$request->get('contenu');
        $note=$request->get('note');
        $date=($request->get('dateCreation'));

        $html = $this->renderView('PiBundle:Article:articlepdf.html.twig',
            array( 'categorie'=>$categorie,
                'titre'=>$titre,'contenu'=>$contenu,'note'=>$note,'dateCreation'=>$date,'idArticle'=>$idArticle
            ));

        $filename = 'myFirstSnappyPDF';

        return new Response(
            $snappy->getOutputFromHtml($html),
            200,
            array(
                'Content-Type'          => 'application/pdf',
                'Content-Disposition'   => 'inline; filename="'.$filename.'.pdf"'
            )
        );






    }

}
