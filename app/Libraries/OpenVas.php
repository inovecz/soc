<?php

declare(strict_types=1);

namespace App\Libraries;

use App\Enums\HttpMethod;

class OpenVas extends ServiceAbstract
{
    /**
     * API documentation:
     * ...
     */

    public function getAccessToken(): ?string
    {
        // TODO: Implement getAccessToken() method.
        return null;
    }

    public function call(string $route = '', array $getParams = [], HttpMethod $method = HttpMethod::POST, array $postData = []): array
    {
        // TODO: Implement call() method.
        return [];
    }
}
