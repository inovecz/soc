<div class="text-neutral-950 dark:text-neutral-50 rounded-lg border border-neutral-700 dark:border-neutral-500">
  <div class="flex justify-between items-center font-medium space-x-2 py-2 px-4 border-b border-neutral-700 dark:border-neutral-500">
    <div>{{ __('Edit IP Whitelist') }}</div>
    <button class="btn btn-icon">
      <span wire:click="$emit('closeModal')" class="mdi mdi-window-close"></span>
    </button>
  </div>

  <div class="px-4 py-2">
    <div class="flex flex-col space-y-2">
      <div class="flex space-x-2 items-top">
        <div class="space-y-2 w-full">
          <input id="ip_start" type="text" class="block w-full bg-neutral-200 dark:bg-neutral-800" wire:model="ip_start" placeholder="{{ __('IP (or IP range start)') }}"/>
          <x-input-error for="ip_start" :messages="$errors->get('ip_start')" class="mt-2"/>
        </div>
        <div class="pt-2">-</div>
        <div class="space-y-2 w-full">
          <input id="ip_end" type="text" class="block w-full bg-neutral-200 dark:bg-neutral-800" wire:model="ip_end" placeholder="{{ __('IP range end') }}"/>
          <x-input-error for="ip_end" :messages="$errors->get('ip_end')" class="mt-2"/>
        </div>
      </div>

      <div class="flex space-x-2 items-center">
        <div class="space-y-2 w-full">
          <input id="description" type="text" class="block w-full bg-neutral-200 dark:bg-neutral-800" wire:model="description" placeholder="{{ __('Description') }}"/>
          <x-input-error for="description" :messages="$errors->get('description')" class="mt-2"/>
        </div>
        <button wire:click="addToWhitelist" class="btn btn-primary">
          <span class="mdi mdi-plus"></span>
        </button>
      </div>
    </div>

    <div class="mt-4">
      <table class="w-full text-xs table-fixed">
        <tbody>
          @foreach($whitelist as $index => $item)
            <tr>
              <td class="w-40">{{ $item['ip_start'] . ($item['ip_end'] ? ' - ' . $item['ip_end'] : '') }}</td>
              <td>{{ $item['description'] }}</td>
              <td class="w-4">
                <button wire:click="deleteFromWhitelist({{$index}})" data-tippy-content="{{ __('Delete whitelisted value') }}" class="btn btn-icon">
                  <span class="mdi mdi-delete text-rose-500"></span>
                </button>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

  {{--  <div class="flex justify-end space-x-2 py-2 px-4 border-t border-neutral-700 dark:border-neutral-500">
      <button wire:click="$emit('closeModal')" wire:loading.attr="disabled" wire:target="addToWhitelist" class="btn btn-link">
        {{ __('Cancel') }}
      </button>
      <button wire:click="save" wire:loading.attr="disabled" wire:target="addToWhitelist" class="btn btn-primary">
        {{ __('Save') }}
      </button>
    </div>--}}
</div>
