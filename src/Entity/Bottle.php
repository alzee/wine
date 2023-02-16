<?php

namespace App\Entity;

use App\Repository\BottleRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BottleRepository::class)]
class Bottle
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $sn = null;

    #[ORM\Column(length: 255)]
    private ?string $cipher = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $bid = null;

    #[ORM\ManyToOne]
    private ?Prize $prize = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $status = 0;

    #[ORM\ManyToOne(inversedBy: 'bottles')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Box $box = null;

    #[ORM\OneToOne(mappedBy: 'bottle', cascade: ['persist', 'remove'])]
    private ?Retail $retail = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSn(): ?string
    {
        return $this->sn;
    }

    public function setSn(string $sn): self
    {
        $this->sn = $sn;

        return $this;
    }

    public function getCipher(): ?string
    {
        return $this->cipher;
    }

    public function setCipher(string $cipher): self
    {
        $this->cipher = $cipher;

        return $this;
    }

    public function getBid(): ?int
    {
        return $this->bid;
    }

    public function setBid(int $bid): self
    {
        $this->bid = $bid;

        return $this;
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

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

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

    public function getRetail(): ?Retail
    {
        return $this->retail;
    }

    public function setRetail(?Retail $retail): self
    {
        // unset the owning side of the relation if necessary
        if ($retail === null && $this->retail !== null) {
            $this->retail->setBottle(null);
        }

        // set the owning side of the relation if necessary
        if ($retail !== null && $retail->getBottle() !== $this) {
            $retail->setBottle($this);
        }

        $this->retail = $retail;

        return $this;
    }
}
