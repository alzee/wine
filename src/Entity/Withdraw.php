<?php

namespace App\Entity;

use App\Repository\WithdrawRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use Symfony\Component\HttpFoundation\File\File;

#[ORM\Entity(repositoryClass: WithdrawRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['read']],
    denormalizationContext: ['groups' => ['write']],
)]
#[ApiFilter(SearchFilter::class, properties: ['id' => 'exact', 'applicant' => 'exact', 'approver' => 'exact'])]
class Withdraw
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read'])]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['read'])]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(options: ["unsigned" => true])]
    #[Assert\Positive]
    #[Groups(['read', 'write'])]
    private ?int $amount = null;

    #[ORM\Column(type: Types::SMALLINT)]
    #[Groups(['read', 'write'])]
    private ?int $status = 0;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read', 'write'])]
    private ?string $note = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['read', 'write'])]
    private ?Org $applicant = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['read', 'write'])]
    private ?Org $approver = null;

    #[ORM\Column(options: ["unsigned" => true])]
    #[Assert\Positive]
    #[Groups(['read', 'write'])]
    private ?int $actualAmount = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read', 'write'])]
    private ?string $img = null;

    #[Assert\Image(maxSize: '1024k', mimeTypes: ['image/jpeg', 'image/png'], mimeTypesMessage: 'Only jpg and png')]
    private ?File $imageFile = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    public function __construct()
    {
        $this->date = new \DateTime();
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

    public function getActualAmount(): ?int
    {
        return $this->actualAmount;
    }

    public function setActualAmount(int $actualAmount): self
    {
        $this->actualAmount = $actualAmount;

        return $this;
    }

    public function getImg(): ?string
    {
        return $this->img;
    }

    public function setImg(?string $img): self
    {
        $this->img = $img;

        return $this;
    }

    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
