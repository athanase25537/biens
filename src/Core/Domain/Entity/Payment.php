<?php

namespace App\Core\Domain\Entity;

class Payment

{
    private string $stripe_payment_id;
    private float $amount;
    private string $currency;
    private int $status;
    private \DateTime $created_at;
    private \DateTime $updated_at;

    // Constructeur
    public function __construct(
        string $stripe_payment_id,
        float $amount,
        string $currency,
        int $status,
        \DateTime $created_at,
        \DateTime $updated_at
    ) {
        $this->stripe_payment_id = $stripe_payment_id;
        $this->amount = $amount;
        $this->currency = $currency;
        $this->status = $status;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }

    // Getters
    public function getStripePaymentId(): string
    {
        return $this->stripe_payment_id;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->created_at;
    }

    public function getUpdatedAt(): \DateTime
    {
        return $this->updated_at;
    }

    // Setters
    public function setStripePaymentId(string $stripe_payment_id): void
    {
        $this->stripe_payment_id = $stripe_payment_id;
    }

    public function setAmount(float $amount): void
    {
        $this->amount = $amount;
    }

    public function setCurrency(string $currency): void
    {
        $this->currency = $currency;
    }

    public function setStatus(int $status): void
    {
        $this->status = $status;
    }

    public function setCreatedAt(\DateTime $created_at): void
    {
        $this->created_at = $created_at;
    }

    public function setUpdatedAt(\DateTime $updated_at): void
    {
        $this->updated_at = $updated_at;
    }
}
