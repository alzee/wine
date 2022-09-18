<?php

namespace App\Entity;

use App\Repository\WithdrawRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;

#[ORM\Entity(repositoryClass: WithdrawRepository::class)]
#[ApiResource]
class Withdraw
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(options: ["unsigned" => true])]
    private ?int $amount = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $status = 0;

    #[ORM\ManyToOne(inversedBy: 'withdraws')]
    private ?Org $org = null;

    #[ORM\Column]
    private ?float $discount = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $note = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Org $applicant = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Org $approver = null;

    public function __construct()
    {
        $this->date = new \DateTime();
        $this->discount = 1;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

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

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getOrg(): ?Org
    {
        return $this->org;
    }

    public function setOrg(?Org $org): self
    {
        $this->org = $org;

        return $this;
    }

    public function getDiscount(): ?float
    {
        return $this->discount;
    }

    public function setDiscount(float $discount): self
    {
        $this->discount = $discount;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getApplicant(): ?Org
    {
        return $this->applicant;
    }

    public function setApplicant(?Org $applicant): self
    {
        $this->applicant = $applicant;

        return $this;
    }

    public function getApprover(): ?Org
    {
        return $this->approver;
    }

    public function setApprover(?Org $approver): self
    {
        $this->approver = $approver;

        return $this;
    }
}
