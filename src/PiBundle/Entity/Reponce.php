<?php

namespace PiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Reponce
 *
 * @ORM\Table(name="reponce")
 * @ORM\Entity
 */
class Reponce
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="text", type="string", length=500, nullable=false)
     */
    private $text;

    /**
     * @var string
     *
     * @ORM\Column(name="correction", type="string", length=500, nullable=false)
     */
    private $correction;

    /**
     * @var integer
     *
     * @ORM\Column(name="id_question", type="integer", nullable=false)
     */
    private $idQuestion;


}

