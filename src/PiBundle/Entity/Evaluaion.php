<?php

namespace PiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Evaluaion
 *
 * @ORM\Table(name="evaluaion")
 * @ORM\Entity
 */
class Evaluaion
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
     * @var integer
     *
     * @ORM\Column(name="note", type="integer", nullable=false)
     */
    private $note = '0';


}

