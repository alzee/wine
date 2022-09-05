<?php

namespace App\Entity;

use App\Repository\StoreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StoreRepository::class)]
class Store
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

    #[ORM\OneToMany(mappedBy: 'store', targetEntity: OrderAgency::class)]
    private Collection $orderAgencies;

    #[ORM\OneToMany(mappedBy: 'store', targetEntity: ProductStore::class)]
    private Collection $productStores;

    public function __construct()
    {
        $this->orderAgencies = new ArrayCollection();
        $this->productStores = new ArrayCollection();
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
     * @return Collection<int, OrderAgency>
     */
    public function getOrderAgencies(): Collection
    {
        return $this->orderAgencies;
    }

    public function addOrderAgency(OrderAgency $orderAgency): self
    {
        if (!$this->orderAgencies->contains($orderAgency)) {
            $this->orderAgencies->add($orderAgency);
            $orderAgency->setStore($this);
        }

        return $this;
    }

    public function removeOrderAgency(OrderAgency $orderAgency): self
    {
        if ($this->orderAgencies->removeElement($orderAgency)) {
            // set the owning side to null (unless already changed)
            if ($orderAgency->getStore() === $this) {
                $orderAgency->setStore(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ProductStore>
     */
    public function getProductStores(): Collection
    {
        return $this->productStores;
    }

    public function addProductStore(ProductStore $productStore): self
    {
        if (!$this->productStores->contains($productStore)) {
            $this->productStores->add($productStore);
            $productStore->setStore($this);
        }

        return $this;
    }

    public function removeProductStore(ProductStore $productStore): self
    {
        if ($this->productStores->removeElement($productStore)) {
            // set the owning side to null (unless already changed)
            if ($productStore->getStore() === $this) {
                $productStore->setStore(null);
            }
        }

        return $this;
    }
}
