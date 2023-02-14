<?php

namespace App\Entity;

use App\Repository\BatchRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BatchRepository::class)]
class Batch
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $qty = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $bottleQty = null;

    #[ORM\Column]
    private ?int $start = null;

    #[ORM\Column]
    private ?int $end = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQty(): ?int
    {
        return $this->qty;
    }

    public function setQty(int $qty): self
    {
        $this->qty = $qty;

        return $this;
    }

    public function getBottleQty(): ?int
    {
        return $this->bottleQty;
    }

    public function setBottleQty(int $bottleQty): self
    {
        $this->bottleQty = $bottleQty;

        return $this;
    }

    public function getStart(): ?int
    {
        return $this->start;
    }

    public function setStart(int $start): self
    {
        $this->start = $start;

        return $this;
    }

    public function getEnd(): ?int
    {
        return $this->end;
    }

    public function setEnd(int $end): self
    {
        $this->end = $end;

        return $this;
    }
}
