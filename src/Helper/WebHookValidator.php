<?php

declare(strict_types=1);

namespace Locastic\MonriPayments\Helper;

class WebHookValidator
{
    private string $merchantKey;

    public function __construct(string $merchantKey)
    {
        $this->merchantKey = $merchantKey;
    }

    public function validate(string $authorization, array $data): bool
    {
        $digest = hash('sha512', $this->merchantKey.json_encode($data));
        $authorization = str_replace('WP3-callback ', '', $authorization);

        if ($digest === $authorization) {
            return true;
        }

        return false;
    }
}
