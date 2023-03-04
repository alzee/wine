<?php

namespace App\Entity;

use App\Repository\ReturnItemsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ReturnItemsRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['read']],
    denormalizationContext: ['groups' => ['write']],
)]
#[ApiFilter(SearchFilter::class, properties: ['id' => 'exact'])]
class ReturnItems
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'returnItems')]
    #[ORM\JoinColumn]
    #[Groups(['read', 'write'])]
    private ?Returns $ret = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['read', 'write'])]
    private ?Product $product = null;

    #[ORM\Column(options: ["unsigned" => true])]
    #[Groups(['read', 'write'])]
    #[Assert\Positive]
    private ?int $quantity = null;

    #[ORM\ManyToMany(targetEntity: Box::class)]
    private Collection $boxes;

    public function __construct()
    {
        $this->boxes = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->product . ' x ' . $this->quantity;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRet(): ?Returns
    {
        return $this->ret;
    }

    public function setRet(?Returns $ret): self
    {
        $this->ret = $ret;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
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
        }

        return $this;
    }

    public function removeBox(Box $box): self
    {
        $this->boxes->removeElement($box);

        return $this;
    }
}
