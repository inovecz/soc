<?php

namespace App\Libraries;

use App\Enums\HttpMethod;

interface ServiceInterface
{
    public function getAccessToken(): ?string;

    public function call(string $route = '', array $getParams = [], HttpMethod $method = HttpMethod::POST, array $postData = []): array;
}
