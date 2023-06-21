<x-app-layout>
  <x-slot name="header">
    {{ __('Host detail') }}
  </x-slot>

  <div class="mb-6">
    <div class="px-4 sm:px-0">
      <div class="flex items-center justify-between">
        <h3 class="text-base font-semibold leading-7">{{ $host['host'] }} <span class="text-neutral-400 dark:text-neutral-600">(#{{ $host['hostid'] }})</span></h3>
        @if($host['interfaces'])
          <p class="text-sm leading-6 text-neutral-400 dark:text-neutral-600">{{ $host['interfaces'][0]['ip'] . ($host['interfaces'][0]['port'] ? ':' .$host['interfaces'][0]['port'] : '') }}</p>
        @else
          <p class="text-sm leading-6 text-neutral-400 dark:text-neutral-600">{{ __('Unknown interface') }}</p>
        @endif
      </div>
      <p class="mt-1 text-sm leading-6 text-neutral-400 dark:text-neutral-600">{{ $host['inventory']['os'] ?? __('Unknown OS') }}</p>
    </div>
  </div>


  <x-table label="Problems">
    @slot('head')
      <th scope="col" class="px-2 py-3">
        {{ __('Time') }}
      </th>
      <th scope="col" class="px-2 py-3">
        {{ __('Severity') }}
      </th>
      <th scope="col" class="px-2 py-3">
        {{ __('Problem') }}
      </th>
      <th scope="col" class="px-2 py-3">
        {{ __('Tags') }}
      </th>
    @endslot
    @slot('body')
      @forelse($problems as $problem)
        <tr>
          <td>
            {{ \Carbon\Carbon::createFromTimestamp($problem['clock'])->format('d.m.Y H:i:s') }}
          </td>
          <td class="{{ \App\Enums\ProblemSeverity::tryFrom($problem['severity'])->textColor() }}">
            {{ \App\Enums\ProblemSeverity::tryFrom($problem['severity'])->toString() }}
          </td>
          <td>
            {{ $problem['name'] }}
          </td>
          <td class="">
            @foreach($problem['tags'] as $tag)
              <span class="px-1.5 py-0.5 my-0.5 inline-block whitespace-nowrap rounded bg-zinc-300 dark:bg-zinc-700 font-medium mr-1">{{ $tag['value'] }}</span>
            @endforeach
          </td>
        </tr>
      @empty
        <tr>
          <td colspan="4" class="text-xs">{{ __('No records found') }}</td>
        </tr>
      @endforelse
    @endslot
  </x-table>
</x-app-layout>
