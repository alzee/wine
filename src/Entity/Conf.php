<?php

namespace App\Entity;

use App\Repository\ConfRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ConfRepository::class)]
class Conf
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(options: ["unsigned" => true])]
    #[Assert\Positive]
    private ?int $refReward = null;

    #[ORM\Column(options: ["unsigned" => true])]
    #[Assert\Positive]
    private ?int $partnerReward = null;

    #[ORM\Column(options: ["unsigned" => true])]
    #[Assert\Positive]
    private ?int $offIndustryStoreReward = null;

    #[ORM\Column(options: ["unsigned" => true])]
    #[Assert\Positive]
    private ?int $offIndustryAgencyReward = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRefReward(): ?int
    {
        return $this->refReward;
    }

    public function setRefReward(int $refReward): self
    {
        $this->refReward = $refReward;

        return $this;
    }

    public function getPartnerReward(): ?int
    {
        return $this->partnerReward;
    }

    public function setPartnerReward(int $partnerReward): self
    {
        $this->partnerReward = $partnerReward;

        return $this;
    }

    public function getOffIndustryStoreReward(): ?int
    {
        return $this->offIndustryStoreReward;
    }

    public function setOffIndustryStoreReward(int $offIndustryStoreReward): self
    {
        $this->offIndustryStoreReward = $offIndustryStoreReward;

        return $this;
    }

    public function getOffIndustryAgencyReward(): ?int
    {
        return $this->offIndustryAgencyReward;
    }

    public function setOffIndustryAgencyReward(int $offIndustryAgencyReward): self
    {
        $this->offIndustryAgencyReward = $offIndustryAgencyReward;

        return $this;
    }
}
