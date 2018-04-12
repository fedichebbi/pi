<?php

namespace PiBundle\Controller;

use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;
use PiBundle\Entity\Produit;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $pieChart = new PieChart();
        $em= $this->getDoctrine()->getManager();
        $classes = $em->getRepository(Produit::class)->findAll();
        $totalMarque=0;

        foreach($classes as $Produit) {
            $totalMarque=$totalMarque+$Produit->getNote();
        }
        $data= array();
        $stat=['nom', 'note'];
        $nb=0;
        array_push($data,$stat);
        foreach($classes as $Produit) {
            $stat=array();
            array_push($stat,$Produit->getNom(),(($Produit->getNote()) *100)/$totalMarque);
            $nb=($Produit->getNote() *100)/$totalMarque;
            $stat=[$Produit->getNom(),$nb];
            array_push($data,$stat);
        }
        $pieChart->getData()->setArrayToDataTable(
            $data
        );
        $pieChart->getOptions()->setTitle('Pourcentages des notes par produit');
        $pieChart->getOptions()->setHeight(500);
        $pieChart->getOptions()->setWidth(900);
        $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart->getOptions()->getTitleTextStyle()->setColor('#009900');
        $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);
        return $this->render('PiBundle:Default:stats.html.twig', array('piechart' =>
            $pieChart));
    }
}
