<?php

declare(strict_types=1);

namespace Locastic\MonriPayments\Api;

use GuzzleHttp\Client;
use Locastic\MonriPayments\Model\Payment;
use Psr\Http\Message\ResponseInterface;

class PaymentApi
{
    private bool $sandbox;

    private string $merchantKey;

    private string $authenticityToken;

    private Client $client;

    public function __construct(bool $sandbox, string $merchantKey, string $authenticityToken)
    {
        $this->sandbox = $sandbox;
        $this->merchantKey = $merchantKey;
        $this->authenticityToken = $authenticityToken;
        $this->client = new Client();
    }

    public function authorize(Payment $payment): ResponseInterface
    {
        $data = $payment->getAsArray();
        $data['transaction_type'] = 'authorize';
        $data['scenario'] = 'charge';

        if (empty($data['supported_payment_methods'])) {
            unset($data['supported_payment_methods']);
        }

        return $this->doCall('POST', $data);
    }

    private function doCall(string $method, $data): ResponseInterface
    {
        $uri = $this->getApiEndpoint().'/v2/payment/new';
        $dataAsString = json_encode($data);

        $response = $this->client->request(
            $method,
            $uri,
            [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => $this->getAuthorization($dataAsString),
                ],
                'body' => $dataAsString,
            ]
        );

        return $response;
    }

    private function getApiEndpoint(): string
    {
        if ($this->sandbox) {
            return 'https://ipgtest.monri.com';
        }

        return 'https://ipg.monri.com';
    }

    private function getAuthorization(string $dataAsString): string
    {
        $timestamp = time();
        $digest = hash('sha512', $this->merchantKey.$timestamp.$this->authenticityToken.$dataAsString);

        return sprintf('WP3-v2 %s %s %s', $this->authenticityToken, $timestamp, $digest);
    }

    public function purchase(Payment $payment): ResponseInterface
    {
        $data = $payment->getAsArray();
        $data['transaction_type'] = 'purchase';
        $data['scenario'] = 'charge';

        if (empty($data['supported_payment_methods'])) {
            unset($data['supported_payment_methods']);
        }

        return $this->doCall('POST', $data);
    }

    public function addPaymentMethod(Payment $payment): ResponseInterface
    {
        $data = $payment->getAsArray();
        $data['transaction_type'] = 'purchase';
        $data['scenario'] = 'add_payment_method';

        if (empty($data['supported_payment_methods'])) {
            unset($data['supported_payment_methods']);
        }

        return $this->doCall('POST', $data);
    }
}
