<?php

namespace App\Entity;

use App\Repository\PrizeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PrizeRepository::class)]
class Prize
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(nullable: true)]
    private ?int $value = null;

    #[ORM\Column]
    private ?int $expire = 365;

    #[ORM\Column(nullable: true)]
    private ?float $odds = null;

    #[ORM\Column]
    private ?bool $big = false;

    #[ORM\Column(nullable: true)]
    private ?int $value2 = null;

    #[ORM\Column(type: Types::SIMPLE_ARRAY, nullable: true)]
    private array $bottles = [];

    public function __toString()
    {
        return $this->getInfo();
    }

    public function getInfo()
    {
        $s = $this->name;
        if (! is_null($this->value)) {
            $s .= ' ' . $this->value;
        }
        if (! is_null($this->value2)) {
            $s .= '-' . $this->value2;
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
}
