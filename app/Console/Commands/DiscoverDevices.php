<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Libraries\Zabbix;
use App\Models\DiscoveryBatch;
use Illuminate\Console\Command;

class DiscoverDevices extends Command
{
    protected $signature = 'app:discover-devices';
    protected $description = 'Discover devices from Zabbix';

    protected Zabbix $zabbix;

    public function __construct()
    {
        parent::__construct();
        $this->zabbix = new Zabbix();
    }

    public function handle(): int
    {
        $discoveryBatch = DiscoveryBatch::create([
            'started_at' => now(),
        ]);

        $hosts = $this->zabbix->discoverHosts();

        foreach ($hosts as $host) {
            $services = [];
            if ($dServices = $host['dservices'] ?? null) {
                foreach ($dServices as $dService) {
                    $services[] = [
                        'service_id' => (int) $dService['dserviceid'],
                        'value' => $dService['value'] !== '' ? $dService['value'] : null,
                        'port' => $dService['port'] !== '0' ? $dService['port'] : null,
                        'status' => $dService['status'] === '0', // 0 = UP, 1 = DOWN
                        'last_up' => $dService['lastup'] !== '0' ? Carbon::createFromTimestamp($dService['lastup'])->toDateTimeString() : null,
                        'last_down' => $dService['lastdown'] !== '0' ? Carbon::createFromTimestamp($dService['lastdown'])->toDateTimeString() : null,
                        'check_id' => (int ) $dService['dcheckid'],
                        'ip' => $dService['ip'] !== '' ? $dService['ip'] : null,
                        'dns' => $dService['dns'] !== '' ? $dService['dns'] : null,
                    ];
                }
            }
            $discoveryBatch->items()->create([
                'host_id' => $host['dhostid'],
                'rule_id' => $host['druleid'],
                'status' => $host['status'] === '0', // 0 = UP, 1 = DOWN
                'last_up' => $host['lastup'] !== '0' ? Carbon::createFromTimestamp($host['lastup']) : null,
                'last_down' => $host['lastdown'] !== '0' ? Carbon::createFromTimestamp($host['lastdown']) : null,
                'ip' => $host['dservices'] ?? null,
                'services' => $services,
            ]);
        }

        $discoveryBatch->update([
            'finished_at' => now(),
        ]);

        $this->removeOldBatches();
        return 0;
    }

    private function removeOldBatches(): void
    {
        DiscoveryBatch::where('created_at', '<', now()->subMonths(3))->delete();
    }
}
