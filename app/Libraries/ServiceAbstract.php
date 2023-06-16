<?php

namespace App\Libraries;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;

abstract class ServiceAbstract implements ServiceInterface
{
    protected ?string $accessToken;
    protected int $requestTimeout = 5; // 5 seconds
    protected int $accessTokenTTL = 300; // 5 minutes
    protected string $serviceName;
    protected string $host;

    public function __construct()
    {
        $this->serviceName = Str::of(static::class)->afterLast('\\');
        $this->host = config('services.'.Str::of($this->serviceName)->snake().'.host');
        if (!$this->checkServerStatus()) {
            throw new ServiceUnavailableHttpException('Service '.$this->serviceName.' is not available.'); // abort(503, 'Service '.$this->serviceName.' is not available.');
        }
        $this->accessToken = $this->fetchAccessToken();
    }

    public function fetchAccessToken(): ?string
    {
        $cacheKey = 'accessTokenTTL_'.static::class;
        return \Cache::remember($cacheKey, now()->addSeconds($this->accessTokenTTL), function () {
            return $this->getAccessToken();
        });
    }

    public function checkServerStatus(): bool
    {
        try {
            Http::connectTimeout(1)->head($this->host);
            return true;
        } catch (Exception $e) {
            return false; // abort(503, 'Service '.$this->serviceName.' is not available.');
        }
    }

    public function getHostUrl(): string
    {
        return $this->host;
    }
}
