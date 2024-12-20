<?php

namespace App\Entity;

use App\Repository\PreguntaRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;

#[ORM\Entity(repositoryClass: PreguntaRepository::class)]
class Pregunta
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $descripcion = null;

    #[ORM\Column(length: 255)]
    private ?string $opcion1 = null;

    #[ORM\Column(length: 255)]
    private ?string $opcion2 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $opcion3 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $opcion4 = null;

    #[ORM\Column(length: 255)]
    private ?string $correcta = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $fechaInicio = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $fechaFin = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): static
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getOpcion1(): ?string
    {
        return $this->opcion1;
    }

    public function setOpcion1(string $opcion1): static
    {
        $this->opcion1 = $opcion1;

        return $this;
    }

    public function getOpcion2(): ?string
    {
        return $this->opcion2;
    }

    public function setOpcion2(string $opcion2): static
    {
        $this->opcion2 = $opcion2;

        return $this;
    }

    public function getOpcion3(): ?string
    {
        return $this->opcion3;
    }

    public function setOpcion3(?string $opcion3): static
    {
        $this->opcion3 = $opcion3;

        return $this;
    }

    public function getOpcion4(): ?string
    {
        return $this->opcion4;
    }

    public function setOpcion4(?string $opcion4): static
    {
        $this->opcion4 = $opcion4;

        return $this;
    }

    public function getCorrecta(): ?string
    {
        return $this->correcta;
    }

    public function setCorrecta(string $correcta): static
    {
        $this->correcta = $correcta;

        return $this;
    }

    public function getFechaInicio(): ?\DateTimeInterface
    {
        return $this->fechaInicio;
    }

    public function setFechaInicio(?\DateTimeInterface $fechaInicio): static
    {
        $this->fechaInicio = $fechaInicio;

        return $this;
    }

    public function getFechaFin(): ?\DateTimeInterface
    {
        return $this->fechaFin;
    }

    public function setFechaFin(?\DateTimeInterface $fechaFin): static
    {
        $this->fechaFin = $fechaFin;

        return $this;
    }
}

