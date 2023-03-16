<?php

namespace App\Entity;

use App\Repository\PackRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PackRepository::class)]
class Pack
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'pack', targetEntity: PackPrize::class, cascade: ["persist"])]
    #[Assert\Valid]
    private Collection $packPrizes;

    #[ORM\Column]
    private ?bool $forRestaurant = false;

    #[ORM\Column]
    private ?bool $forClaim = false;
    
    public function __toString()
    {
        return $this->name;
    }

    public function __construct()
    {
        $this->packPrizes = new ArrayCollection();
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

    /**
     * @return Collection<int, PackPrize>
     */
    public function getPackPrizes(): Collection
    {
        return $this->packPrizes;
    }

    public function addPackPrize(PackPrize $packPrize): self
    {
        if (!$this->packPrizes->contains($packPrize)) {
            $this->packPrizes->add($packPrize);
            $packPrize->setPack($this);
        }

        return $this;
    }

    public function removePackPrize(PackPrize $packPrize): self
    {
        if ($this->packPrizes->removeElement($packPrize)) {
            // set the owning side to null (unless already changed)
            if ($packPrize->getPack() === $this) {
                $packPrize->setPack(null);
            }
        }

        return $this;
    }

    public function isForRestaurant(): ?bool
    {
        return $this->forRestaurant;
    }

    public function setForRestaurant(bool $forRestaurant): self
    {
        $this->forRestaurant = $forRestaurant;

        return $this;
    }

    public function isForClaim(): ?bool
    {
        return $this->forClaim;
    }

    public function setForClaim(bool $forClaim): self
    {
        $this->forClaim = $forClaim;

        return $this;
    }
}
