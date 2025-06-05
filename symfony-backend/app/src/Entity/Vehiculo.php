<?php

namespace App\Entity;

use App\Repository\VehiculoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VehiculoRepository::class)]
class Vehiculo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    private ?string $matricula = null;

    #[ORM\Column(length: 100)]
    private ?string $marca = null;

    #[ORM\Column(length: 100)]
    private ?string $modelo = null;

    #[ORM\Column(nullable: true)]
    private ?int $anio = null;

    #[ORM\OneToMany(mappedBy: 'vehiculo', targetEntity: Mantenimiento::class, cascade: ['persist', 'remove'])]
    private Collection $mantenimientos;

    public function __construct()
    {
        $this->mantenimientos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMatricula(): ?string
    {
        return $this->matricula;
    }

    public function setMatricula(string $matricula): self
    {
        $this->matricula = $matricula;
        return $this;
    }

    public function getMarca(): ?string
    {
        return $this->marca;
    }

    public function setMarca(string $marca): self
    {
        $this->marca = $marca;
        return $this;
    }

    public function getModelo(): ?string
    {
        return $this->modelo;
    }

    public function setModelo(string $modelo): self
    {
        $this->modelo = $modelo;
        return $this;
    }

    public function getAnio(): ?int
    {
        return $this->anio;
    }

    public function setAnio(?int $anio): self
    {
        $this->anio = $anio;
        return $this;
    }

    /**
     * @return Collection<int, Mantenimiento>
     */
    public function getMantenimientos(): Collection
    {
        return $this->mantenimientos;
    }

    public function addMantenimiento(Mantenimiento $mantenimiento): self
    {
        if (!$this->mantenimientos->contains($mantenimiento)) {
            $this->mantenimientos->add($mantenimiento);
            $mantenimiento->setVehiculo($this);
        }

        return $this;
    }

    public function removeMantenimiento(Mantenimiento $mantenimiento): self
    {
        if ($this->mantenimientos->removeElement($mantenimiento)) {
            if ($mantenimiento->getVehiculo() === $this) {
                $mantenimiento->setVehiculo(null);
            }
        }

        return $this;
    }
}
