<?php

namespace App\Entity;

use App\Repository\ReturnItemsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReturnItemsRepository::class)]
class ReturnItems
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'returnItems')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Returns $ret = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Product $product = null;

    #[ORM\Column(options: ["unsigned" => true])]
    private ?int $quantity = null;

    public function __toString(): string
    {
        return $this->product;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRet(): ?Returns
    {
        return $this->ret;
    }

    public function setRet(?Returns $ret): self
    {
        $this->ret = $ret;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }
}
