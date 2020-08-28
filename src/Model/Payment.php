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

    public function getOrderNumber(): string
    {
        return $this->orderNumber;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }
}
