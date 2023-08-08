<?php

namespace App\Http\Livewire\Devices;

use Livewire\Component;
use App\Libraries\Zabbix;

class IndexTable extends Component
{
    public array $initialHosts = [];
    public array $hosts = [];
    public string $search = '';
    public string $searchAt = 'all';
    public string $orderBy = 'hostid';
    public bool $sortAsc = false;

    protected $queryString = ['search', 'searchAt', 'orderBy', 'sortAsc'];

    public function mount()
    {
        $this->getHosts();
    }

    public function render()
    {
        return view('livewire.devices.index-table');
    }

    public function getHosts(): void
    {
        $zabbix = new Zabbix();
        $hosts = $zabbix->getHosts();
        foreach ($hosts as $index => $host) {
            $items = collect($host['items']);
            $hosts[$index]['problems'] = $zabbix->getProblemsCount($host['hostid']);
            $hosts[$index]['ip'] = $host['interfaces'][0]['ip'] ?? null;
            $hosts[$index]['port'] = $host['interfaces'][0]['port'] ?? null;
            $hosts[$index]['os'] = $items->firstWhere('key_', 'system.sw.os')['lastvalue'] ?? null;
            $hosts[$index]['arch'] = $items->firstWhere('key_', 'system.sw.arch')['lastvalue'] ?? null;
            $hosts[$index]['cpu'] = $items->firstWhere('key_', 'system.cpu.util')['lastvalue'] ?? null;
            $hosts[$index]['mem'] = $items->filter(fn($item) => str_starts_with($item['key_'], 'vm.memory.util'))->first()['lastvalue'] ?? null;
            unset($hosts[$index]['items']);
        }
        $this->initialHosts = $hosts;
        $this->processSearch();
        $this->orderBy($this->orderBy, true);
    }

    public function orderBy(string $field, bool $keepSort = false): void
    {
        if (!$keepSort) {
            if ($field === $this->orderBy) {
                $this->sortAsc = !$this->sortAsc;
            } else {
                $this->sortAsc = true;
            }
        }
        $this->orderBy = $field;

        $this->hosts = collect($this->hosts)->sortBy($this->orderBy, SORT_NATURAL, !$this->sortAsc)->values()->toArray();
    }

    public function updatedSearch(): void
    {
        $this->processSearch();
    }

    public function updatedSearchAt(): void
    {
        $this->processSearch();
    }

    private function processSearch(): void
    {
        $this->hosts = collect($this->initialHosts)->filter(function ($host) {
            if ($this->searchAt === 'all') {
                return str_contains(strtolower(json_encode($host)), strtolower($this->search));
            }
            return str_contains(strtolower($host[$this->searchAt]), strtolower($this->search));
        })->values()->toArray();
    }

    public function exportAs(string $filetype)
    {
        if ($filetype === 'csv') {
            return $this->exportAsCsv();
        }
        if ($filetype === 'pdf') {
            return $this->exportAsPdf();
        }
    }

    private function exportAsCsv(): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        $filename = 'discovery-items-'.now()->format('Y-m-d-H-i-s').'.csv';
        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ];
        $callback = function () {
            $file = fopen('php://output', 'w');
            fputcsv($file, [
                'Host ID',
                'Host name',
                'IP',
                'Port',
                'OS',
                'Arch',
                'CPU',
                'Mem',
                'Problems - Not classified',
                'Problems - Information',
                'Problems - Warning',
                'Problems - Average',
                'Problems - High',
                'Problems - Disaster',
            ]);
            foreach ($this->hosts as $host) {
                fputcsv($file, [
                    $host['hostid'],
                    $host['host'],
                    $host['ip'],
                    $host['port'],
                    $host['os'],
                    $host['arch'],
                    $host['cpu'],
                    $host['mem'],
                    $host['problems'][0] ?? 0,
                    $host['problems'][1] ?? 0,
                    $host['problems'][2] ?? 0,
                    $host['problems'][3] ?? 0,
                    $host['problems'][4] ?? 0,
                    $host['problems'][5] ?? 0,
                ]);
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }

}
