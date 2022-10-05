<?php

namespace App\Entity;

use App\Repository\OrgRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use Symfony\Component\HttpFoundation\File\File;

#[ORM\Entity(repositoryClass: OrgRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['read']],
    denormalizationContext: ['groups' => ['write']],
)]
#[ApiFilter(SearchFilter::class, properties: ['id' => 'exact', 'type' => 'exact', 'upstream' => 'exact'])]
#[ApiFilter(OrderFilter::class, properties: ['id'], arguments: ['orderParameterName' => 'order'])]
class Org implements \Serializable
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
    private ?string $contact = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read', 'write'])]
    private ?string $phone = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read', 'write'])]
    private ?string $address = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read', 'write'])]
    private ?string $district = null;

    #[Groups(['read', 'write'])]
    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $type = 1;

    #[ORM\OneToMany(mappedBy: 'org', targetEntity: Product::class)]
    private Collection $products;

    #[ORM\Column(options: ["unsigned" => true])]
    #[Groups(['read', 'write'])]
    private ?int $voucher = null;

    #[ORM\OneToMany(mappedBy: 'restaurant', targetEntity: OrderRestaurant::class)]
    private Collection $orderRestaurants;

    #[ORM\OneToMany(mappedBy: 'org', targetEntity: Withdraw::class)]
    private Collection $withdraws;

    #[ORM\OneToMany(mappedBy: 'org', targetEntity: Voucher::class)]
    private Collection $vouchers;

    #[ORM\OneToMany(mappedBy: 'store', targetEntity: Retail::class)]
    private Collection $retails;

    #[ORM\OneToMany(mappedBy: 'org', targetEntity: User::class)]
    private Collection $users;

    #[ORM\ManyToOne(targetEntity: self::class)]
    #[Groups(['read', 'write'])]
    private ?self $upstream = null;

    #[ORM\Column]
    #[Groups(['read', 'write'])]
    private ?float $discount = 0.95;

    #[ORM\Column(options: ["unsigned" => true])]
    #[Groups(['read'])]
    private ?int $withdrawable = 0;

    #[ORM\Column(nullable: true)]
    #[Groups(['read', 'write'])]
    private ?float $longitude = 32.625821126302;

    #[ORM\Column(nullable: true)]
    #[Groups(['read', 'write'])]
    private ?float $latitude = 110.80163384332;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read', 'write'])]
    private ?string $img = null;

    #[Assert\Image()]
    private ?File $imageFile = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column]
    #[Groups(['read'])]
    private ?int $withdrawing = 0;

    public function __construct()
    {
        $this->products = new ArrayCollection();
        $this->voucher = 0;
        $this->orderRestaurants = new ArrayCollection();
        $this->withdraws = new ArrayCollection();
        $this->vouchers = new ArrayCollection();
        $this->retails = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->name;
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

    public function getContact(): ?string
    {
        return $this->contact;
    }

    public function setContact(string $contact): self
    {
        $this->contact = $contact;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getDistrict(): ?string
    {
        return $this->district;
    }

    public function setDistrict(string $district): self
    {
        $this->district = $district;

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

    /**
     * @return Collection<int, Product>
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products->add($product);
            $product->setOrg($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getOrg() === $this) {
                $product->setOrg(null);
            }
        }

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

    /**
     * @return Collection<int, OrderRestaurant>
     */
    public function getOrderRestaurants(): Collection
    {
        return $this->orderRestaurants;
    }

    public function addOrderRestaurant(OrderRestaurant $orderRestaurant): self
    {
        if (!$this->orderRestaurants->contains($orderRestaurant)) {
            $this->orderRestaurants->add($orderRestaurant);
            $orderRestaurant->setRestaurant($this);
        }

        return $this;
    }

    public function removeOrderRestaurant(OrderRestaurant $orderRestaurant): self
    {
        if ($this->orderRestaurants->removeElement($orderRestaurant)) {
            // set the owning side to null (unless already changed)
            if ($orderRestaurant->getRestaurant() === $this) {
                $orderRestaurant->setRestaurant(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Withdraw>
     */
    public function getWithdraws(): Collection
    {
        return $this->withdraws;
    }

    public function addWithdraw(Withdraw $withdraw): self
    {
        if (!$this->withdraws->contains($withdraw)) {
            $this->withdraws->add($withdraw);
            $withdraw->setOrg($this);
        }

        return $this;
    }

    public function removeWithdraw(Withdraw $withdraw): self
    {
        if ($this->withdraws->removeElement($withdraw)) {
            // set the owning side to null (unless already changed)
            if ($withdraw->getOrg() === $this) {
                $withdraw->setOrg(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Voucher>
     */
    public function getVouchers(): Collection
    {
        return $this->vouchers;
    }

    public function addVoucher(Voucher $voucher): self
    {
        if (!$this->vouchers->contains($voucher)) {
            $this->vouchers->add($voucher);
            $voucher->setOrg($this);
        }

        return $this;
    }

    public function removeVoucher(Voucher $voucher): self
    {
        if ($this->vouchers->removeElement($voucher)) {
            // set the owning side to null (unless already changed)
            if ($voucher->getOrg() === $this) {
                $voucher->setOrg(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Retail>
     */
    public function getRetails(): Collection
    {
        return $this->retails;
    }

    public function addRetail(Retail $retail): self
    {
        if (!$this->retails->contains($retail)) {
            $this->retails->add($retail);
            $retail->setStore($this);
        }

        return $this;
    }

    public function removeRetail(Retail $retail): self
    {
        if ($this->retails->removeElement($retail)) {
            // set the owning side to null (unless already changed)
            if ($retail->getStore() === $this) {
                $retail->setStore(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->setOrg($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getOrg() === $this) {
                $user->setOrg(null);
            }
        }

        return $this;
    }

    public function getUpstream(): ?self
    {
        return $this->upstream;
    }

    public function setUpstream(?self $upstream): self
    {
        $this->upstream = $upstream;

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

    public function getWithdrawable(): ?int
    {
        return $this->withdrawable;
    }

    public function setWithdrawable(int $withdrawable): self
    {
        $this->withdrawable = $withdrawable;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(?float $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(?float $latitude): self
    {
        $this->latitude = $latitude;

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

    public function serialize()
    {
        return serialize([
            $this->id,
        ]);
    }

    public function unserialize($serialized)
    {
        list(
            $this->id,
        ) = unserialize($serialized);
    }

    public function getWithdrawing(): ?int
    {
        return $this->withdrawing;
    }

    public function setWithdrawing(?int $withdrawing): self
    {
        $this->withdrawing = $withdrawing;

        return $this;
    }
}
