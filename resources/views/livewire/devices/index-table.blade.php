<div>
  <div class="flex min-w-full justify-between space-x-4 mb-4">
    <div class="">
      <select wire:model="searchAt" id="hosts" class="input input-select">
        <option value="all">{{ __('All') }}</option>
        <option value="hostid">{{ __('Host ID') }}</option>
        <option value="name">{{ __('Host name') }}</option>
        <option value="ip">{{ __('IP') }}</option>
        <option value="port">{{ __('Port') }}</option>
        <option value="os">{{ __('OS') }}</option>
        <option value="arch">{{ __('Arch') }}</option>
        <option value="cpu">{{ __('CPU') }}</option>
        <option value="mem">{{ __('Mem') }}</option>
      </select>
    </div>
    <div class="flex-1">
      <input wire:model.debounce.250ms="search" type="text" placeholder="{{ __('Search') }}" class="input input-search input-sm">
    </div>
    <div>
      <div class="inline-flex rounded-md shadow-sm" role="group">
        <button wire:click="exportAs('csv')" type="button" class="btn btn-secondary border">
          <i class="fa-solid fa-file-csv"></i>
        </button>
        {{--<button wire:click="exportAs('pdf')" type="button" class="btn btn-secondary rounded-l-none border-y border-r">
          <i class="fa-solid fa-file-pdf"></i>
        </button>--}}
      </div>
    </div>
    <div>
      <button wire:loading.remove wire:target="getHosts" wire:click="getHosts()" type="button" class="btn btn-primary border">
        <i class="fa-solid fa-rotate"></i>
      </button>
      <button wire:loading wire:target="getHosts" type="button" class="btn btn-primary border" disabled>
        <i class="fa-solid fa-rotate fa-spin"></i>
      </button>
    </div>
  </div>
  <x-table label="Device list">
    @slot('head')
      <th class="w-24 cursor-pointer" wire:click="orderBy('hostid')">{{ __('Host ID') }}
        <x-sort-icon field="hostid" :orderBy="$orderBy" :sortAsc="$sortAsc"/>
      </th>
      <th class="w-32 cursor-pointer" wire:click="orderBy('name')">{{ __('Host name') }}
        <x-sort-icon field="name" :orderBy="$orderBy" :sortAsc="$sortAsc"/>
      </th>
      <th class="w-28 cursor-pointer" wire:click="orderBy('ip')">{{ __('IP') }}
        <x-sort-icon field="ip" :orderBy="$orderBy" :sortAsc="$sortAsc"/>
      </th>
      <th class="w-24 cursor-pointer" wire:click="orderBy('port')">{{ __('Port') }}
        <x-sort-icon field="port" :orderBy="$orderBy" :sortAsc="$sortAsc"/>
      </th>
      <th class="w-64 cursor-pointer" wire:click="orderBy('os')">{{ __('OS') }}
        <x-sort-icon field="os" :orderBy="$orderBy" :sortAsc="$sortAsc"/>
      </th>
      <th class="w-20 cursor-pointer" wire:click="orderBy('arch')">{{ __('Arch') }}
        <x-sort-icon field="arch" :orderBy="$orderBy" :sortAsc="$sortAsc"/>
      </th>
      <th class="w-20 cursor-pointer" wire:click="orderBy('cpu')">{{ __('CPU') }}
        <x-sort-icon field="cpu" :orderBy="$orderBy" :sortAsc="$sortAsc"/>
      </th>
      <th class="w-20 cursor-pointer" wire:click="orderBy('mem')">{{ __('Mem') }}
        <x-sort-icon field="mem" :orderBy="$orderBy" :sortAsc="$sortAsc"/>
      </th>
      <th class="w-24">{{ __('Problems') }}</th>
      <th class="w-32 text-right">{{ __('Action') }}</th>
    @endslot
    @slot('body')
      @foreach($hosts as $host)
        <tr>
          <td>
            <div class="flex gap-2 items-center">
              <x-led type="{{ $host['active_available'] === '1' ? 'success' : 'danger' }}"></x-led>
              <div>{{ $host['hostid'] }}</div>
            </div>
          </td>
          <td class="whitespace-nowrap">
            {{ $host['host'] }}
          </td>
          <td>{{ $host['ip'] ?? '-' }}</td>
          <td>{{ $host['port'] ?? '-' }}</td>
          <td>{{ $host['os'] ?? '-' }}</td>
          <td>{{ $host['arch'] ?? '-' }}</td>
          <td>{{ $host['cpu'] ? round($host['cpu'], 2) . ' %': '-' }}</td>
          <td>{{ $host['mem'] ? round($host['mem'], 2) . ' %': '-' }}</td>
          <td class="whitespace-nowrap overflow-visible">
            @foreach($host['problems'] as $severity => $count)
              <span class="px-1.5 py-0.5 my-0.5 inline-block rounded {{ \App\Enums\ProblemSeverity::tryFrom($severity)->bgColor() }} font-medium mr-1"
                    data-tippy-content="{{ \App\Enums\ProblemSeverity::tryFrom($severity)->toString() }}">
                {{ $count }}
              </span>
            @endforeach
          </td>
          <td class="text-right">
            <a class="btn btn-icon" href="{{ route('hosts.detail', ['hostId' => $host['hostid']]) }}">
              <span class="mdi mdi-eye"></span>
            </a>
          </td>
        </tr>
      @endforeach
    @endslot
  </x-table>
</div>
