<?php

namespace App\Entity;

use App\Repository\SeanceRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: SeanceRepository::class)]
class Seance
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['detail_films'])]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['detail_films'])]
    private ?\DateTime $dateProj = null;

    #[ORM\Column]
    #[Groups(['detail_films'])]
    private ?int $tarifNormal = null;

    #[ORM\Column]
    #[Groups(['detail_films'])]
    private ?int $tarifReduit = null;

    #[ORM\ManyToOne(inversedBy: 'seances')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Film $film = null;

    #[ORM\ManyToOne(inversedBy: 'seances')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['detail_films'])]
    private ?Salle $salle = null;

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
