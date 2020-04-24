<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LesMix0
 *
 * @ORM\Table(name="les_mix_0", indexes={@ORM\Index(name="nomFichier", columns={"nomFichier"}), @ORM\Index(name="image", columns={"image"}), @ORM\Index(name="pseudo", columns={"pseudo"}), @ORM\Index(name="nomFichier_2", columns={"nomFichier"})})
 * @ORM\Entity
 */
class LesMix0
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="pseudo", type="string", length=50, nullable=false)
     */
    private $pseudo;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_DJ", type="string", length=50, nullable=false)
     */
    private $nomDj;

    /**
     * @var string
     *
     * @ORM\Column(name="groupe", type="string", length=50, nullable=false)
     */
    private $groupe;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=50, nullable=false)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="nomFichier", type="string", length=255, nullable=false)
     */
    private $nomfichier;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=150, nullable=false)
     */
    private $image;

    /**
     * @var string
     *
     * @ORM\Column(name="commentaire", type="string", length=255, nullable=false)
     */
    private $commentaire;

    /**
     * @var string
     *
     * @ORM\Column(name="genre", type="string", length=50, nullable=false)
     */
    private $genre;

    /**
     * @var string
     *
     * @ORM\Column(name="playlist", type="text", length=65535, nullable=false)
     */
    private $playlist;

    /**
     * @var string
     *
     * @ORM\Column(name="lienAudio", type="string", length=255, nullable=false)
     */
    private $lienaudio;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getNomDj(): ?string
    {
        return $this->nomDj;
    }

    public function setNomDj(string $nomDj): self
    {
        $this->nomDj = $nomDj;

        return $this;
    }

    public function getGroupe(): ?string
    {
        return $this->groupe;
    }

    public function setGroupe(string $groupe): self
    {
        $this->groupe = $groupe;

        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getNomfichier(): ?string
    {
        return $this->nomfichier;
    }

    public function setNomfichier(string $nomfichier): self
    {
        $this->nomfichier = $nomfichier;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(string $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    public function getGenre(): ?string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

    public function getPlaylist(): ?string
    {
        return $this->playlist;
    }

    public function setPlaylist(string $playlist): self
    {
        $this->playlist = $playlist;

        return $this;
    }

    public function getLienaudio(): ?string
    {
        return $this->lienaudio;
    }

    public function setLienaudio(string $lienaudio): self
    {
        $this->lienaudio = $lienaudio;

        return $this;
    }


}
