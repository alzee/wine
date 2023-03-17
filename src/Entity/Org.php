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
use ApiPlatform\Doctrine\Orm\Filter\BooleanFilter;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Ignore;

#[ORM\Entity(repositoryClass: OrgRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['read']],
    denormalizationContext: ['groups' => ['write']],
    paginationEnabled: false,
)]
#[ApiFilter(SearchFilter::class, properties: ['id' => 'exact', 'area' => 'partial', 'city' => 'exact', 'industry' => 'exact', 'type' => 'exact', 'name' => 'partial', 'referrer' => 'exact', 'salesman' => 'exact'])]
#[ApiFilter(BooleanFilter::class, properties: ['display'])]
#[ApiFilter(OrderFilter::class, properties: ['id'], arguments: ['orderParameterName' => 'order'])]
class Org
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

    #[Groups(['read', 'write'])]
    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $type = 1;

    #[ORM\Column(options: ["unsigned" => true])]
    #[Assert\PositiveOrZero]
    #[Groups(['read', 'write'])]
    private ?int $voucher = null;

    #[ORM\OneToMany(mappedBy: 'restaurant', targetEntity: OrderRestaurant::class)]
    private Collection $orderRestaurants;

    #[ORM\OneToMany(mappedBy: 'org', targetEntity: Voucher::class)]
    private Collection $vouchers;

    #[ORM\OneToMany(mappedBy: 'store', targetEntity: Retail::class)]
    private Collection $retails;

    #[ORM\OneToMany(mappedBy: 'org', targetEntity: User::class)]
    private Collection $users;

    #[ORM\ManyToOne(targetEntity: self::class)]
    #[Groups(['read', 'write'])]
    private ?self $upstream = null;

    #[ORM\Column(options: ["unsigned" => true])]
    #[Groups(['read', 'write'])]
    private ?float $discount = 1.00;

    #[ORM\Column(options: ["unsigned" => true])]
    #[Assert\PositiveOrZero]
    #[Groups(['read'])]
    private ?int $withdrawable = 0;

    #[ORM\Column(nullable: true)]
    #[Groups(['read', 'write'])]
    private ?float $longitude = 110.80163384332;

    #[ORM\Column(nullable: true)]
    #[Groups(['read', 'write'])]
    private ?float $latitude = 32.625821126302;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read', 'write'])]
    private ?string $img = null;

    #[Ignore]
    #[Assert\Image(maxSize: '1024k', mimeTypes: ['image/jpeg', 'image/png'], mimeTypesMessage: 'Only jpg and png')]
    private ?File $imageFile = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(options: ["unsigned" => true])]
    #[Assert\PositiveOrZero]
    #[Groups(['read'])]
    private ?int $withdrawing = 0;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read', 'write'])]
    private ?string $payee = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read', 'write'])]
    private ?string $bank = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read', 'write'])]
    private ?string $bankAccount = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read', 'write'])]
    private ?string $bankAddr = null;

    #[ORM\ManyToOne]
    #[Groups(['read'])]
    private ?City $city = null;

    #[ORM\ManyToOne]
    #[Groups(['read'])]
    private ?Industry $industry = null;

    #[ORM\Column]
    #[Groups(['read'])]
    private ?bool $display = true;

    #[ORM\ManyToOne]
    private ?User $manager = null;

    #[ORM\Column(options: ["unsigned" => true])]
    #[Assert\PositiveOrZero]
    #[Groups(['read'])]
    private ?int $share = 0;

    #[ORM\Column(options: ["unsigned" => true])]
    #[Assert\PositiveOrZero]
    private ?int $shareWithdrawable = 0;

    #[ORM\ManyToOne]
    private ?User $referrer = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Reg $reg = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read'])]
    private ?string $area = null;

    #[ORM\OneToMany(mappedBy: 'org', targetEntity: Box::class)]
    private Collection $boxes;

    #[ORM\OneToMany(mappedBy: 'store', targetEntity: Claim::class)]
    private Collection $claims;

    #[ORM\ManyToOne]
    private ?User $admin = null;

    #[ORM\OneToMany(mappedBy: 'serveStore', targetEntity: Claim::class)]
    private Collection $serveClaims;

    #[ORM\Column]
    #[Groups(['read'])]
    private ?int $point = 0;

    #[ORM\ManyToOne(inversedBy: 'salesmanOf')]
    #[Groups(['read'])]
    private ?User $salesman = null;

    public function __construct()
    {
        $this->voucher = 0;
        $this->orderRestaurants = new ArrayCollection();
        $this->vouchers = new ArrayCollection();
        $this->retails = new ArrayCollection();
        $this->users = new ArrayCollection();
        $this->boxes = new ArrayCollection();
        $this->claims = new ArrayCollection();
        $this->serveClaims = new ArrayCollection();
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

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): self
    {
        $this->type = $type;

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

    public function __serialize(): array
    {
        return [
            'id' => $this->id,
        ];
    }

    public function __unserialize(array $serialized): void
    {
        $this->id = $serialized['id'];
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

    public function getPayee(): ?string
    {
        return $this->payee;
    }

    public function setPayee(?string $payee): self
    {
        $this->payee = $payee;

        return $this;
    }

    public function getBank(): ?string
    {
        return $this->bank;
    }

    public function setBank(?string $bank): self
    {
        $this->bank = $bank;

        return $this;
    }

    public function getBankAccount(): ?string
    {
        return $this->bankAccount;
    }

    public function setBankAccount(?string $bankAccount): self
    {
        $this->bankAccount = $bankAccount;

        return $this;
    }

    public function getBankAddr(): ?string
    {
        return $this->bankAddr;
    }

    public function setBankAddr(?string $bankAddr): self
    {
        $this->bankAddr = $bankAddr;

        return $this;
    }

    public function getCity(): ?City
    {
        return $this->city;
    }

    public function setCity(?City $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getIndustry(): ?Industry
    {
        return $this->industry;
    }

    public function setIndustry(?Industry $industry): self
    {
        $this->industry = $industry;

        return $this;
    }

    public function isDisplay(): ?bool
    {
        return $this->display;
    }

    public function setDisplay(bool $display): self
    {
        $this->display = $display;

        return $this;
    }

    public function getManager(): ?User
    {
        return $this->manager;
    }

    public function setManager(?User $manager): self
    {
        $this->manager = $manager;

        return $this;
    }

    public function getShare(): ?int
    {
        return $this->share;
    }

    public function setShare(int $share): self
    {
        $this->share = $share;

        return $this;
    }

    public function getShareWithdrawable(): ?int
    {
        return $this->shareWithdrawable;
    }

    public function setShareWithdrawable(int $shareWithdrawable): self
    {
        $this->shareWithdrawable = $shareWithdrawable;

        return $this;
    }

    public function getReferrer(): ?User
    {
        return $this->referrer;
    }

    public function setReferrer(?User $referrer): self
    {
        $this->referrer = $referrer;

        return $this;
    }

    public function getReg(): ?Reg
    {
        return $this->reg;
    }

    public function setReg(?Reg $reg): self
    {
        $this->reg = $reg;

        return $this;
    }

    public function getArea(): ?string
    {
        return $this->area;
    }

    public function setArea(?string $area): self
    {
        $this->area = $area;

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
            $box->setOrg($this);
        }

        return $this;
    }

    public function removeBox(Box $box): self
    {
        if ($this->boxes->removeElement($box)) {
            // set the owning side to null (unless already changed)
            if ($box->getOrg() === $this) {
                $box->setOrg(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Claim>
     */
    public function getClaims(): Collection
    {
        return $this->claims;
    }

    public function addClaim(Claim $claim): self
    {
        if (!$this->claims->contains($claim)) {
            $this->claims->add($claim);
            $claim->setStore($this);
        }

        return $this;
    }

    public function removeClaim(Claim $claim): self
    {
        if ($this->claims->removeElement($claim)) {
            // set the owning side to null (unless already changed)
            if ($claim->getStore() === $this) {
                $claim->setStore(null);
            }
        }

        return $this;
    }

    public function getAdmin(): ?User
    {
        return $this->admin;
    }

    public function setAdmin(?User $admin): self
    {
        $this->admin = $admin;

        return $this;
    }

    /**
     * @return Collection<int, Claim>
     */
    public function getServeClaims(): Collection
    {
        return $this->serveClaims;
    }

    public function addServeClaim(Claim $serveClaim): self
    {
        if (!$this->serveClaims->contains($serveClaim)) {
            $this->serveClaims->add($serveClaim);
            $serveClaim->setServeStore($this);
        }

        return $this;
    }

    public function removeServeClaim(Claim $serveClaim): self
    {
        if ($this->serveClaims->removeElement($serveClaim)) {
            // set the owning side to null (unless already changed)
            if ($serveClaim->getServeStore() === $this) {
                $serveClaim->setServeStore(null);
            }
        }

        return $this;
    }

    public function getPoint(): ?int
    {
        return $this->point;
    }

    public function setPoint(int $point): self
    {
        $this->point = $point;

        return $this;
    }

    public function getSalesman(): ?User
    {
        return $this->salesman;
    }

    public function setSalesman(?User $salesman): self
    {
        $this->salesman = $salesman;

        return $this;
    }
}
