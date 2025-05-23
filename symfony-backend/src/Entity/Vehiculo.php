<?php

namespace App\Entity;

use App\Repository\VehiculoRepository;
use Doctrine\ORM\Mapping as ORM;

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
}
