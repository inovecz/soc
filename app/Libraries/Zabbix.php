<?php

declare(strict_types=1);

namespace App\Libraries;

use App\Enums\HttpMethod;
use Illuminate\Support\Facades\Http;

class Zabbix extends ServiceAbstract
{
    /**
     * API documentation:
     * https://www.zabbix.com/documentation/current/en/manual/api
     */

    // <editor-fold desc="Region: ABSTRACT METHODS">

    public function getAccessToken(): ?string
    {
        $data = [
            'method' => 'user.login',
            'params' => ['username' => config('services.zabbix.username'), 'password' => config('services.zabbix.password')],
        ];
        $response = $this->call(postData: $data);
        return $response['result'] ?? null;
    }

    public function call(string $route = '', array $getParams = [], HttpMethod $method = HttpMethod::POST, array $postData = []): array
    {
        if (!array_key_exists('jsonrpc', $postData)) {
            $postData['jsonrpc'] = '2.0';
        }
        if (!array_key_exists('id', $postData)) {
            $postData['id'] = 1;
        }

        $http = Http::connectTimeout($this->requestTimeout)
            ->withHeaders(['Content-Type' => 'application/json', 'Accept' => 'application/json']);
        if (isset($this->accessToken)) {
            $http->withToken($this->accessToken);
        }

        $response = $http->post(config('services.zabbix.host'), $postData)->body();
        return $response ? json_decode($response, true) : [];
    }

    // </editor-fold desc="Region: ABSTRACT METHODS">

    public function getApiInfo(): array
    {
        $data = [
            'method' => 'apiinfo.version',
            'params' => [],
        ];
        return $this->call(postData: $data);
    }

    public function getHosts(): array
    {
        $data = [
            'method' => 'host.get',
            'params' => [
                'output' => ['host'],
                'selectInventory' => ['os'],
            ],
        ];
        return $this->call(postData: $data)['result'];
    }

    public function getHostsData(array $hostNames): array
    {
        $data = [
            'method' => 'host.get',
            'params' => [
                'filter' => $hostNames,
            ],
        ];
        return $this->call(postData: $data)['result'];
    }

}
