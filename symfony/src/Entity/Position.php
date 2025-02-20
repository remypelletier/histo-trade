<?php

namespace App\Entity;

use App\Repository\PositionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Link;
use ApiPlatform\Metadata\GetCollection;


#[ORM\Entity(repositoryClass: PositionRepository::class)]
#[ApiResource]
#[ApiResource(
    uriTemplate: '/users/{id}/positions', 
    uriVariables: [
        'id' => new Link(fromClass: User::class, fromProperty: 'positions')
    ], 
    operations: [new GetCollection()]
)]
class Position
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 64)]
    private ?string $symbol = null;

    #[ORM\Column(nullable: true)]
    private ?float $openAverage = null;

    #[ORM\Column(nullable: true)]
    private ?float $closeAverage = null;

    #[ORM\Column(length: 32)]
    private ?string $side = null;

    #[ORM\Column(nullable: true)]
    private ?float $pnl = null;

    #[ORM\Column]
    private ?float $quantity = null;

    #[ORM\Column(nullable: true)]
    private ?float $leverage = null;

    #[ORM\Column(nullable: false)]
    private ?float $createdTimestamp = null;

    #[ORM\Column(nullable: true)]
    private ?float $endedTimestamp = null;

    #[ORM\ManyToOne(inversedBy: 'positions')]
    private ?User $user = null;

    #[ORM\OneToMany(mappedBy: 'position', targetEntity: Order::class, orphanRemoval: true)]
    private Collection $orders;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Broker $broker = null;

    #[ORM\Column(nullable: true)]
    private ?float $fee = null;

    #[ORM\Column]
    private ?int $brokerPositionId = null;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSymbol(): ?string
    {
        return $this->symbol;
    }

    public function setSymbol(string $symbol): static
    {
        $this->symbol = $symbol;

        return $this;
    }

    public function getOpenAverage(): ?float
    {
        return $this->openAverage;
    }

    public function setOpenAverage(?float $openAverage): static
    {
        $this->openAverage = $openAverage;

        return $this;
    }

    public function getCloseAverage(): ?float
    {
        return $this->closeAverage;
    }

    public function setCloseAverage(?float $closeAverage): static
    {
        $this->closeAverage = $closeAverage;

        return $this;
    }

    public function getSide(): ?string
    {
        return $this->side;
    }

    public function setSide(string $side): static
    {
        $this->side = $side;

        return $this;
    }

    public function getPnl(): ?float
    {
        return $this->pnl;
    }

    public function setPnl(?float $pnl): static
    {
        $this->pnl = $pnl;

        return $this;
    }

    public function getQuantity(): ?float
    {
        return $this->quantity;
    }

    public function setQuantity(float $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getLeverage(): ?float
    {
        return $this->leverage;
    }

    public function setLeverage(?float $leverage): static
    {
        $this->leverage = $leverage;

        return $this;
    }

    public function getCreatedTimestamp(): ?float
    {
        return $this->createdTimestamp;
    }

    public function setCreatedTimestamp(?float $createdTimestamp): static
    {
        $this->createdTimestamp = $createdTimestamp;

        return $this;
    }

    public function getEndedTimestamp(): ?float
    {
        return $this->endedTimestamp;
    }

    public function setEndedTimestamp(?float $endedTimestamp): static
    {
        $this->endedTimestamp = $endedTimestamp;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, Order>
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    public function addOrder(Order $order): static
    {
        if (!$this->orders->contains($order)) {
            $this->orders->add($order);
            $order->setPosition($this);
        }

        return $this;
    }

    public function removeOrder(Order $order): static
    {
        if ($this->orders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getPosition() === $this) {
                $order->setPosition(null);
            }
        }

        return $this;
    }

    public function getBroker(): ?Broker
    {
        return $this->broker;
    }

    public function setBroker(?Broker $broker): static
    {
        $this->broker = $broker;

        return $this;
    }

    public function getFee(): ?float
    {
        return $this->fee;
    }

    public function setFee(?float $fee): static
    {
        $this->fee = $fee;

        return $this;
    }

    public function getBrokerPositionId(): ?int
    {
        return $this->brokerPositionId;
    }

    public function setBrokerPositionId(int $brokerPositionId): static
    {
        $this->brokerPositionId = $brokerPositionId;

        return $this;
    }

}
