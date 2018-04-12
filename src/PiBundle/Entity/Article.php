<?php

namespace PiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * Article
 * @ORM\Table(name="article")
 * @ORM\Entity(repositoryClass="PiBundle\Repository\RechercheRepository")
 */
class Article
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_article", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idArticle;

    /**
     * @var string
     *
     * @ORM\Column(name="categorie", type="string", length=50, nullable=false)
     */
    private $categorie;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=50, nullable=false)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="contenu", type="string", length=50, nullable=false)
     */
    private $contenu;

    /**
     * @var float
     *
     * @ORM\Column(name="note", type="float", nullable=false)
     */
    private $note;


    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_creation", type="date", nullable=false)
     */
    private $dateCreation;
    /**
     * @var integer
     *
     * @ORM\Column(name="nbr_vue", type="integer", nullable=true)
     */
    public $nbr_vue;
    /**
     * @ORM\Column(name="image",type="string", length=255, nullable=true)
     */
    public $image;


    /**
     * @return int
     */

    public function getIdArticle()
    {
        return $this->idArticle;
    }

    /**
     * @param int $idArticle
     * @return Article
     */
    public function setIdArticle($idArticle)
    {
        $this->idArticle = $idArticle;
        return $this;
    }

    /**
     * @return string
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * @param string $categorie
     * @return Article
     */
    public function setCategorie($categorie)
    {
        $this->categorie = $categorie;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * @param string $titre
     * @return Article
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;
        return $this;
    }

    /**
     * @return string
     */
    public function getContenu()
    {
        return $this->contenu;
    }

    /**
     * @param string $contenu
     * @return Article
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;
        return $this;
    }

    /**
     * @return int
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * @param int $note
     * @return Article
     */
    public function setNote($note)
    {
        $this->note = $note;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateCreation()
    {

        return $this->dateCreation;
    }

    /**
     * @param \DateTime $dateCreation
     * @return Article
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;
        return $this;
    }

    /**
     * @return int
     */
    public function getNbrVue()
    {
        return $this->nbr_vue;
    }

    /**
     * @param int $nbr_vue
     */
    public function setNbrVue($nbr_vue)
    {
        $this->nbr_vue = $nbr_vue;
    }

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }


}

