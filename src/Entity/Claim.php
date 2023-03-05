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
#[ApiFilter(SearchFilter::class, properties: ['id' => 'exact', 'store' => 'exact', 'serveStore' => 'exact', 'customer' => 'exact', 'status' => 'exact', 'storeSettled' => 'exact', 'serveStoreSettled' => 'exact'])]
class Claim
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read'])]
    private ?int $id = null;

    #[Groups(['read'])]
    private ?string $name = null;
    
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

    #[ORM\ManyToOne(inversedBy: 'serveClaims')]
    #[Groups(['read'])]
    private ?Org $serveStore = null;

    #[ORM\Column]
    #[Groups(['read'])]
    private ?bool $storeSettled = false;

    #[ORM\Column]
    #[Groups(['read'])]
    private ?bool $serveStoreSettled = false;

    #[ORM\ManyToOne]
    #[Groups(['read'])]
    private ?Product $product = null;
    
    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    
    public function getName(): ?string
    {
        $s = '';
        if (! is_null($this->store)) {
            $s = '售出: ' . $this->store->getName();
        }
        if (! is_null($this->serveStore)) {
            $s .= '兑奖: ' . $this->serveStore->getName();
        }
        return $s;
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

    public function getServeStore(): ?Org
    {
        return $this->serveStore;
    }

    public function setServeStore(?Org $serveStore): self
    {
        $this->serveStore = $serveStore;

        return $this;
    }

    public function isStoreSettled(): ?bool
    {
        return $this->storeSettled;
    }

    public function setStoreSettled(bool $storeSettled): self
    {
        $this->storeSettled = $storeSettled;

        return $this;
    }

    public function isServeStoreSettled(): ?bool
    {
        return $this->serveStoreSettled;
    }

    public function setServeStoreSettled(bool $serveStoreSettled): self
    {
        $this->serveStoreSettled = $serveStoreSettled;

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
}
