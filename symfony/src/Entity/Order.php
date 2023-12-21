<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $open = null;

    #[ORM\Column(nullable: true)]
    private ?float $fee = null;

    #[ORM\Column(length: 64, nullable: true)]
    private ?string $feeType = null;

    #[ORM\Column(length: 32)]
    private ?string $side = null;

    #[ORM\Column]
    private ?float $quantity = null;

    #[ORM\Column(nullable: true)]
    private ?float $leverage = null;

    #[ORM\Column(nullable: false)]
    private ?float $createdTimestamp = null;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    #[ORM\JoinColumn(nullable: false)]
    private ?position $position = null;

    #[ORM\Column]
    private ?string $brokerOrderId = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOpen(): ?float
    {
        return $this->open;
    }

    public function setOpen(float $open): static
    {
        $this->open = $open;

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

    public function getFeeType(): ?string
    {
        return $this->feeType;
    }

    public function setFeeType(?string $feeType): static
    {
        $this->feeType = $feeType;

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

    public function getPosition(): ?Position
    {
        return $this->position;
    }

    public function setPosition(?Position $position): static
    {
        $this->position = $position;

        return $this;
    }

    public function getBrokerOrderId(): ?string
    {
        return $this->brokerOrderId;
    }

    public function setBrokerOrderId(string $brokerOrderId): static
    {
        $this->brokerOrderId = $brokerOrderId;

        return $this;
    }
}
