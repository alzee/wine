<?php

namespace App\Entity;

use App\Repository\BoxRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Service\Sn;

#[ORM\Entity(repositoryClass: BoxRepository::class)]
class Box
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\Positive]
    #[Assert\LessThanOrEqual(1000)]
    private ?int $quantity = 1000;

    #[ORM\Column(type: Types::SMALLINT)]
    #[Assert\Positive]
    #[Assert\LessThanOrEqual(10)]
    private ?int $bottleQty = 6;

    #[ORM\OneToMany(mappedBy: 'box', targetEntity: BoxPrize::class, orphanRemoval: true, cascade: ["persist"])]
    private Collection $boxPrizes;

    #[ORM\Column(type: Types::SIMPLE_ARRAY, nullable: true)]
    private array $boxid = [];

    public function __construct()
    {
        $this->boxPrizes = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

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

    /**
     * @return Collection<int, BoxPrize>
     */
    public function getBoxPrizes(): Collection
    {
        return $this->boxPrizes;
    }

    public function addBoxPrize(BoxPrize $boxPrize): self
    {
        if (!$this->boxPrizes->contains($boxPrize)) {
            $this->boxPrizes->add($boxPrize);
            $boxPrize->setBox($this);
        }

        return $this;
    }

    public function removeBoxPrize(BoxPrize $boxPrize): self
    {
        if ($this->boxPrizes->removeElement($boxPrize)) {
            // set the owning side to null (unless already changed)
            if ($boxPrize->getBox() === $this) {
                $boxPrize->setBox(null);
            }
        }

        return $this;
    }

    public function getBoxid(): array
    {
        return $this->boxid;
    }

    public function setBoxid(?array $boxid): self
    {
        $this->boxid = $boxid;

        return $this;
    }

    public function getSnStart(): string
    {
        return Sn::toSn($this->boxid[0]);
    }

    public function getSnEnd(): string
    {
        return Sn::toSn($this->boxid[1]);
    }
}
