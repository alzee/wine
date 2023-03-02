<?php

namespace App\Entity;

use App\Repository\PrizeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;

#[ORM\Entity(repositoryClass: PrizeRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['read']],
    denormalizationContext: ['groups' => ['write']],
    paginationEnabled: false,
)]
class Prize
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read'])]
    private ?string $name = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['read'])]
    private ?int $value = null;

    #[ORM\Column]
    #[Groups(['read'])]
    private ?int $expire = 365;

    #[ORM\Column(nullable: true)]
    private ?float $odds = null;

    #[ORM\Column]
    private ?bool $big = false;

    #[ORM\Column(nullable: true)]
    #[Groups(['read'])]
    private ?int $value2 = null;

    #[ORM\Column(type: Types::SIMPLE_ARRAY, nullable: true)]
    private array $bottles = [];

    #[ORM\Column]
    #[Groups(['read'])]
    private ?int $toStore = 0;

    #[ORM\Column]
    #[Groups(['read'])]
    private ?int $toCustomer = 0;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read'])]
    private ?string $label = null;

    public function __toString()
    {
        return $this->getInfo();
        // return $this->name;
    }

    public function getInfo()
    {
        $s = $this->name;
        if (! is_null($this->toCustomer)) {
            $s .= ' ' . $this->toCustomer / 100;
        }
        if (! is_null($this->toStore)) {
            $s .= '-' . $this->toStore / 100;
        }
        return $s;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getValue(): ?int
    {
        return $this->value;
    }

    public function setValue(?int $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getExpire(): ?int
    {
        return $this->expire;
    }

    public function setExpire(int $expire): self
    {
        $this->expire = $expire;

        return $this;
    }

    public function getOdds(): ?float
    {
        return $this->odds;
    }

    public function setOdds(?float $odds): self
    {
        $this->odds = $odds;

        return $this;
    }

    public function isBig(): ?bool
    {
        return $this->big;
    }

    public function setBig(bool $big): self
    {
        $this->big = $big;

        return $this;
    }

    public function getValue2(): ?int
    {
        return $this->value2;
    }

    public function setValue2(?int $value2): self
    {
        $this->value2 = $value2;

        return $this;
    }

    public function getBottles(): array
    {
        return $this->bottles;
    }

    public function setBottles(?array $bottles): self
    {
        $this->bottles = $bottles;

        return $this;
    }

    public function getToStore(): ?int
    {
        return $this->toStore;
    }

    public function setToStore(int $toStore): self
    {
        $this->toStore = $toStore;

        return $this;
    }

    public function getToCustomer(): ?int
    {
        return $this->toCustomer;
    }

    public function setToCustomer(int $toCustomer): self
    {
        $this->toCustomer = $toCustomer;

        return $this;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(?string $label): self
    {
        $this->label = $label;

        return $this;
    }
}
