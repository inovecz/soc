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
     *
     * Test Zabbix:
     * http://192.168.200.73/ (Admin/Heslo123.)
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

    public function call(string $route = '', array $getParams = [], HttpMethod $method = HttpMethod::POST, array $postData = [], bool $noAuthorization = false): array
    {
        if (!array_key_exists('jsonrpc', $postData)) {
            $postData['jsonrpc'] = '2.0';
        }
        if (!array_key_exists('id', $postData)) {
            $postData['id'] = 1;
        }

        $http = Http::connectTimeout($this->requestTimeout)
            ->withHeaders(['Content-Type' => 'application/json', 'Accept' => 'application/json']);
        if (isset($this->accessToken) && !$noAuthorization) {
            $http->withToken($this->accessToken);
        }

        $response = $http->post($this->getHostUrl().'/api_jsonrpc.php', $postData)->body();
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

    // <editor-fold desc="Region: HOSTS">
    public function getHosts(): array
    {
        $data = [
            'method' => 'host.get',
            'params' => [
                'output' => ['hostid', 'host', 'status', 'name', 'active_available'],
                'selectInterfaces' => 'extend',
                'selectItems' => ['name', 'description', 'key_', 'prevvalue', 'lastvalue', 'lastclock', 'value_type', 'status'],
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

    public function getHost(string $hostId)
    {
        $data = [
            'method' => 'host.get',
            'params' => [
                'output' => 'extend',
                'selectInventory' => ['os', 'hardware'],
                'selectInterfaces' => 'extend',
                'hostids' => [$hostId],
            ],
        ];
        return $this->call(postData: $data)['result'];
    }

    public function discoverHosts()
    {
        $data = [
            'method' => 'dhost.get',
            'params' => [
                'output' => 'extend',
                'selectDServices' => 'extend',
            ],
        ];
        return $this->call(postData: $data)['result'];
    }
    // </editor-fold desc="Region: HOSTS">

    // <editor-fold desc="Region: ITEMS">
    public function getItems(array|string|int $hostIds): array
    {
        $hostIds = is_array($hostIds) ? $hostIds : [$hostIds];
        $data = [
            'method' => 'item.get',
            'params' => [
                'output' => 'extend',
                'hostids' => $hostIds,
                'with_triggers' => true,
            ],
        ];
        return $this->call(postData: $data)['result'];
    }
    // </editor-fold desc="Region: ITEMS">

    // <editor-fold desc="Region: PROBLEMS">
    public function getProblemsCount(string $hostId): array
    {
        $problems = collect($this->getProblems($hostId));
        return $problems->groupBy('severity')
            ->map(fn($items) => $items->count())
            ->toArray();
    }

    public function getProblems(string $hostId)
    {
        $data = [
            'method' => 'problem.get',
            'params' => [
                'output' => 'extend',
                'selectTags' => 'extend',
                'hostids' => [$hostId],
            ],
        ];
        return $this->call(postData: $data)['result'];
    }
    // </editor-fold desc="Region: PROBLEMS">

    // <editor-fold desc="Region: USERS">
    public function loginUser(string $username, string $password): array
    {
        $data = [
            'method' => 'user.login',
            'params' => ['username' => $username, 'password' => $password, 'userData' => true],
        ];
        return $this->call(postData: $data, noAuthorization: true);
    }

    public function getUsers(): array
    {
        $data = [
            'method' => 'user.get',
            'params' => [
                'output' => 'extend',
            ],
        ];
        return $this->call(postData: $data)['result'];
    }

    public function getRoles()
    {
        $data = [
            'method' => 'role.get',
            'params' => [
                'output' => 'extend',
            ],
        ];
        return $this->call(postData: $data)['result'];
    }
    // </editor-fold desc="Region: PEOPLE">

    // <editor-fold desc="Region: ALERTS">
    public function getAlerts()
    {
        $data = [
            'method' => 'alert.get',
            'params' => [
                'output' => 'extend',
            ],
        ];
        return $this->call(postData: $data)['result'];
    }
    // </editor-fold desc="Region: ALERTS">

    // <editor-fold desc="Region: SETTINGS">
    public function getSettings()
    {
        $data = [
            'method' => 'settings.get',
            'params' => [
                'output' => 'extend',
            ],
        ];
        return $this->call(postData: $data)['result'];
    }
    // </editor-fold desc="Region: SETTINGS">

    // <editor-fold desc="Region: ACTIONS">
    public function getActions()
    {
        $data = [
            'method' => 'action.get',
            'params' => [
                'output' => 'extend',
            ],
        ];
        return $this->call(postData: $data)['result'];
    }
    // </editor-fold desc="Region: ACTIONS">

    // <editor-fold desc="Region: SCRIPTS">
    public function getScripts()
    {
        $data = [
            'method' => 'script.get',
            'params' => [
                'output' => 'extend',
                'selectHosts' => 'extend',
            ],
        ];
        return $this->call(postData: $data)['result'];
    }

    public function executeScript(int $scriptId, int $hostId): array
    {
        $data = [
            'method' => 'script.execute',
            'params' => [
                'scriptid' => $scriptId,
                'hostid' => $hostId,
            ],
            'id' => '1',
        ];
        return $this->call(postData: $data);
    }
    // </editor-fold desc="Region: SCRIPTS">
}
