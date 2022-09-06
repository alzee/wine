<?php

namespace App\Entity;

use App\Repository\AgencyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AgencyRepository::class)]
class Agency
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

    #[ORM\OneToMany(mappedBy: 'agency', targetEntity: Order::class)]
    private Collection $orders;

    #[ORM\OneToMany(mappedBy: 'agency', targetEntity: ProductAgency::class)]
    private Collection $productAgencies;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
        $this->productAgencies = new ArrayCollection();
    }

    public function __toString(): string
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

    /**
     * @return Collection<int, Order>
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): self
    {
        if (!$this->orders->contains($order)) {
            $this->orders->add($order);
            $order->setAgency($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): self
    {
        if ($this->orders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getAgency() === $this) {
                $order->setAgency(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ProductAgency>
     */
    public function getProductAgencies(): Collection
    {
        return $this->productAgencies;
    }

    public function addProductAgency(ProductAgency $productAgency): self
    {
        if (!$this->productAgencies->contains($productAgency)) {
            $this->productAgencies->add($productAgency);
            $productAgency->setAgency($this);
        }

        return $this;
    }

    public function removeProductAgency(ProductAgency $productAgency): self
    {
        if ($this->productAgencies->removeElement($productAgency)) {
            // set the owning side to null (unless already changed)
            if ($productAgency->getAgency() === $this) {
                $productAgency->setAgency(null);
            }
        }

        return $this;
    }
}
