<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Audiofile
 *
 * @ORM\Table(name="AudioFile")
 * @ORM\Entity
 */
class Audiofile
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
     * @ORM\Column(name="dj", type="string", length=50, nullable=false)
     */
    private $dj;

    /**
     * @var string
     *
     * @ORM\Column(name="`group`", type="string", length=50, nullable=false)
     */
    private $group;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=50, nullable=false)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="filename", type="string", length=255, nullable=false)
     */
    private $filename;

    /**
     * @var string
     *
     * @ORM\Column(name="picture", type="string", length=150, nullable=false)
     */
    private $picture;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=false)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="genre", type="string", length=50, nullable=false)
     */
    private $genre;

    /**
     * @var int|null
     *
     * @ORM\Column(name="filesize", type="integer", nullable=true)
     */
    private $filesize;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="publish", type="boolean", nullable=true)
     */
    private $publish = '0';

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $oldFilename;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $fileCreatedAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $old_picture_name;

    public function getId(): ?int
    {
        return (int) $this->id;
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

    public function getDj(): ?string
    {
        return $this->dj;
    }

    public function setDj(string $dj): self
    {
        $this->dj = $dj;

        return $this;
    }

    public function getGroup(): ?string
    {
        return $this->group;
    }

    public function setGroup(string $group): self
    {
        $this->group = $group;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(string $filename): self
    {
        $this->filename = $filename;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

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

    public function getFilesize(): ?int
    {
        return $this->filesize;
    }

    public function setFilesize(?int $filesize): self
    {
        $this->filesize = $filesize;

        return $this;
    }

    public function getPublish(): ?bool
    {
        return $this->publish;
    }

    public function setPublish(?bool $publish): self
    {
        $this->publish = $publish;

        return $this;
    }

    public function getOldFilename(): ?string
    {
        return $this->oldFilename;
    }

    public function setOldFilename(string $oldFilename): self
    {
        $this->oldFilename = $oldFilename;

        return $this;
    }

    public function getFileCreatedAt(): ?\DateTimeInterface
    {
        return $this->fileCreatedAt;
    }

    public function setFileCreatedAt(?\DateTimeInterface $fileCreatedAt): self
    {
        $this->fileCreatedAt = $fileCreatedAt;

        return $this;
    }

    public function getOldPictureName(): ?string
    {
        return $this->old_picture_name;
    }

    public function setOldPictureName(?string $old_picture_name): self
    {
        $this->old_picture_name = $old_picture_name;

        return $this;
    }


}
