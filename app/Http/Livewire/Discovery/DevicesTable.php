<?php

namespace App\Http\Livewire\Discovery;

use DB;
use App;
use Carbon\Carbon;
use Livewire\Component;
use App\Models\DiscoveryItem;
use Illuminate\Support\Collection;

class DevicesTable extends Component
{
    public string $search = '';

    public function render()
    {
        $devices = $this->fetchDevices();
        return view('livewire.discovery.devices-table', compact('devices'));
    }

    public function exportAs(string $filetype)
    {
        $devices = $this->fetchDevices();
        if ($filetype === 'csv') {
            return $this->exportAsCsv($devices);
        }
        if ($filetype === 'pdf') {
            return $this->exportAsPdf($devices);
        }
    }

    private function exportAsCsv(Collection $devices): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        $filename = 'discovery-items-'.now()->format('Y-m-d-H-i-s').'.csv';
        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ];
        $callback = function () use ($devices) {
            $file = fopen('php://output', 'w');
            fputcsv($file, [
                'Type',
                'Host ID',
                'Rule ID',
                'Status',
                'Last Up',
                'Last Down',
                'First discover',
                'Last discover',
                'Service ID',
                'Service value',
                'Service status',
                'Service port',
                'Service last up',
                'Service last down',
                'Service check ID',
                'Service IP',
                'Service DNS',
            ]);
            /** @var DiscoveryItem $device */
            foreach ($devices as $device) {
                fputcsv($file, [
                    'host',
                    $device->getHostId(),
                    $device->getRuleId(),
                    $device->getStatus(),
                    $device->getLastUp()?->toDateTimeString(),
                    $device->getLastDown()?->toDateTimeString(),
                    Carbon::parse($device->first_created_at)->toDateTimeString(),
                    $device->getCreatedAt()->toDateTimeString(),
                    '', '', '', '', '', '', '', '', '',
                ]);
                foreach ($device->getServices() as $service) {
                    fputcsv($file, [
                        'service',
                        '', '', '', '', '', '', '',
                        $service['service_id'],
                        $service['value'],
                        $service['status'],
                        $service['port'],
                        $service['last_up'],
                        $service['last_down'],
                        $service['check_id'],
                        $service['ip'],
                        $service['dns'],
                    ]);
                }
            }
            fclose($file);
        };
        return response()->stream($callback, 200, $headers);
    }

    private function fetchDevices(): Collection
    {
        return DiscoveryItem::query()
            ->select('*', 't2.first_created_at')
            ->joinSub(function ($query) {
                $query->select('host_id', DB::raw('MAX(created_at) as latest_created_at'), DB::raw('MIN(created_at) as first_created_at'))
                    ->from('discovery_items')
                    ->groupBy('host_id');
            }, 't2', function ($join) {
                $join->on('discovery_items.host_id', '=', 't2.host_id')
                    ->on('discovery_items.created_at', '=', 't2.latest_created_at');
            })->when($this->search !== '', function ($query) {
                $query->where('discovery_items.host_id', 'like', "%{$this->search}%")
                    ->orWhere('discovery_items.rule_id', 'like', "%{$this->search}%")
                    ->orWhere('discovery_items.status', 'like', "%{$this->search}%")
                    ->orWhere('discovery_items.last_up', 'like', "%{$this->search}%")
                    ->orWhere('discovery_items.last_down', 'like', "%{$this->search}%")
                    ->orWhere('discovery_items.services', 'like', "%{$this->search}%");
            })
            ->get();
    }

    private function exportAsPdf(Collection $devices)
    {
        $filename = 'discovery-items-'.now()->format('Y-m-d-H-i-s').'.pdf';
        $view = \View::make('pdfTemplates.discovery-report', ['devices' => $devices, 'search' => $this->search])->render();

        return response()->streamDownload(function () use ($view) {
            $pdf = App::make('dompdf.wrapper');
            $pdf->setPaper('A4', 'portrait');
            $pdf->loadHTML($view);
            echo $pdf->stream();
        }, $filename);
    }
}
