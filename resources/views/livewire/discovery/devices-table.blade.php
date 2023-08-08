<div>
  <div class="flex min-w-full justify-between space-x-4 mb-4">
    <div class="">
      <select wire:model="batchId" id="hosts" class="input input-select">
        <option value="0">{{ __('All') }}</option>
        @foreach($batches as $batch)
          <option value="{{ $batch->id }}">#{{ $batch->getId()}} - {{ $batch->getStartedAt()->format('d.m.Y H:i') }}</option>
        @endforeach
      </select>
    </div>
    <div class="flex-1">
      <input wire:model="search" type="text" placeholder="{{ __('Search') }}" class="input input-search input-sm">
    </div>
    <div>
      <div class="inline-flex rounded-md shadow-sm" role="group">
        <button wire:click="exportAs('csv')" type="button" class="btn btn-secondary rounded-r-none border">
          <i class="fa-solid fa-file-csv"></i>
        </button>
        <button wire:click="exportAs('pdf')" type="button" class="btn btn-secondary rounded-l-none border-y border-r">
          <i class="fa-solid fa-file-pdf"></i>
        </button>
      </div>
    </div>
  </div>

  <x-table label="Discovered devices">
    @slot('head')
      <th class="w-24">{{ __('Host ID') }}</th>
      <th class="w-24">{{ __('Batch ID') }}</th>
      <th class="w-24">{{ __('Rule ID') }}</th>
      <th class="w-32">{{ __('Status') }}</th>
      <th class="w-20">{{ __('Last up') }}</th>
      <th class="w-20">{{ __('Last down') }}</th>
      <th class="w-20">{{ __('Last discover') }}</th>
      <th class="w-20">{{ __('First discover') }}</th>
      <th class="w-20">{{ __('S:Value') }}</th>
      <th class="w-20">{{ __('S:Status') }}</th>
      <th class="w-20">{{ __('S:Port') }}</th>
      <th class="w-24">{{ __('S:Last up') }}</th>
      <th class="w-24">{{ __('S:Last down') }}</th>
      <th class="w-20">{{ __('S:Check ID') }}</th>
      <th class="w-28">{{ __('S:IP') }}</th>
      <th class="w-48">{{ __('S:DNS') }}</th>
    @endslot

    @slot('bodies')
      @php
        /** @var \App\Models\DiscoveryItem $device */
      @endphp
      @foreach($devices as $device)
        <tbody class="
              @if(Carbon\Carbon::parse($device->first_created_at)->eq($device->getCreatedAt())) bg-green-200 dark:bg-green-800 even:bg-green-300 dark:even:bg-green-700
              @elseif($batchId === 0 && Carbon\Carbon::parse($device->last_created_at)->gt($device->getCreatedAt())) bg-rose-200 dark:bg-rose-800 even:bg-rose-300 dark:even:bg-rose-700
              @else even:bg-zinc-300 dark:even:bg-zinc-700
              @endif
              ">
          <tr class="h-10">
            <td>{{ $device->getHostId() }}</td>
            <td>{{ $device->getDiscoveryBatchId() }}</td>
            <td>{{ $device->getRuleId() }}</td>
            <td>
              <x-led type="{{ $device->getStatus() ? 'success' : 'danger' }}"></x-led>
            </td>
            <td>
              @if($device->getLastUp())
                {{ $device->getLastUp()->format('d.m.Y H:i:s') }}
              @else
                N/A
              @endif</td>
            <td>
              @if($device->getLastDown())
                {{ $device->getLastDown()->format('d.m.Y H:i:s') }}
              @else
                N/A
              @endif
            </td>
            <td>
              {{ $device->getCreatedAt()->format('d.m.Y H:i:s') }}
            </td>
            <td>
              {{ Carbon\Carbon::parse($device->first_created_at)->format('d.m.Y H:i:s') }}
            </td>
            <td colspan="8"></td>
          </tr>
          @foreach($device->getServices() as $service)
            <tr class="h-8">
              <td class="text-xxs pl-8" colspan="7"></td>
              <td class="text-xxs">┗ Service #{{ $service['service_id'] }}</td>
              <td class="text-xxs">{{ $service['value'] ?? 'N/A' }}</td>
              <td class="text-xxs">
                <x-led type="{{ $service['status'] ? 'success' : 'danger' }}"></x-led>
              </td>
              <td class="text-xxs">{{ $service['port'] ?? 'N/A'}}</td>
              <td class="text-xxs">
                @if($service['last_up'])
                  {{ Carbon\Carbon::parse($service['last_up'])->format('d.m.Y H:i:s') }}
                @else
                  N/A
                @endif
              </td>
              <td class="text-xxs">
                @if($service['last_down'])
                  {{ Carbon\Carbon::parse($service['last_down'])->format('d.m.Y H:i:s') }}
                @else
                  N/A
                @endif
              </td>
              <td class="text-xxs">{{ $service['check_id'] }}</td>
              <td class="text-xxs">{{ $service['ip'] }}</td>
              <td class="text-xxs">{{ $service['dns'] }}</td>
            </tr>
          @endforeach
        </tbody>
      @endforeach
    @endslot
  </x-table>
  {{ $devices->links() }}
</div>
