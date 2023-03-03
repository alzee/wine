<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use App\Entity\Choice;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity('username',
    message: 'This username is already in use',
)]
#[UniqueEntity(
    fields: 'openid',
    message: 'Openid is already in use',
)]
#[UniqueEntity(
    fields: 'phone',
    message: 'Phone is already in use',
)]
#[ApiResource(
    normalizationContext: ['groups' => ['read']],
    denormalizationContext: ['groups' => ['write']],
)]
#[ApiFilter(SearchFilter::class, properties: ['id' => 'exact', 'openid' => 'exact', 'phone' => 'exact', 'referrer' => 'exact'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read'])]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 30)]
    //#[Assert\Regex(
    //pattern: '/^\d/',
    //    match: false,
    //    message: 'Username cannot start with number',
    //)]
    #[Groups(['read'])]
    private ?string $username = null;

    #[ORM\Column]
    #[Groups(['read'])]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\ManyToOne(inversedBy: 'users')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['read'])]
    private ?Org $org = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $plainPassword = null;

    #[ORM\Column(length: 255, nullable: true, unique: true)]
    #[Groups(['read', 'write'])]
    private ?string $phone = null;

    #[ORM\Column(length: 255, nullable: true, unique: true)]
    #[Groups(['read'])]
    private ?string $openid = null;

    #[ORM\Column]
    #[Groups(['read'])]
    private ?int $voucher = 0;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read', 'write'])]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read', 'write'])]
    private ?string $avatar = 'default.jpg';

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\ManyToOne(targetEntity: self::class)]
    private ?self $referrer = null;

    #[ORM\Column]
    #[Groups(['read'])]
    private ?int $reward = 0;

    #[ORM\Column]
    #[Groups(['read'])]
    private ?int $withdrawable = 0;

    #[ORM\Column]
    #[Groups(['read'])]
    private ?int $withdrawing = 0;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read', 'write'])]
    private ?string $nick = null;

    #[ORM\OneToMany(mappedBy: 'customer', targetEntity: Claim::class)]
    private Collection $claims;

    #[ORM\Column]
    #[Groups(['read'])]
    private ?int $point = 0;

    #[ORM\Column]
    #[Groups(['read'])]
    private ?bool $reloginRequired = false;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Collect::class)]
    private Collection $collects;

    public function __toString()
    {
        $s = '';
        if (! is_null($this->name)) {
            $s = $this->name;
        }
        if (! is_null($this->phone)) {
            $s .= ' ' . $this->phone;
        }
        $s = empty($s) ? $this->username : $s;
        return $s;
    }

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->claims = new ArrayCollection();
        $this->collects = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        $orgTypes = array_flip(Choice::ORG_TYPES_ALL);
        $orgType = $orgTypes[$this->org->getType()];
        $roles[] = 'ROLE_' . strtoupper($orgType);
        if ($this->org->getAdmin() === $this) {
            $roles[] = 'ROLE_ORG_ADMIN';
        }
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = array_values($roles);

        return $this;
    }
    
    public function addRole(string $role): self
    {
        $role = strtoupper($role);
        if (! str_starts_with($role, 'ROLE_')) {
            $role = 'ROLE_' . $role;
        }
        $roles = $this->roles;
        $roles[] = $role;
        $roles = array_unique($roles);
        $roles = array_values($roles);
        $this->setRoles($roles);
        
        return $this;
    }
    
    public function delRole(string $role): self
    {
        $role = strtoupper($role);
        if (! str_starts_with($role, 'ROLE_')) {
            $role = 'ROLE_' . $role;
        }
        $roles = $this->roles;
        $index = array_search($role, $roles);
        array_splice($roles, $index, 1);
        $roles = array_values($roles);
        $this->setRoles($roles);
        
        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        $this->plainPassword = null;
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

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(?string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;

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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(?string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getReferrer(): ?self
    {
        return $this->referrer;
    }

    public function setReferrer(?self $referrer): self
    {
        $this->referrer = $referrer;

        return $this;
    }

    public function getReward(): ?int
    {
        return $this->reward;
    }

    public function setReward(int $reward): self
    {
        $this->reward = $reward;

        return $this;
    }

    public function getWithdrawable(): ?int
    {
        return $this->withdrawable;
    }

    public function setWithdrawable(int $withdrawable): self
    {
        $this->withdrawable = $withdrawable;

        return $this;
    }

    public function getWithdrawing(): ?int
    {
        return $this->withdrawing;
    }

    public function setWithdrawing(int $withdrawing): self
    {
        $this->withdrawing = $withdrawing;

        return $this;
    }

    public function getNick(): ?string
    {
        return $this->nick;
    }

    public function setNick(?string $nick): self
    {
        $this->nick = $nick;

        return $this;
    }

    /**
     * @return Collection<int, Claim>
     */
    public function getClaims(): Collection
    {
        return $this->claims;
    }

    public function addClaim(Claim $claim): self
    {
        if (!$this->claims->contains($claim)) {
            $this->claims->add($claim);
            $claim->setCustomer($this);
        }

        return $this;
    }

    public function removeClaim(Claim $claim): self
    {
        if ($this->claims->removeElement($claim)) {
            // set the owning side to null (unless already changed)
            if ($claim->getCustomer() === $this) {
                $claim->setCustomer(null);
            }
        }

        return $this;
    }

    public function getPoint(): ?int
    {
        return $this->point;
    }

    public function setPoint(int $point): self
    {
        $this->point = $point;

        return $this;
    }

    public function isReloginRequired(): ?bool
    {
        return $this->reloginRequired;
    }

    public function setReloginRequired(bool $reloginRequired): self
    {
        $this->reloginRequired = $reloginRequired;

        return $this;
    }

    /**
     * @return Collection<int, Collect>
     */
    public function getCollects(): Collection
    {
        return $this->collects;
    }

    public function addCollect(Collect $collect): self
    {
        if (!$this->collects->contains($collect)) {
            $this->collects->add($collect);
            $collect->setUser($this);
        }

        return $this;
    }

    public function removeCollect(Collect $collect): self
    {
        if ($this->collects->removeElement($collect)) {
            // set the owning side to null (unless already changed)
            if ($collect->getUser() === $this) {
                $collect->setUser(null);
            }
        }

        return $this;
    }
}
