<?php

namespace App\Entity;

use App\Repository\BatchPrizeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: BatchPrizeRepository::class)]
class BatchPrize
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Prize $prize = null;

    #[ORM\Column]
    #[Assert\Positive]
    private ?int $qty = null;

    #[ORM\ManyToOne(inversedBy: 'batchPrizes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Batch $batch = null;

    public function __toString()
    {
        $s = $this->prize->getInfo() . ' x ' . $this->qty;
        return $s;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrize(): ?Prize
    {
        return $this->prize;
    }

    public function setPrize(?Prize $prize): self
    {
        $this->prize = $prize;

        return $this;
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

    public function getBatch(): ?Batch
    {
        return $this->batch;
    }

    public function setBatch(?Batch $batch): self
    {
        $this->batch = $batch;

        return $this;
    }
}
