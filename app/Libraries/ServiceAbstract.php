<?php

namespace App\Libraries;

abstract class ServiceAbstract implements ServiceInterface
{
    protected ?string $accessToken;
    protected int $requestTimeout = 5; // 5 seconds
    protected int $accessTokenTTL = 300; // 5 minutes

    public function __construct()
    {
        $this->accessToken = $this->fetchAccessToken();
    }

    public function fetchAccessToken(): ?string
    {
        $cacheKey = 'accessTokenTTL_'.static::class;
        return \Cache::remember($cacheKey, now()->addSeconds($this->accessTokenTTL), function () {
            return $this->getAccessToken();
        });
    }
}
