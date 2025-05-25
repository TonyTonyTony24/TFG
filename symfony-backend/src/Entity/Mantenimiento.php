<?php

namespace App\Entity;

use App\Repository\MantenimientoRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Vehiculo;

#[ORM\Entity(repositoryClass: MantenimientoRepository::class)]
class Mantenimiento
{
    #[ORM\Id, ORM\GeneratedValue, ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\Column(type: "string", length: 100)]
    private ?string $tipo = null;

    #[ORM\Column(type: "date", nullable: false)]
    private ?\DateTimeInterface $fecha = null;

    #[ORM\ManyToOne(targetEntity: Vehiculo::class, inversedBy: "mantenimientos")]
    #[ORM\JoinColumn(nullable: true)]
    private ?Vehiculo $vehiculo = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTipo(): ?string
    {
        return $this->tipo;
    }

    public function setTipo(string $tipo): self
    {
        $this->tipo = $tipo;
        return $this;
    }

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(\DateTimeInterface $fecha): self
    {
        $this->fecha = $fecha;
        return $this;
    }

    public function getVehiculo(): ?Vehiculo
    {
        return $this->vehiculo;
    }

    public function setVehiculo(?Vehiculo $vehiculo): self
    {
        $this->vehiculo = $vehiculo;
        return $this;
    }
}
