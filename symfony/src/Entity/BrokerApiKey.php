<?php

namespace App\Entity;

use App\Repository\BrokerApiKeyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BrokerApiKeyRepository::class)]
class BrokerApiKey
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'brokerApiKeyId', targetEntity: User::class)]
    private Collection $userId;

    #[ORM\Column(length: 255)]
    private ?string $secretKey = null;

    #[ORM\Column(length: 255)]
    private ?string $accessKey = null;

    #[ORM\OneToMany(mappedBy: 'brokerApiKeyId', targetEntity: Broker::class)]
    private Collection $brokerId;

    public function __construct()
    {
        $this->userId = new ArrayCollection();
        $this->brokerId = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUserId(): Collection
    {
        return $this->userId;
    }

    public function addUserId(User $userId): static
    {
        if (!$this->userId->contains($userId)) {
            $this->userId->add($userId);
            $userId->setBrokerApiKeyId($this);
        }

        return $this;
    }

    public function removeUserId(User $userId): static
    {
        if ($this->userId->removeElement($userId)) {
            // set the owning side to null (unless already changed)
            if ($userId->getBrokerApiKeyId() === $this) {
                $userId->setBrokerApiKeyId(null);
            }
        }

        return $this;
    }

    public function getSecretKey(): ?string
    {
        return $this->secretKey;
    }

    public function setSecretKey(string $secretKey): static
    {
        $this->secretKey = $secretKey;

        return $this;
    }

    public function getAccessKey(): ?string
    {
        return $this->accessKey;
    }

    public function setAccessKey(string $accessKey): static
    {
        $this->accessKey = $accessKey;

        return $this;
    }

    /**
     * @return Collection<int, Broker>
     */
    public function getBrokerId(): Collection
    {
        return $this->brokerId;
    }

    public function addBrokerId(Broker $brokerId): static
    {
        if (!$this->brokerId->contains($brokerId)) {
            $this->brokerId->add($brokerId);
            $brokerId->setBrokerApiKeyId($this);
        }

        return $this;
    }

    public function removeBrokerId(Broker $brokerId): static
    {
        if ($this->brokerId->removeElement($brokerId)) {
            // set the owning side to null (unless already changed)
            if ($brokerId->getBrokerApiKeyId() === $this) {
                $brokerId->setBrokerApiKeyId(null);
            }
        }

        return $this;
    }
}
