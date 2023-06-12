<?php

namespace App\Entity;

use App\Repository\OrdenDeTrabajoRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrdenDeTrabajoRepository::class)]
class OrdenDeTrabajo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $idOrdenTrabajo = null;



    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $fechaCreacion = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $fechaActual = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $fechaEstimada = null;

    #[ORM\Column(length: 255)]
    private ?string $descripcion = null;

    #[ORM\Column]
    private ?int $estado = null;



    public function getIdOrdenTrabajo(): ?int
    {
        return $this->idOrdenTrabajo;
    }

    public function setIdOrdenTrabajo(int $idOrdenTrabajo): self
    {
        $this->idOrdenTrabajo = $idOrdenTrabajo;

        return $this;
    }

    public function getFechaCreacion(): ?\DateTimeInterface
    {
        return $this->fechaCreacion;
    }

    public function setFechaCreacion(\DateTimeInterface $fechaCreacion): self
    {
        $this->fechaCreacion = $fechaCreacion;

        return $this;
    }

    public function getFechaActual(): ?\DateTimeInterface
    {
        return $this->fechaActual;
    }

    public function setFechaActual(\DateTimeInterface $fechaActual): self
    {
        $this->fechaActual = $fechaActual;

        return $this;
    }

    public function getFechaEstimada(): ?\DateTimeInterface
    {
        return $this->fechaEstimada;
    }

    public function setFechaEstimada(\DateTimeInterface $fechaEstimada): self
    {
        $this->fechaEstimada = $fechaEstimada;

        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getEstado(): ?int
    {
        return $this->estado;
    }

    public function setEstado(int $estado): self
    {
        $this->estado = $estado;

        return $this;
    }
}
