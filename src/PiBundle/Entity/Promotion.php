<?php

namespace PiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Promotion
 *
 * @ORM\Table(name="promotion")
 * @ORM\Entity(repositoryClass="PiBundle\Repository\PromotionRepository")
 */
class Promotion
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DateFin", type="date")
     */
    private $dateFin;

    /**
     * @var float
     *
     * @ORM\Column(name="NouvPrix", type="float")
     */
    private $nouvPrix;

    /**
     * @var int
     *
     * @ORM\Column(name="Remise", type="integer")
     */
    private $remise;

    /**
     * @var \Produit
     * @ORM\ManyToOne(targetEntity="Produit")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="produit", referencedColumnName="designation")
     * })
     */
    private $produit;

    /**
     * @return \Produit
     */
    public function getProduit()
    {
        return $this->produit;
    }

    /**
     * @param \Produit $produit
     */
    public function setProduit($produit)
    {
        $this->produit = $produit;
    }




    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set dateFin
     *
     * @param \DateTime $dateFin
     *
     * @return Promotion
     */
    public function setDateFin($dateFin)
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    /**
     * Get dateFin
     *
     * @return \DateTime
     */
    public function getDateFin()
    {
        return $this->dateFin;
    }

    /**
     * Set nouvPrix
     *
     * @param float $nouvPrix
     *
     * @return Promotion
     */
    public function setNouvPrix($nouvPrix)
    {
        $this->nouvPrix = $nouvPrix;

        return $this;
    }

    /**
     * Get nouvPrix
     *
     * @return float
     */
    public function getNouvPrix()
    {
        return $this->nouvPrix;
    }

    /**
     * Set remise
     *
     * @param integer $remise
     *
     * @return Promotion
     */
    public function setRemise($remise)
    {
        $this->remise = $remise;

        return $this;
    }

    /**
     * Get remise
     *
     * @return int
     */
    public function getRemise()
    {
        return $this->remise;
    }
}

