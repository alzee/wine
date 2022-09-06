<?php

namespace App\Entity;

use App\Repository\RestaurantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RestaurantRepository::class)]
class Restaurant
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

    #[ORM\OneToMany(mappedBy: 'restaurant', targetEntity: OrderStore::class)]
    private Collection $orderStores;

    #[ORM\OneToMany(mappedBy: 'restaurant', targetEntity: ProductRestaurant::class)]
    private Collection $productRestaurants;

    #[ORM\OneToMany(mappedBy: 'restaurant', targetEntity: OrderRestaurant::class)]
    private Collection $orderRestaurants;

    #[ORM\Column]
    private ?int $voucher = null;

    #[ORM\OneToMany(mappedBy: 'restaurant', targetEntity: Withdraw::class)]
    private Collection $withdraws;

    public function __construct()
    {
        $this->orderStores = new ArrayCollection();
        $this->productRestaurants = new ArrayCollection();
        $this->orderRestaurants = new ArrayCollection();
        $this->voucher = 0;
        $this->withdraws = new ArrayCollection();
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

    /**
     * @return Collection<int, OrderStore>
     */
    public function getOrderStores(): Collection
    {
        return $this->orderStores;
    }

    public function addOrderStore(OrderStore $orderStore): self
    {
        if (!$this->orderStores->contains($orderStore)) {
            $this->orderStores->add($orderStore);
            $orderStore->setRestaurant($this);
        }

        return $this;
    }

    public function removeOrderStore(OrderStore $orderStore): self
    {
        if ($this->orderStores->removeElement($orderStore)) {
            // set the owning side to null (unless already changed)
            if ($orderStore->getRestaurant() === $this) {
                $orderStore->setRestaurant(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ProductRestaurant>
     */
    public function getProductRestaurants(): Collection
    {
        return $this->productRestaurants;
    }

    public function addProductRestaurant(ProductRestaurant $productRestaurant): self
    {
        if (!$this->productRestaurants->contains($productRestaurant)) {
            $this->productRestaurants->add($productRestaurant);
            $productRestaurant->setRestaurant($this);
        }

        return $this;
    }

    public function removeProductRestaurant(ProductRestaurant $productRestaurant): self
    {
        if ($this->productRestaurants->removeElement($productRestaurant)) {
            // set the owning side to null (unless already changed)
            if ($productRestaurant->getRestaurant() === $this) {
                $productRestaurant->setRestaurant(null);
            }
        }

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
            $withdraw->setRestaurant($this);
        }

        return $this;
    }

    public function removeWithdraw(Withdraw $withdraw): self
    {
        if ($this->withdraws->removeElement($withdraw)) {
            // set the owning side to null (unless already changed)
            if ($withdraw->getRestaurant() === $this) {
                $withdraw->setRestaurant(null);
            }
        }

        return $this;
    }
}
