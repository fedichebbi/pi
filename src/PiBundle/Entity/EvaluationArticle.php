<?php

namespace PiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EvaluationArticle
 *
 * @ORM\Table(name="evaluation_article")
 * @ORM\Entity
 */
class EvaluationArticle
{
    /**
     * @var integer
     *
     * @ORM\Column(name="ID_EV", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idEv;

    /**
     * @var integer
     *
     * @ORM\Column(name="ID_USR", type="integer", nullable=false)
     */
    private $idUsr;

    /**
     * @var integer
     *
     * @ORM\Column(name="ID_PUB", type="integer", nullable=false)
     */
    private $idPub;

    /**
     * @var float
     *
     * @ORM\Column(name="note", type="float", precision=10, scale=0, nullable=false)
     */
    private $note;


}

