<x-app-layout>
  <x-slot name="header">
    {{ __('Devices') }}
  </x-slot>
  <x-table label="Device list">
    @slot('head')
      <th scope="col">
        {{ __('Host ID') }}
      </th>
      <th scope="col">
        {{ __('Host name') }}
      </th>
      <th scope="col">
        {{ __('Problems') }}
      </th>
      <th scope="col" class="text-right">
        {{ __('Action') }}
      </th>
    @endslot
    @slot('body')
      @foreach($hosts as $host)
        <tr>
          <td>
            <div class="flex gap-2 items-center">
              @if($host['active_available'] === '1')
                <div class="w-4 h-4 rounded-full bg-green-500"></div>
              @else
                <div class="w-4 h-4 rounded-full bg-red-500"></div>
              @endif
              <div>{{ $host['hostid'] }}</div>
            </div>
          </td>
          <td class="whitespace-nowrap">
            {{ $host['host'] }}
          </td>
          <td class="whitespace-nowrap">
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
</x-app-layout>