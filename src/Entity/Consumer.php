<?php

namespace App\Entity;

use App\Repository\ConsumerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;

#[ORM\Entity(repositoryClass: ConsumerRepository::class)]
#[ApiResource]
class Consumer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $openid = null;

    #[ORM\Column]
    private ?int $voucher = null;

    #[ORM\OneToMany(mappedBy: 'consumer', targetEntity: OrderRestaurant::class)]
    private Collection $orderRestaurants;

    #[ORM\OneToMany(mappedBy: 'consumer', targetEntity: Voucher::class)]
    private Collection $vouchers;

    #[ORM\OneToMany(mappedBy: 'consumer', targetEntity: Retail::class)]
    private Collection $retails;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $phone = null;

    public function __construct()
    {
        $this->orderRestaurants = new ArrayCollection();
        $this->vouchers = new ArrayCollection();
        $this->retails = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->openid;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOpenid(): ?string
    {
        return $this->openid;
    }

    public function setOpenid(string $openid): self
    {
        $this->openid = $openid;

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
            $orderRestaurant->setConsumer($this);
        }

        return $this;
    }

    public function removeOrderRestaurant(OrderRestaurant $orderRestaurant): self
    {
        if ($this->orderRestaurants->removeElement($orderRestaurant)) {
            // set the owning side to null (unless already changed)
            if ($orderRestaurant->getConsumer() === $this) {
                $orderRestaurant->setConsumer(null);
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
            $voucher->setConsumer($this);
        }

        return $this;
    }

    public function removeVoucher(Voucher $voucher): self
    {
        if ($this->vouchers->removeElement($voucher)) {
            // set the owning side to null (unless already changed)
            if ($voucher->getConsumer() === $this) {
                $voucher->setConsumer(null);
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
            $retail->setConsumer($this);
        }

        return $this;
    }

    public function removeRetail(Retail $retail): self
    {
        if ($this->retails->removeElement($retail)) {
            // set the owning side to null (unless already changed)
            if ($retail->getConsumer() === $this) {
                $retail->setConsumer(null);
            }
        }

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }
}
