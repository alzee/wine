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
    #[Assert\Positive]
    private ?int $orgRefReward = 0;

    #[ORM\Column(type: Types::SMALLINT, options: ["unsigned" => true])]
    #[Assert\Positive]
    private ?int $variantHeadShare = 0;

    #[ORM\Column(type: Types::SMALLINT, options: ["unsigned" => true])]
    #[Assert\Positive]
    private ?int $variantAgencyShare = 0;

    #[ORM\Column(type: Types::SMALLINT, options: ["unsigned" => true])]
    #[Assert\Positive]
    private ?int $variantStoreShare = 0;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['read'])]
    private ?string $intro = null;

    #[ORM\Column(options: ["unsigned" => true])]
    #[Assert\Positive]
    #[Groups(['read'])]
    private ?int $unitPrice = null;

    #[ORM\Column(options: ["unsigned" => true])]
    #[Assert\Positive]
    #[Groups(['read'])]
    private ?int $unitPricePromo = null;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: Box::class)]
    private Collection $boxes;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $bottleQty = 6;

    #[ORM\Column(options: ["unsigned" => true])]
    #[Assert\Positive]
    #[Groups(['read'])]
    private ?int $waiterTip = null;

    #[ORM\Column(type: Types::SMALLINT, options: ["unsigned" => true])]
    #[Assert\Positive]
    private ?int $agencyRefReward = null;

    #[ORM\Column(type: Types::SMALLINT, options: ["unsigned" => true])]
    #[Assert\Positive]
    private ?int $storeRefReward = null;

    public function __construct()
    {
        $this->boxes = new ArrayCollection();
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

    public function getVariantHeadShare(): ?int
    {
        return $this->variantHeadShare;
    }

    public function setVariantHeadShare(int $variantHeadShare): self
    {
        $this->variantHeadShare = $variantHeadShare;

        return $this;
    }

    public function getVariantAgencyShare(): ?int
    {
        return $this->variantAgencyShare;
    }

    public function setVariantAgencyShare(int $variantAgencyShare): self
    {
        $this->variantAgencyShare = $variantAgencyShare;

        return $this;
    }

    public function getVariantStoreShare(): ?int
    {
        return $this->variantStoreShare;
    }

    public function setVariantStoreShare(int $variantStoreShare): self
    {
        $this->variantStoreShare = $variantStoreShare;

        return $this;
    }

    public function getIntro(): ?string
    {
        return $this->intro;
    }

    public function setIntro(?string $intro): self
    {
        $this->intro = $intro;

        return $this;
    }

    public function getUnitPrice(): ?int
    {
        return $this->unitPrice;
    }

    public function setUnitPrice(int $unitPrice): self
    {
        $this->unitPrice = $unitPrice;

        return $this;
    }

    public function getUnitPricePromo(): ?int
    {
        return $this->unitPricePromo;
    }

    public function setUnitPricePromo(int $unitPricePromo): self
    {
        $this->unitPricePromo = $unitPricePromo;

        return $this;
    }

    /**
     * @return Collection<int, Box>
     */
    public function getBoxes(): Collection
    {
        return $this->boxes;
    }

    public function addBox(Box $box): self
    {
        if (!$this->boxes->contains($box)) {
            $this->boxes->add($box);
            $box->setProduct($this);
        }

        return $this;
    }

    public function removeBox(Box $box): self
    {
        if ($this->boxes->removeElement($box)) {
            // set the owning side to null (unless already changed)
            if ($box->getProduct() === $this) {
                $box->setProduct(null);
            }
        }

        return $this;
    }

    public function getBottleQty(): ?int
    {
        return $this->bottleQty;
    }

    public function setBottleQty(int $bottleQty): self
    {
        $this->bottleQty = $bottleQty;

        return $this;
    }

    public function getWaiterTip(): ?int
    {
        return $this->waiterTip;
    }

    public function setWaiterTip(int $waiterTip): self
    {
        $this->waiterTip = $waiterTip;

        return $this;
    }

    public function getAgencyRefReward(): ?int
    {
        return $this->agencyRefReward;
    }

    public function setAgencyRefReward(int $agencyRefReward): self
    {
        $this->agencyRefReward = $agencyRefReward;

        return $this;
    }

    public function getStoreRefReward(): ?int
    {
        return $this->storeRefReward;
    }

    public function setStoreRefReward(int $storeRefReward): self
    {
        $this->storeRefReward = $storeRefReward;

        return $this;
    }
}
