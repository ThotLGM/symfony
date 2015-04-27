<?php

namespace Troiswa\BackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Acteurs
 *
 * @ORM\Table(name="acteurs")
 * @ORM\Entity(repositoryClass="Troiswa\BackBundle\Entity\ActeursRepository")
 */
class Acteurs
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
     * @Assert\NotBlank(message="Attention le prénom ne doit pas être vide")
     * @Assert\Length(
     *      min = "2",
     *      minMessage = "Le prénom doit faire au moins {{ limit }} caractères"
     * )
     *
     * @ORM\Column(name="prenom", type="string", length=50)
     */
    private $prenom;

    /**
     * @var string
     * @Assert\NotBlank(message="Attention le nom ne doit pas être vide")
     * @Assert\Length(
     *      min = "2",
     *      minMessage = "Le nom doit faire au moins {{ limit }} caractères"
     * )
     *
     * @ORM\Column(name="nom", type="string", length=100)
     */
    private $nom;

    /**
     * @var string
     * @Assert\NotBlank(message="Attention la biographie ne doit pas être vide")
     * @Assert\Length(
     *      min = "2",
     *      max = "300",
     *      minMessage = "La biographie doit faire au moins {{ limit }} caractères",
     *      maxMessage = "La biographie ne peut pas être plus long que {{ limit }} caractères"
     * )
     *
     * @ORM\Column(name="biographie", type="text")
     */
    private $biographie;

    /**
     * @var \DateTime
     * @Assert\Date()
     *
     * @ORM\Column(name="dateNaissance", type="datetime")
     */
    private $dateNaissance;

    /**
     * @var string
     *
     * @ORM\Column(name="ville", type="string", length=255)
     */
    private $ville;

    /**
     * @var string
     * @Assert\Image(
     *     mimeTypes = {"image/jpeg", "image/png", "image/gif", "image/jpg"},
     *     mimeTypesMessage = "Ce fichier doit être une image")
     *     minWidth = 200,
     *     maxWidth = 400,
     *     maxHeight = 400,
     *     minWidthMessage = "image trop petite",
     *     maxWidthMessage = "image trop grande",
     *     maxHeightMessage = "image trop lorde",
     * )
     *
     * @ORM\Column(name="image", type="string", length=255)
     */
    private $image;

    /**
     * @ORM\Column(name="sexe", type="boolean")
     * @Assert\Range(
     *      min = 0,
     *      max = 1,
     *      minMessage = "Veillez sélectionner Femme ou Homme",
     *      maxMessage = "Veillez sélectionner Femme ou Homme"
     * )
     */
    private $sexe;

    /**
     *
     * @ORM\ManyToMany(targetEntity="Troiswa\BackBundle\Entity\films")
     *
     */
    private $liaisonFilm;

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
     * Set prenom
     *
     * @param string $prenom
     * @return Acteurs
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string 
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set nom
     *
     * @param string $nom
     * @return Acteurs
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set biographie
     *
     * @param string $biographie
     * @return Acteurs
     */
    public function setBiographie($biographie)
    {
        $this->biographie = $biographie;

        return $this;
    }

    /**
     * Get biographie
     *
     * @return string 
     */
    public function getBiographie()
    {
        return $this->biographie;
    }

    /**
     * Set dateNaissance
     *
     * @param \DateTime $dateNaissance
     * @return Acteurs
     */
    public function setDateNaissance($dateNaissance)
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    /**
     * Get dateNaissance
     *
     * @return \DateTime 
     */
    public function getDateNaissance()
    {
        return $this->dateNaissance;
    }

    /**
     * Set ville
     *
     * @param string $ville
     * @return Acteurs
     */
    public function setVille($ville)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville
     *
     * @return string 
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Set image
     *
     * @param string $image
     * @return Acteurs
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

    /**
     * Set sexe
     *
     * @param boolean $sexe
     * @return Acteurs
     */
    public function setSexe($sexe)
    {
        $this->sexe = $sexe;

        return $this;
    }

    /**
     * Get sexe
     *
     * @return boolean 
     */
    public function getSexe()
    {
        return $this->sexe;
    }

    private function getImageFolder()   {
        return 'images/acteurs';
    }

    public function displayImage()  {
        return $this->getImageFolder().'/'.$this->image;
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
            __DIR__.'/../../../../web/'.$this->getImageFolder(),
            $nomImage
        );
        $this->image = $nomImage;
        $this->fichier = null;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->liaisonFilm = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add liaisonFilm
     *
     * @param \Troiswa\BackBundle\Entity\films $liaisonFilm
     * @return Acteurs
     */
    public function addLiaisonFilm(\Troiswa\BackBundle\Entity\films $liaisonFilm)
    {
        $this->liaisonFilm[] = $liaisonFilm;

        return $this;
    }

    /**
     * Remove liaisonFilm
     *
     * @param \Troiswa\BackBundle\Entity\films $liaisonFilm
     */
    public function removeLiaisonFilm(\Troiswa\BackBundle\Entity\films $liaisonFilm)
    {
        $this->liaisonFilm->removeElement($liaisonFilm);
    }

    /**
     * Get liaisonFilm
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLiaisonFilm()
    {
        return $this->liaisonFilm;
    }
}
