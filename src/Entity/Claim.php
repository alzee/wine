<?php

namespace App\Entity;

use App\Repository\ClaimRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;

#[ORM\Entity(repositoryClass: ClaimRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['read']],
    denormalizationContext: ['groups' => ['write']],
    paginationEnabled: false,
)]
#[ApiFilter(SearchFilter::class, properties: ['id' => 'exact', 'store' => 'exact', 'customer' => 'exact', 'status' => 'exact', 'settled' => 'exact'])]
class Claim
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read'])]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'claim', cascade: ['persist', 'remove'])]
    private ?Retail $retail = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $type = 0;

    #[ORM\Column(type: Types::SMALLINT)]
    #[Groups(['read'])]
    private ?int $status = 0;

    #[ORM\Column]
    #[Groups(['read'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\ManyToOne(inversedBy: 'claims')]
    #[Groups(['read'])]
    private ?Org $store = null;

    #[ORM\ManyToOne(inversedBy: 'claims')]
    #[Groups(['read'])]
    private ?User $customer = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[Groups(['read'])]
    private ?Bottle $bottle = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['read'])]
    private ?Prize $prize = null;

    #[ORM\Column]
    #[Groups(['read'])]
    private ?int $value = 1;

    #[ORM\Column]
    #[Groups(['read'])]
    private ?bool $settled = false;
    
    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRetail(): ?Retail
    {
        return $this->retail;
    }

    public function setRetail(Retail $retail): self
    {
        $this->retail = $retail;

        return $this;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): self
    {
        $this->type = $type;

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

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getStore(): ?Org
    {
        return $this->store;
    }

    public function setStore(?Org $store): self
    {
        $this->store = $store;

        return $this;
    }

    public function getCustomer(): ?User
    {
        return $this->customer;
    }

    public function setCustomer(?User $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    public function getBottle(): ?Bottle
    {
        return $this->bottle;
    }

    public function setBottle(?Bottle $bottle): self
    {
        $this->bottle = $bottle;

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

    public function getValue(): ?int
    {
        return $this->value;
    }

    public function setValue(int $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function isSettled(): ?bool
    {
        return $this->settled;
    }

    public function setSettled(bool $settled): self
    {
        $this->settled = $settled;

        return $this;
    }
}
