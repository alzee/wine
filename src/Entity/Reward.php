<?php

namespace App\Entity;

use App\Repository\RewardRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;

#[ORM\Entity(repositoryClass: RewardRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['read']],
    denormalizationContext: ['groups' => ['write']],
)]
#[ApiFilter(SearchFilter::class, properties: ['referrer' => 'exact', 'retail' => 'exact', 'ord' => 'exact', 'type' => 'exact'])]
class Reward
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read'])]
    private ?int $id = null;

    #[ORM\Column(type: Types::SMALLINT)]
    #[Groups(['read'])]
    private ?int $type = null;

    #[ORM\Column]
    #[Groups(['read'])]
    private ?int $amount = null;

    #[ORM\Column]
    #[Groups(['read'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\ManyToOne]
    #[Groups(['read'])]
    private ?Retail $retail = null;

    #[ORM\ManyToOne]
    #[Groups(['read'])]
    private ?Orders $ord = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['read'])]
    private ?Consumer $referrer = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $status = 0;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Returns $ret = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?RetailReturn $retailReturn = null;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): self
    {
        $this->amount = $amount;

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

    public function getRetail(): ?Retail
    {
        return $this->retail;
    }

    public function setRetail(?Retail $retail): self
    {
        $this->retail = $retail;

        return $this;
    }

    public function getOrd(): ?Orders
    {
        return $this->ord;
    }

    public function setOrd(?Orders $ord): self
    {
        $this->ord = $ord;

        return $this;
    }

    public function getReferrer(): ?Consumer
    {
        return $this->referrer;
    }

    public function setReferrer(?Consumer $referrer): self
    {
        $this->referrer = $referrer;

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

    public function getRet(): ?Returns
    {
        return $this->ret;
    }

    public function setRet(?Returns $ret): self
    {
        $this->ret = $ret;

        return $this;
    }

    public function getRetailReturn(): ?RetailReturn
    {
        return $this->retailReturn;
    }

    public function setRetailReturn(?RetailReturn $retailReturn): self
    {
        $this->retailReturn = $retailReturn;

        return $this;
    }
}
