<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use Symfony\Component\HttpFoundation\File\File;

// #[UniqueConstraint(name: "sn_org", columns: ["sn", "org_id"])]
#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[UniqueEntity('sn')]
#[ApiResource(
    normalizationContext: ['groups' => ['read']],
    denormalizationContext: ['groups' => ['write']],
)]
#[ApiFilter(SearchFilter::class, properties: ['id' => 'exact', 'sn' => 'exact'])]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read', 'write'])]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read', 'write'])]
    private ?string $spec = null;

    #[ORM\Column(options: ["unsigned" => true])]
    #[Assert\Positive]
    #[Groups(['read', 'write'])]
    private ?int $price = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read', 'write'])]
    private ?string $sn = null;

    #[ORM\Column(options: ["unsigned" => true])]
    #[Assert\Positive]
    #[Groups(['read', 'write'])]
    private ?int $voucher = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read', 'write'])]
    private ?string $img = null;

    #[Assert\Image(maxSize: '1024k', mimeTypes: ['image/jpeg', 'image/png'], mimeTypesMessage: 'Only jpg and png')]
    private ?File $imageFile = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(options: ["unsigned" => true])]
    #[Assert\Positive]
    #[Groups(['read'])]
    private ?int $refReward = 0;

    #[ORM\Column(options: ["unsigned" => true])]
    // #[Assert\Positive]
    private ?int $orgRefReward = 0;

    #[ORM\Column(options: ["unsigned" => true], nullable: true)]
    #[Assert\Positive]
    private ?int $partnerReward = 0;

    #[ORM\Column(options: ["unsigned" => true])]
    #[Assert\Positive]
    private ?int $offIndustryStoreReward = 0;

    #[ORM\Column(options: ["unsigned" => true])]
    #[Assert\Positive]
    private ?int $offIndustryAgencyReward = 0;

    public function __construct()
    {
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

    public function getSpec(): ?string
    {
        return $this->spec;
    }

    public function setSpec(string $spec): self
    {
        $this->spec = $spec;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
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

    public function getVoucher(): ?int
    {
        return $this->voucher;
    }

    public function setVoucher(int $voucher): self
    {
        $this->voucher = $voucher;

        return $this;
    }

    public function __toString(): string
    {
        return $this->name;
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

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

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

    public function getRefReward(): ?int
    {
        return $this->refReward;
    }

    public function setRefReward(int $refReward): self
    {
        $this->refReward = $refReward;

        return $this;
    }

    public function getOrgRefReward(): ?int
    {
        return $this->orgRefReward;
    }

    public function setOrgRefReward(int $orgRefReward): self
    {
        $this->orgRefReward = $orgRefReward;

        return $this;
    }

    public function getPartnerReward(): ?int
    {
        return $this->partnerReward;
    }

    public function setPartnerReward(int $partnerReward): self
    {
        $this->partnerReward = $partnerReward;

        return $this;
    }

    public function getOffIndustryStoreReward(): ?int
    {
        return $this->offIndustryStoreReward;
    }

    public function setOffIndustryStoreReward(int $offIndustryStoreReward): self
    {
        $this->offIndustryStoreReward = $offIndustryStoreReward;

        return $this;
    }

    public function getOffIndustryAgencyReward(): ?int
    {
        return $this->offIndustryAgencyReward;
    }

    public function setOffIndustryAgencyReward(int $offIndustryAgencyReward): self
    {
        $this->offIndustryAgencyReward = $offIndustryAgencyReward;

        return $this;
    }
}
