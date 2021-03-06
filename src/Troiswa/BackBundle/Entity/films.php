<?php

namespace Troiswa\BackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * films
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Troiswa\BackBundle\Entity\filmsRepository")
 */
class films
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=150)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateDeRealisation", type="datetime")
     */
    private $dateDeRealisation;

    /**
     * @var integer
     *
     * @ORM\Column(name="note", type="integer")
     */
    private $note;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=150)
     */
    private $image;

    private $fichier;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set titre
     *
     * @param string $titre
     * @return films
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     *
     * @ORM\ManyToOne(targetEntity="Troiswa\BackBundle\Entity\genre")
     *
     */
    private $liaisonGenre;

    /**
     * Get titre
     *
     * @return string 
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return films
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set dateDeRealisation
     *
     * @param \DateTime $dateDeRealisation
     * @return films
     */
    public function setDateDeRealisation($dateDeRealisation)
    {
        $this->dateDeRealisation = $dateDeRealisation;

        return $this;
    }

    /**
     * Get dateDeRealisation
     *
     * @return \DateTime 
     */
    public function getDateDeRealisation()
    {
        return $this->dateDeRealisation;
    }

    /**
     * Set note
     *
     * @param integer $note
     * @return films
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note
     *
     * @return integer 
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set image
     *
     * @param string $image
     * @return films
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string 
     */
    public function getImage()
    {
        return $this->image;
    }

    public function displayImage()  {
        return 'images/film/'.$this->image;
    }



    /**
     * Set liaisonGenre
     *
     * @param \Troiswa\BackBundle\Entity\genre $liaisonGenre
     * @return films
     */
    public function setLiaisonGenre(\Troiswa\BackBundle\Entity\genre $liaisonGenre = null)
    {
        $this->liaisonGenre = $liaisonGenre;

        return $this;
    }

    /**
     * Get liaisonGenre
     *
     * @return \Troiswa\BackBundle\Entity\genre 
     */
    public function getLiaisonGenre()
    {
        return $this->liaisonGenre;
    }

    public function getFichier()
    {
        return $this->fichier;
    }

    public function setFichier($fichier=null)
    {
        $this->fichier = $fichier;

        return $this;
    }

    public function upload()    {
        if (null===$this->fichier)  {
            return;
        }
        $nomImage= uniqid().'-'.$this->fichier->getClientOriginalName();
        $this->fichier->move(
            __DIR__.'/../../../../web/images/film',
            $nomImage
        );
        $this->image = $nomImage;
        $this->fichier = null;
    }
}
