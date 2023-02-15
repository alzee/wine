<?php

namespace App\Entity;

use App\Repository\BatchRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Service\Sn;

#[ORM\Entity(repositoryClass: BatchRepository::class)]
class Batch
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\Positive]
    #[Assert\LessThanOrEqual(1000)]
    private ?int $qty = null;

    #[ORM\Column(type: Types::SMALLINT)]
    #[Assert\Positive]
    #[Assert\LessThanOrEqual(10)]
    private ?int $bottleQty = 6;

    #[ORM\Column]
    private ?int $start = null;

    #[ORM\OneToMany(mappedBy: 'batch', targetEntity: BatchPrize::class, orphanRemoval: true, cascade: ["persist"])]
    #[Assert\Valid]
    private Collection $batchPrizes;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $type = 0;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $snStart = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $snEnd = null;

    public function __construct()
    {
        $this->batchPrizes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQty(): ?int
    {
        return $this->qty;
    }

    public function setQty(int $qty): self
    {
        $this->qty = $qty;

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

    public function getStart(): ?int
    {
        return $this->start;
    }

    public function setStart(int $start): self
    {
        $this->start = $start;

        return $this;
    }

    /**
     * @return Collection<int, BatchPrize>
     */
    public function getBatchPrizes(): Collection
    {
        return $this->batchPrizes;
    }

    public function addBatchPrize(BatchPrize $batchPrize): self
    {
        if (!$this->batchPrizes->contains($batchPrize)) {
            $this->batchPrizes->add($batchPrize);
            $batchPrize->setBatch($this);
        }

        return $this;
    }

    public function removeBatchPrize(BatchPrize $batchPrize): self
    {
        if ($this->batchPrizes->removeElement($batchPrize)) {
            // set the owning side to null (unless already changed)
            if ($batchPrize->getBatch() === $this) {
                $batchPrize->setBatch(null);
            }
        }

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

    public function setSnStart(?string $snStart): self
    {
        $this->snStart = $snStart;

        return $this;
    }

    public function setSnEnd(?string $snEnd): self
    {
        $this->snEnd = $snEnd;

        return $this;
    }

    public function getSnStart(): ?string
    {
        return $this->snStart;
    }

    public function getSnEnd(): ?string
    {
        return $this->snEnd;
    }
}
