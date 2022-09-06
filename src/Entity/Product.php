<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $spec = null;

    #[ORM\Column]
    private ?int $price = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $stock = null;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: Order::class)]
    private Collection $orders;

    #[ORM\Column(length: 255)]
    private ?string $sn = null;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: ProductAgency::class)]
    private Collection $productAgencies;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: ProductStore::class)]
    private Collection $productStores;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: ProductRestaurant::class)]
    private Collection $productRestaurants;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $voucher = null;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
        $this->productAgencies = new ArrayCollection();
        $this->productStores = new ArrayCollection();
        $this->productRestaurants = new ArrayCollection();
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

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): self
    {
        $this->stock = $stock;

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
            $order->setProduct($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): self
    {
        if ($this->orders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getProduct() === $this) {
                $order->setProduct(null);
            }
        }

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
            $productAgency->setProduct($this);
        }

        return $this;
    }

    public function removeProductAgency(ProductAgency $productAgency): self
    {
        if ($this->productAgencies->removeElement($productAgency)) {
            // set the owning side to null (unless already changed)
            if ($productAgency->getProduct() === $this) {
                $productAgency->setProduct(null);
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
            $productStore->setProduct($this);
        }

        return $this;
    }

    public function removeProductStore(ProductStore $productStore): self
    {
        if ($this->productStores->removeElement($productStore)) {
            // set the owning side to null (unless already changed)
            if ($productStore->getProduct() === $this) {
                $productStore->setProduct(null);
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
            $productRestaurant->setProduct($this);
        }

        return $this;
    }

    public function removeProductRestaurant(ProductRestaurant $productRestaurant): self
    {
        if ($this->productRestaurants->removeElement($productRestaurant)) {
            // set the owning side to null (unless already changed)
            if ($productRestaurant->getProduct() === $this) {
                $productRestaurant->setProduct(null);
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
}
