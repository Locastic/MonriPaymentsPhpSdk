<?php

declare(strict_types=1);

namespace Locastic\MonriPayments;

class Api
{
    private bool $sandbox;

    private string $merchantKey;

    private string $authenticityToken;

    public function __construct(bool $sandbox, string $merchantKey, string $authenticityToken)
    {
        $this->sandbox = $sandbox;
        $this->merchantKey = $merchantKey;
        $this->authenticityToken = $authenticityToken;
    }

    public function authorize(Payment $payment): array
    {
        $data = $payment->getAsArray();
        $data['transaction_type'] = 'authorize';
        $data['scenario'] = 'charge';
    }

    public function capture(Payment $payment): array
    {
        $data = $payment->getAsArray();
        $data['transaction_type'] = 'charge';
        $data['scenario'] = 'charge';
    }

    public function addPaymentMethod(Payment $payment): array
    {
        $data = $payment->getAsArray();
        $data['transaction_type'] = 'charge';
        $data['scenario'] = 'add_payment_method';
    }

    private function getApiEndpoint(): string
    {
        if ($this->sandbox) {
            return 'https://ipgtest.monri.com';
        }

        return 'https://ipg.monri.com';
    }

    private function getAuthorization(string $bodyAsString): string
    {
        $timestamp = time();
        $digest = hash('sha512', $this->merchantKey.$timestamp.$this->authenticityToken.$bodyAsString);

        return sprintf('WP3-v2 %s %s %s', $this->authenticityToken, $timestamp, $digest);
    }
}
