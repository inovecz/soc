<?php

declare(strict_types=1);

namespace App\Libraries;

use App\Enums\HttpMethod;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class Grafana extends ServiceAbstract
{
    /**
     * API documentation:
     * https://grafana.com/docs/grafana/latest/developers/http_api/
     *
     * Test grafana:
     * http://192.168.200.212:3000 (admin/Heslo123.)
     */

    protected int $accessTokenTTL = 86_400;
    protected int $dashboardsCacheTTL = 300;

    // <editor-fold desc="Region: ABSTRACT METHODS">
    public function getAccessToken(): ?string
    {
        $data = [
            'name' => Str::orderedUuid(),
            'role' => 'Admin',
            'secondsToLive' => $this->accessTokenTTL,
        ];
        $response = Http::withBasicAuth(config('services.grafana.username'), config('services.grafana.password'))
            ->post(config('services.grafana.host').'auth/keys', $data)
            ->body();
        $response = $response ? json_decode($response, true) : [];
        return $response['key'] ?? null;
    }

    public function call(string $route = '', array $getParams = [], HttpMethod $method = HttpMethod::POST, array $postData = []): array
    {
        $http = Http::connectTimeout($this->requestTimeout)
            ->withHeaders(['Content-Type' => 'application/json', 'Accept' => 'application/json']);
        if (isset($this->accessToken)) {
            $http->withToken($this->accessToken);
        }
        $urlParams = http_build_query($getParams);
        $url = config('services.grafana.host').$route.($urlParams ? '?'.$urlParams : '');
        $response = match ($method) {
            HttpMethod::GET => $http->get($url)->body(),
            default => $http->post($url, $postData)->body(),
        };
        return $response ? json_decode($response, true) : [];
    }

    // </editor-fold desc="Region: ABSTRACT METHODS">

    public function getFolders(): array
    {
        return $this->call('folders', method: HttpMethod::GET);
    }

    public function getDashboards(): array
    {
        return \Cache::remember('dashboards', now()->addSeconds($this->dashboardsCacheTTL), function () {
            $folders = $this->getFolders();
            $folderIds = [];
            foreach ($folders as $folder) {
                $folderIds[] = $folder['id'];
            }
            $dashboards = $this->call('search', ['query', 'type' => 'dash-db', 'folderIds' => implode(',', $folderIds)], HttpMethod::GET);
            foreach ($dashboards as $index => $dashboard) {
                if ($dashboard['slug'] === '') {
                    $explodedUri = explode('/', $dashboard['uri']);
                    $dashboards[$index]['slug'] = array_pop($explodedUri);
                }
            }
            return $dashboards;
        });
    }

    public function getDashboard(string $dashboardUid): array
    {
        foreach ($this->getDashboards() as $dashboard) {
            if ($dashboard['uid'] === $dashboardUid) {
                return $dashboard;
            }
        }
        return [];
    }

    public function getPanels(string $dashboardUid): array
    {
        $panels = $this->call('dashboards/uid/'.$dashboardUid, method: HttpMethod::GET);
        return $panels['dashboard']['panels'] ?? [];
    }
}
