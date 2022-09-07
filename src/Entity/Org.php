<?php

namespace App\Entity;

use App\Repository\OrgRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;

#[ORM\Entity(repositoryClass: OrgRepository::class)]
#[ApiResource]
class Org
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $contact = null;

    #[ORM\Column(length: 255)]
    private ?string $phone = null;

    #[ORM\Column(length: 255)]
    private ?string $address = null;

    #[ORM\Column(length: 255)]
    private ?string $district = null;

    /**
     * 0 head
     * 1 agency
     * 2 store
     */
    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $type = null;

    #[ORM\OneToMany(mappedBy: 'seller', targetEntity: Orders::class)]
    private Collection $orders;

    #[ORM\OneToMany(mappedBy: 'sender', targetEntity: Returns::class)]
    private Collection $returns;

    #[ORM\OneToMany(mappedBy: 'org', targetEntity: Product::class)]
    private Collection $products;

    #[ORM\Column]
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

    public function __construct()
    {
        $this->orders = new ArrayCollection();
        $this->returns = new ArrayCollection();
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
     * @return Collection<int, Orders>
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Orders $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders->add($order);
            $order->setSeller($this);
        }

        return $this;
    }

    public function removeOrder(Orders $order): self
    {
        if ($this->orders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getSeller() === $this) {
                $order->setSeller(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Returns>
     */
    public function getReturns(): Collection
    {
        return $this->returns;
    }

    public function addReturn(Returns $return): self
    {
        if (!$this->returns->contains($return)) {
            $this->returns->add($return);
            $return->setSender($this);
        }

        return $this;
    }

    public function removeReturn(Returns $return): self
    {
        if ($this->returns->removeElement($return)) {
            // set the owning side to null (unless already changed)
            if ($return->getSender() === $this) {
                $return->setSender(null);
            }
        }

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
}
