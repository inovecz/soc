<?php

declare(strict_types=1);

namespace App\Libraries;

use App\Enums\HttpMethod;
use Illuminate\Support\Facades\Http;

class Graylog extends ServiceAbstract
{
    /**
     * API documentation:
     * https://go2docs.graylog.org/5-0/setting_up_graylog/rest_api.html
     * http://192.168.200.253/api/api-browser/global/index.html
     */

    // <editor-fold desc="Region: ABSTRACT METHODS">
    public function getAccessToken(): ?string
    {
        $data = [
            'username' => config('services.graylog.username'),
            'password' => config('services.graylog.password'),
        ];
        $response = $this->call('system/sessions', postData: $data);
        return $response['session_id'] ?? null;
    }

    public function call(string $route = '', array $getParams = [], HttpMethod $method = HttpMethod::POST, array $postData = [], string $accept = 'application/json'): array
    {
        $http = Http::connectTimeout($this->requestTimeout)
            ->withHeaders(['X-Requested-By' => 'cli', 'Content-Type' => 'application/json', 'Accept' => $accept]);
        if (isset($this->accessToken)) {
            $http->withBasicAuth($this->accessToken, 'session');
        }
        $urlParams = http_build_query($getParams);
        $url = config('services.graylog.host').$route.($urlParams ? '?'.$urlParams : '');
        $http = match ($method) {
            HttpMethod::GET => $http->get($url),
            default => $http->post($url, $postData),
        };
        $response = $http->body();
        if ($accept === 'text/csv') {
            try {
                return csv_to_assoc($response, ',');
            } catch (\Throwable $th) {
                return [];
            }
        }
        $response = $response ? json_decode($response, true) : [];
        if (array_key_exists('type', $response) && $response['type'] === 'ApiError') {
            $response['soc_log'] = [
                'url' => $url,
                'method' => $method,
                'postData' => $postData,
                'getParams' => $getParams,
                'headers' => $http->headers(),
            ];
        }
        return $response;
    }

    // </editor-fold desc="Region: ABSTRACT METHODS">

    public function getClusters(): array
    {
        return $this->call('cluster', ['pretty' => 'true'], HttpMethod::GET);
    }

    public function getMessages(): array
    {
        //return $this->call('/search/universal/relative', ['query' => '*', 'range' => 300, 'limit' => 100], HttpMethod::GET);
        $postData = [
            'timerange' => [
                'type' => 'relative',
                'range' => 2,
            ],
        ];

        return $this->call('views/search/messages', [], HttpMethod::POST, $postData, 'text/csv');
    }
}
