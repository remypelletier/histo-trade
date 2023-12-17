<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ApiResource]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 128)]
    private ?string $firstname = null;

    #[ORM\Column(length: 128)]
    private ?string $lastname = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $email = null;

    #[ORM\Column(length: 64)]
    private ?string $role = null;

    #[ORM\Column(type: 'datetime', nullable: false)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: BrokerApiKey::class, orphanRemoval: true)]
    private Collection $brokerApiKeys;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Position::class)]
    private Collection $positions;

    public function __construct()
    {
        $this->brokerApiKeys = new ArrayCollection();
        $this->positions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): static
    {
        $this->role = $role;

        return $this;
    }

    public function getCreatedAt(): ?int
    {
        return $this->createdAt;
    }

    public function setCreatedAt(int $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection<int, BrokerApiKey>
     */
    public function getBrokerApiKeys(): Collection
    {
        return $this->brokerApiKeys;
    }

    public function addBrokerApiKey(BrokerApiKey $brokerApiKey): static
    {
        if (!$this->brokerApiKeys->contains($brokerApiKey)) {
            $this->brokerApiKeys->add($brokerApiKey);
            $brokerApiKey->setUser($this);
        }

        return $this;
    }

    public function removeBrokerApiKey(BrokerApiKey $brokerApiKey): static
    {
        if ($this->brokerApiKeys->removeElement($brokerApiKey)) {
            // set the owning side to null (unless already changed)
            if ($brokerApiKey->getUser() === $this) {
                $brokerApiKey->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Position>
     */
    public function getPositions(): Collection
    {
        return $this->positions;
    }

    public function addPosition(Position $position): static
    {
        if (!$this->positions->contains($position)) {
            $this->positions->add($position);
            $position->setUser($this);
        }

        return $this;
    }

    public function removePosition(Position $position): static
    {
        if ($this->positions->removeElement($position)) {
            // set the owning side to null (unless already changed)
            if ($position->getUser() === $this) {
                $position->setUser(null);
            }
        }

        return $this;
    }

}
