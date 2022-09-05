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

    public function __construct()
    {
        $this->orderStores = new ArrayCollection();
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
}
