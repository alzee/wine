<?php

namespace App\Entity;

use App\Repository\ReturnsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;

#[ORM\Entity(repositoryClass: ReturnsRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['read']],
    denormalizationContext: ['groups' => ['write']],
)]
#[ApiFilter(SearchFilter::class, properties: ['id' => 'exact', 'sender' => 'exact', 'recipient' => 'exact'])]
class Returns
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'returns')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['read'])]
    private ?Org $sender = null;

    #[ORM\ManyToOne(inversedBy: 'returns')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['read'])]
    private ?Org $recipient = null;

    #[ORM\Column(options: ["unsigned" => true])]
    #[Groups(['read'])]
    private ?int $amount = 0;

    #[ORM\Column(options: ["unsigned" => true])]
    #[Groups(['read'])]
    private ?int $voucher = 0;

    #[ORM\Column(type: Types::SMALLINT)]
    #[Groups(['read'])]
    private ?int $status = 0;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['read'])]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read'])]
    private ?string $note = null;

    #[ORM\OneToMany(mappedBy: 'ret', targetEntity: ReturnItems::class, cascade: ["persist"])]
    #[Groups(['read'])]
    private Collection $returnItems;

    public function __construct()
    {
        $this->date = new \DateTime();
        $this->returnItems = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSender(): ?Org
    {
        return $this->sender;
    }

    public function setSender(?Org $sender): self
    {
        $this->sender = $sender;

        return $this;
    }

    public function getRecipient(): ?Org
    {
        return $this->recipient;
    }

    public function setRecipient(?Org $recipient): self
    {
        $this->recipient = $recipient;

        return $this;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): self
    {
        $this->amount = $amount;

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

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): self
    {
        $this->note = $note;

        return $this;
    }

    /**
     * @return Collection<int, ReturnItems>
     */
    public function getReturnItems(): Collection
    {
        return $this->returnItems;
    }

    public function addReturnItem(ReturnItems $returnItem): self
    {
        if (!$this->returnItems->contains($returnItem)) {
            $this->returnItems->add($returnItem);
            $returnItem->setRet($this);
        }

        return $this;
    }

    public function removeReturnItem(ReturnItems $returnItem): self
    {
        if ($this->returnItems->removeElement($returnItem)) {
            // set the owning side to null (unless already changed)
            if ($returnItem->getRet() === $this) {
                $returnItem->setRet(null);
            }
        }

        return $this;
    }
}
