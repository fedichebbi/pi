<?php
/**
 * Created by PhpStorm.
 * User: Fedi
 * Date: 28/03/2018
 * Time: 19:23
 */

namespace PiBundle\Repository;


use Doctrine\ORM\EntityRepository;

class CommentaireRepository extends EntityRepository
{
    public function getbyTopic($id)
    {
        $query=$this->getEntityManager()->createQuery(
            "Select c From PiBundle:Commentaire c where c.idTopic=:id")->setParameter("id",$id);
        return $query->getResult();
    }
}