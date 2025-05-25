<?php

namespace App\Entity;

use App\Repository\VehiculoRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Entity\Mantenimiento;

#[ORM\Entity(repositoryClass: VehiculoRepository::class)]
class Vehiculo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $marca = null;

    #[ORM\Column(length: 50)]
    private ?string $matricula = null;

    #[ORM\Column(length: 50)]
    private ?string $año = null;

    #[ORM\Column(length: 50)]
    private ?string $modelo = null;

    /**
     * @var Collection<int, Mantenimiento>
     */
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

    public function getMarca(): ?string
    {
        return $this->marca;
    }

    public function setMarca(string $marca): static
    {
        $this->marca = $marca;

        return $this;
    }

    public function getMatricula(): ?string
    {
        return $this->matricula;
    }

    public function setMatricula(string $matricula): static
    {
        $this->matricula = $matricula;

        return $this;
    }

    public function getAño(): ?string
    {
        return $this->año;
    }

    public function setAño(string $año): static
    {
        $this->año = $año;

        return $this;
    }

    public function getModelo(): ?string
    {
        return $this->modelo;
    }

    public function setModelo(string $modelo): static
    {
        $this->modelo = $modelo;

        return $this;
    }

    /**
     * @return Collection<int, Mantenimiento>
     */
    public function getMantenimientos(): Collection
    {
        return $this->mantenimientos;
    }

    public function addMantenimiento(Mantenimiento $m): static
    {
        if (!$this->mantenimientos->contains($m)) {
            $this->mantenimientos->add($m);
            $m->setVehiculo($this);
        }

        return $this;
    }

    public function removeMantenimiento(Mantenimiento $m): static
    {
        if ($this->mantenimientos->removeElement($m)) {
            if ($m->getVehiculo() === $this) {
                $m->setVehiculo(null);
            }
        }

        return $this;
    }
}