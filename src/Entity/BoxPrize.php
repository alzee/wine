<?php

namespace App\Entity;

use App\Repository\BoxPrizeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BoxPrizeRepository::class)]
class BoxPrize
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Prize $prize = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $qty = null;

    #[ORM\ManyToOne(inversedBy: 'boxPrizes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Box $box = null;

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

    public function getBox(): ?Box
    {
        return $this->box;
    }

    public function setBox(?Box $box): self
    {
        $this->box = $box;

        return $this;
    }
}
