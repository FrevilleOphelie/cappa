<?php

namespace App\Entity;

use App\Repository\ChatRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ChatRepository::class)]
class Chat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $dateNaissance = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    private ?bool $adopte = null;

    #[ORM\Column]
    private ?bool $parrainne = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $marraine = null;

    #[ORM\Column(type: 'string')]
    private ?string $photoFilename;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDateNaissance(): ?string
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(string $dateNaissance): static
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function isAdopte(): ?bool
    {
        return $this->adopte;
    }

    public function setAdopte(bool $adopte): static
    {
        $this->adopte = $adopte;

        return $this;
    }

    public function isParrainne(): ?bool
    {
        return $this->parrainne;
    }

    public function setParrainne(bool $parrainne): static
    {
        $this->parrainne = $parrainne;

        return $this;
    }

    public function getMarraine(): ?string
    {
        return $this->marraine;
    }

    public function setMarraine(?string $marraine): static
    {
        $this->marraine = $marraine;

        return $this;
    }

    public function getPhotoFilename(): string
    {
        return $this->photoFilename;
    }

    public function setPhotoFilename(string $photoFilename): self
    {
        $this->photoFilename = $photoFilename;

        return $this;
    }
}
