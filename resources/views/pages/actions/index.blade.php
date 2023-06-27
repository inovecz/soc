<x-app-layout>
  <x-slot name="header">
    {{ __('Actions') }}
  </x-slot>

  <h2>{{ __('Scripts') }}</h2>
  <div class="max-w-7xl flex flex-col space-y-4 mt-4">
    @foreach ($scripts as $script)
      <div class="px-4 py-2 bg-zinc-200 dark:bg-zinc-800 sm:rounded-lg">
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
          {{ $script['name'] }}
        </h2>
        <table>
          <tr>
            <td class="pr-2">Command:</td>
            <td>
              <p class="font-mono flex-1 bg-gray-950 px-2 py-1 text-sm text-gray-600 dark:text-gray-400">
                {{ $script['command'] }}
              </p>
            </td>
          </tr>
          <tr>
            <td class="pr-2">Hosts:</td>
            <td>
              @foreach($script['hosts'] as $host)
                <span class="">
                  {{ $host['name'].(!$loop->last ? ', ' : '') }}
                </span>
              @endforeach
            </td>
          </tr>
        </table>

        <div class="flex items-center justify-end mt-2">
          <button onclick="Livewire.emit('openModal', 'modals.execute-action', {{ json_encode(['script' => $script]) }})" class=" btn btn-sm btn-primary
          ">{{ __('Execute') }}</button>
        </div>
      </div>
    @endforeach
  </div>

</x-app-layout>
