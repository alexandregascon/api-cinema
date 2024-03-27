<?php

namespace App\Entity;

use App\Repository\SeanceRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SeanceRepository::class)]
class Seance
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTime $dateProj = null;

    #[ORM\Column]
    private ?int $tarifNormal = null;

    #[ORM\Column]
    private ?int $tarifReduit = null;

    #[ORM\ManyToOne(targetEntity: Salle::class)]
    private ?Salle $salle;

    #[ORM\ManyToOne(targetEntity: Film::class)]
    private ?Film $film;

    public function __construct()
    {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateProj(): ?\DateTimeInterface
    {
        return $this->dateProj;
    }

    public function setDateProj(\DateTimeInterface $dateProj): static
    {
        $this->dateProj = $dateProj;

        return $this;
    }

    public function getTarifNormal(): ?int
    {
        return $this->tarifNormal;
    }

    public function setTarifNormal(int $tarifNormal): static
    {
        $this->tarifNormal = $tarifNormal;

        return $this;
    }

    public function getTarifReduit(): ?int
    {
        return $this->tarifReduit;
    }

    public function setTarifReduit(int $tarifReduit): static
    {
        $this->tarifReduit = $tarifReduit;

        return $this;
    }

    /**
     * @return Salle|null
     */
    public function getSalle(): ?Salle
    {
        return $this->salle;
    }

    /**
     * @param Salle|null $salle
     */
    public function setSalle(?Salle $salle): void
    {
        $this->salle = $salle;
    }

    /**
     * @return Film|null
     */
    public function getFilm(): ?Film
    {
        return $this->film;
    }

    /**
     * @param Film|null $film
     */
    public function setFilm(?Film $film): void
    {
        $this->film = $film;
    }
}
