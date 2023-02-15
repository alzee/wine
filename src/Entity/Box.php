<?php

namespace App\Entity;

use App\Repository\BoxRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: BoxRepository::class)]
class Box
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $sn = null;

    #[ORM\Column(type: Types::SIMPLE_ARRAY, nullable: true)]
    private array $cipher = [];

    #[ORM\Column(type: Types::SIMPLE_ARRAY, nullable: true)]
    private array $draws = [];

    #[ORM\ManyToOne]
    private ?Batch $batch = null;

    public function __construct()
    {
    }

    public function __toString()
    {
        return $this->id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSn(): ?string
    {
        return $this->sn;
    }

    public function setSn(?string $sn): self
    {
        $this->sn = $sn;

        return $this;
    }

    public function getCipher(): array
    {
        return $this->cipher;
    }

    public function setCipher(?array $cipher): self
    {
        $this->cipher = $cipher;

        return $this;
    }

    public function getDraws(): array
    {
        return $this->draws;
    }

    public function setDraws(?array $draws): self
    {
        $this->draws = $draws;

        return $this;
    }

    public function getBatch(): ?Batch
    {
        return $this->batch;
    }

    public function setBatch(?Batch $batch): self
    {
        $this->batch = $batch;

        return $this;
    }
    
    public function getBoxCipher(): ?string
    {
        return $this->cipher[0];
    }
}
