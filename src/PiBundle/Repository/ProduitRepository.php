<?php
/**
 * Created by PhpStorm.
 * User: acer
 * Date: 11/04/2018
 * Time: 20:51
 */

namespace PiBundle\Repository;


class ProduitRepository extends \Doctrine\ORM\EntityRepository
{
 public function FindAjax($text){
     $query=$this->getEntityManager()->createQuery("Select p from PiBundle:Produit p 
                    WHERE p.nom LIKE :nom")->setParameter("nom","%".$text."%");
     return $query->getResult();
 }
}