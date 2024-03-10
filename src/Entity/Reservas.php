<?php

namespace App\Entity;

use App\Repository\ReservasRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservasRepository::class)]
class Reservas
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $fechaInicio = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $fechaFin = null;

    #[ORM\ManyToOne(targetEntity: Habitaciones::class, inversedBy: 'reservas')]
    #[ORM\JoinColumn(name: 'habitacion_numero', referencedColumnName: 'numero')]
    private ?Habitaciones $habitacion = null;

    #[ORM\ManyToOne(targetEntity: Clientes::class, inversedBy: 'reservas')]
    #[ORM\JoinColumn(nullable: false, referencedColumnName: 'dni')]
    private ?Clientes $cliente = null;

    #[ORM\Column(type: 'boolean')]
    private ?bool $activo = true;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFechaInicio(): ?\DateTimeInterface
    {
        return $this->fechaInicio;
    }

    public function setFechaInicio(\DateTimeInterface $fechaInicio): self
    {
        $this->fechaInicio = $fechaInicio;

        return $this;
    }

    public function getFechaFin(): ?\DateTimeInterface
    {
        return $this->fechaFin;
    }

    public function setFechaFin(\DateTimeInterface $fechaFin): self
    {
        $this->fechaFin = $fechaFin;

        return $this;
    }

    public function getHabitacion(): ?Habitaciones
    {
        return $this->habitacion;
    }

    public function setHabitacion(?Habitaciones $habitacion): self
    {
        $this->habitacion = $habitacion;

        return $this;
    }

    public function getCliente(): ?Clientes
    {
        return $this->cliente;
    }

    public function setCliente(?Clientes $cliente): self
    {
        $this->cliente = $cliente;

        return $this;
    }

    public function isActivo(): ?bool
    {
        return $this->activo;
    }

    public function setActivo(bool $activo): self
    {
        $this->activo = $activo;

        return $this;
    }
}
