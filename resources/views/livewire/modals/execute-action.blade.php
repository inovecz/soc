<div class="text-neutral-950 dark:text-neutral-50 rounded-lg border border-neutral-700 dark:border-neutral-500">
  <div class="flex justify-between items-center font-medium space-x-2 py-2 px-4 border-b border-neutral-700 dark:border-neutral-500">
    <div>{{ __('Execute action') . ' "' . $script['name'] . '"' }}</div>
    <button class="btn btn-icon">
      <span wire:click="$emit('closeModal')" class="mdi mdi-window-close"></span>
    </button>
  </div>

  <div class="px-4 py-4">
    <label for="hosts" class="block mb-2 text-sm font-medium">{{ __('Select a host') }}</label>
    <select wire:model="hostId" id="hosts" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
      <option selected value="0">{{ __('Select a host') }}</option>
      @foreach($script['hosts'] as $host)
        <option value="{{ $host['hostid'] }}">{{ $host['name'] }}</option>
      @endforeach
    </select>

    @if($scriptResult)
      <div class="mt-4 flex flex-col space-y-2">
        <div class="text-sm font-medium">{{ isset($scriptResult['error']) ? __('Error') : __('Result') }}:</div>
        <div class="w-full text-xs font-mono {{ isset($scriptResult['error']) ? 'bg-red-950' :'bg-gray-950' }} px-2 py-1 dark:text-gray-400">
          @if(isset($scriptResult['error']))
            {{ $scriptResult['error']['message'] }}<br>{{ $scriptResult['error']['data'] }}
          @else
            {{ $scriptResult['result']['value'] }}
          @endif
        </div>
      </div>
    @endif
  </div>

  <div class="flex justify-end space-x-2 py-2 px-4 border-t border-neutral-700 dark:border-neutral-500">
    <button wire:click="$emit('closeModal')" class="btn btn-link">
      {{ __('Cancel') }}
    </button>
    <button wire:click="execute" wire:loading.remove {{ $hostId === 0 ? 'disabled' : '' }} wire:target="execute" class="btn btn-primary">
      {{ __('Execute') }}
    </button>
    <button wire:loading disabled wire:target="execute" class="btn btn-primary">
      <i class="fa-solid fa-circle-notch fa-spin"></i>
    </button>
  </div>
</div>
