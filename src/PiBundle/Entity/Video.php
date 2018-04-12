<?php

namespace PiBundle\Entity;
use Doctrine\ORM\Mapping as ORM ;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert ;
/**
 * Video
 *
 * @ORM\Table(name="video")
 * @ORM\Entity
 */
class Video
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
     * @ORM\Column(name="titre", type="string", length=200, nullable=false)
     */
    private $titre;

    private $question;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=false)
     */

    private $date;

    /**
     * @ORM\Column(type="string",length=255,nullable=true)
     */

    public $nomVideo;
    /**
     * @Assert\File(maxSize="100M")
     */
    public $file;

    /**
     * @return mixed
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param mixed $file
     */
    public function setFile(UploadedFile $file)
    {
        $this->file = $file;
    }

    public function getUploadDir()
    {
        return 'videos';
    }

    public function getAbsolutRoot()
    {
        return $this->getUploadRoot().$this->nomVideo ;
    }

    public function getWebPath()
    {
        return $this->getUploadDir().'/'.$this->nomVideo;
    }

    public function getUploadRoot()
    {
        return __DIR__.'/../../../web/'.$this->getUploadDir().'/';
    }

    public function upload()
    {
        if($this->file === null){
            return;
        }

        $this->nomVideo = $this->file->getClientOriginalName();

        if(!is_dir($this->getUploadRoot()))
        {
            mkdir($this->getUploadRoot(),'0777',true);
        }

        $this->file->move($this->getUploadRoot(),$this->nomVideo);

        unset($this->file);
    }


    /**
     * Set nomVideo
     *
     * @param string $nomVideo
     *
     * @return Categorie
     */
    public function setNomVideo($nomVideo){
        $this->setNomVideo()==$nomVideo;
        return $this;
    }

    /**
     * Get nomVideo
     *
     * @return string
     */
    public function getNomVideo(){
        return $this->nomVideo;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
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
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return string
     */
    public function video()
    {
        //$video = "<iframe width='100%' height='400px' src='../../videos/".$this->getNomVideo()."'  frameborder='0'  allowfullscreen></iframe>";
        $video = "<video controls><source src='../../videos/".$this->getNomVideo()."'></video>";
        return $video;
    }

}

