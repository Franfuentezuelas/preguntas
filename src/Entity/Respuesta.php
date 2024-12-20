<?php

namespace App\Entity;

use App\Repository\RespuestaRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RespuestaRepository::class)]
class Respuesta
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $respuesta = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $fecha = null;

    #[ORM\ManyToOne(inversedBy: 'respuestas')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $usuario = null;

    #[ORM\ManyToOne(inversedBy: 'respuestas')]
    private ?Pregunta $pregunta = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRespuesta(): ?string
    {
        return $this->respuesta;
    }

    public function setRespuesta(string $respuesta): static
    {
        $this->respuesta = $respuesta;

        return $this;
    }

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(\DateTimeInterface $fecha): static
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function getUsuario(): ?User
    {
        return $this->usuario;
    }

    public function setUsuario(?User $usuario): static
    {
        $this->usuario = $usuario;

        return $this;
    }

    public function getPregunta(): ?Pregunta
    {
        return $this->pregunta;
    }

    public function setPregunta(?Pregunta $pregunta): static
    {
        $this->pregunta = $pregunta;

        return $this;
    }
}
