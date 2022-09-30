<?php

namespace App\Entity;

use App\Repository\ScanRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;

#[ORM\Entity(repositoryClass: ScanRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['read']],
    denormalizationContext: ['groups' => ['write']],
)]
#[ApiFilter(SearchFilter::class, properties: ['id' => 'exact', 'consumer' => 'exact', 'org' => 'exact', 'rand' => 'exact'])]
class Scan
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read'])]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['read', 'write'])]
    private ?Consumer $consumer = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['read', 'write'])]
    private ?Org $org = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read', 'write'])]
    private ?string $rand = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getConsumer(): ?Consumer
    {
        return $this->consumer;
    }

    public function setConsumer(?Consumer $consumer): self
    {
        $this->consumer = $consumer;

        return $this;
    }

    public function getOrg(): ?Org
    {
        return $this->org;
    }

    public function setOrg(?Org $org): self
    {
        $this->org = $org;

        return $this;
    }

    public function getRand(): ?string
    {
        return $this->rand;
    }

    public function setRand(string $rand): self
    {
        $this->rand = $rand;

        return $this;
    }
}
