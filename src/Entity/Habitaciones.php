<?php

namespace App\Entity;

use App\Repository\HabitacionesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HabitacionesRepository::class)]
class Habitaciones
{
    #[ORM\Id]
    #[ORM\Column]
    private ?int $numero = null;

    #[ORM\Column(type: 'decimal', precision: 8, scale: 2)]
    private ?float $precioNoche = null;

    #[ORM\Column]
    private ?bool $disponible = true;

    #[ORM\OneToMany(targetEntity: Reservas::class, mappedBy: 'habitacion')]
    private Collection $reservas;

    public function __construct()
    {
        $this->reservas = new ArrayCollection();
    }

    public function getNumero(): ?int
    {
        return $this->numero;
    }

    public function setNumero(int $numero): self
    {
        $this->numero = $numero;

        return $this;
    }

    public function getPrecioNoche(): ?float
    {
        return $this->precioNoche;
    }

    public function setPrecioNoche(float $precioNoche): self
    {
        $this->precioNoche = $precioNoche;

        return $this;
    }

    public function isDisponible(): ?bool
    {
        return $this->disponible;
    }

    public function setDisponible(bool $disponible): self
    {
        $this->disponible = $disponible;

        return $this;
    }

    /**
     * @return Collection<int, Reservas>
     */
    public function getReservas(): Collection
    {
        return $this->reservas;
    }

    public function addReserva(Reservas $reserva): self
    {
        if (!$this->reservas->contains($reserva)) {
            $this->reservas[] = $reserva;
            $reserva->setHabitacion($this);
        }

        return $this;
    }

    public function removeReserva(Reservas $reserva): self
    {
        if ($this->reservas->removeElement($reserva)) {
            // set the owning side to null (unless already changed)
            if ($reserva->getHabitacion() === $this) {
                $reserva->setHabitacion(null);
            }
        }

        return $this;
    }
}
