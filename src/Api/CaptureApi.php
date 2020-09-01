<?php

declare(strict_types=1);

namespace Locastic\MonriPayments\Api;

use GuzzleHttp\Client;
use Locastic\MonriPayments\Model\Payment;
use Psr\Http\Message\ResponseInterface;

class CaptureApi
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

    public function capture(Payment $payment): ResponseInterface
    {
        return $this->doCall('POST', $payment);
    }

    private function doCall(string $method, Payment $payment): ResponseInterface
    {
        $uri = $this->getApiEndpoint().sprintf('/transactions/%s/capture.xml,', $payment->getOrderNumber());

        return $this->client->request(
            $method,
            $uri,
            [
                'headers' => [
                    'Content-Type' => 'application/xml',
                ],
                'body' => $this->getXmlData($payment),
            ]
        );
    }

    private function getApiEndpoint(): string
    {
        if ($this->sandbox) {
            return 'https://ipgtest.monri.com';
        }

        return 'https://ipg.monri.com';
    }

    private function getXmlData(Payment $payment): string
    {
        return sprintf(
            '<?xml version="1.0" encoding="UTF-8"?>
            <transaction>
              <amount>%s</amount>
              <currency>%s</currency>
              <digest>%s</digest>
              <authenticity-token>%s</authenticity-token>
              <order-number>%s</order-number>
            </transaction>',
            $payment->getAmount(),
            $payment->getCurrency(),
            $this->getDigest($payment),
            $this->authenticityToken,
            $payment->getOrderNumber()
        );
    }

    private function getDigest(Payment $payment): string
    {
        return hash(
            'sha1',
            $this->merchantKey.$payment->getOrderNumber().$payment->getAmount().$payment->getCurrency()
        );
    }
}
