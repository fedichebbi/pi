<?php

namespace PiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Codepassword
 *
 * @ORM\Table(name="codepassword")
 * @ORM\Entity
 */
class Codepassword
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_user", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idUser;

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=4, nullable=false)
     */
    private $code;


}

