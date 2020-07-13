<?php

declare(strict_types=1);

namespace Locastic\MonriPayments;

class Payment
{
    private int $amount;

    private string $orderNumber;

    private string $currency;

    private string $transactionType;

    private string $orderInfo;

    private string $scenario;

    private string $supportedPaymentMethods;

    public function __construct(
        int $amount,
        string $orderNumber,
        string $currency,
        string $transactionType,
        string $orderInfo,
        string $scenario,
        string $supportedPaymentMethods
    ) {
        $this->amount = $amount;
        $this->orderNumber = $orderNumber;
        $this->currency = $currency;
        $this->transactionType = $transactionType;
        $this->orderInfo = $orderInfo;
        $this->scenario = $scenario;
        $this->supportedPaymentMethods = $supportedPaymentMethods;
    }

    public function getAsArray(): array
    {
        return [
            'amount' => $this->amount,
            'order_number' => $this->orderNumber,
            'currency' => $this->currency,
            'transaction_type' => $this->transactionType,
            'order_info' => $this->orderInfo,
            'scenario' => $this->scenario,
            'supported_payment_methods' => ['67f35b84811188a5c581b063c4f21bd6760c93b2a04d7ac4f8845dd5bbb3f5c6'],
        ];
    }
}
