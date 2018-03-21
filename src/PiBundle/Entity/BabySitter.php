<?php

namespace PiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * BabySitter
 *
 * @ORM\Table(name="baby_sitter", indexes={@ORM\Index(name="id_user", columns={"id_user"}), @ORM\Index(name="id", columns={"id"})})
 * @ORM\Entity
 */
class BabySitter
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
     * @var \DateTime
     *
     * @ORM\Column(name="date_dispo", type="date", nullable=false)
     */
    private $dateDispo;

    /**
     * @var string
     *
     * @ORM\Column(name="horaire", type="string", length=50, nullable=false)
     */
    private $horaire;

    /**
     * @var string
     *
     * @ORM\Column(name="lieux", type="string", length=50, nullable=false)
     */
    private $lieux;

    /**
     * @var float
     *
     * @ORM\Column(name="prix", type="float", precision=10, scale=0, nullable=false)
     */
    private $prix;

    /**
     * @var integer
     *
     * @ORM\Column(name="n_tel", type="integer", nullable=false)
     */
    private $nTel;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=50, nullable=false)
     */
    private $description;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user", referencedColumnName="id")
     * })
     */
    private $idUser;


}

