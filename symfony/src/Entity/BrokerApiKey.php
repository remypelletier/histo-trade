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

    #[ORM\Column(length: 255)]
    private ?string $secretKey = null;

    #[ORM\Column(length: 255)]
    private ?string $accessKey = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?broker $broker = null;

    #[ORM\ManyToOne(inversedBy: 'brokerApiKeys')]
    #[ORM\JoinColumn(nullable: false)]
    private ?user $user = null;

    public function __construct()
    {
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getBroker(): ?broker
    {
        return $this->broker;
    }

    public function setBroker(?broker $broker): static
    {
        $this->broker = $broker;

        return $this;
    }

    public function getUser(): ?user
    {
        return $this->user;
    }

    public function setUser(?user $user): static
    {
        $this->user = $user;

        return $this;
    }

}
