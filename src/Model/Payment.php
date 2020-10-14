<?php

declare(strict_types=1);

namespace Locastic\MonriPayments\Model;

class Payment
{
    private int $amount;

    private string $orderNumber;

    private string $currency;

    private string $orderInfo;

    private array $supportedPaymentMethods;

    public function __construct(
        int $amount,
        string $orderNumber,
        string $currency,
        string $orderInfo,
        array $supportedPaymentMethods
    ) {
        $this->amount = $amount;
        $this->orderNumber = $orderNumber;
        $this->currency = $currency;
        $this->orderInfo = $orderInfo;
        $this->supportedPaymentMethods = $supportedPaymentMethods;
    }

    public function getAsArray(): array
    {
        return [
            'amount' => $this->amount,
            'order_number' => $this->orderNumber,
            'currency' => $this->currency,
            'order_info' => $this->orderInfo,
            'supported_payment_methods' => $this->supportedPaymentMethods,
        ];
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function setAmount(int $amount): void
    {
        $this->amount = $amount;
    }

    public function getOrderNumber(): string
    {
        return $this->orderNumber;
    }

    public function setOrderNumber(string $orderNumber): void
    {
        $this->orderNumber = $orderNumber;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): void
    {
        $this->currency = $currency;
    }

    public function getOrderInfo(): string
    {
        return $this->orderInfo;
    }

    public function setOrderInfo(string $orderInfo): void
    {
        $this->orderInfo = $orderInfo;
    }

    public function getSupportedPaymentMethods(): array
    {
        return $this->supportedPaymentMethods;
    }

    public function setSupportedPaymentMethods(array $supportedPaymentMethods): void
    {
        $this->supportedPaymentMethods = $supportedPaymentMethods;
    }
}
