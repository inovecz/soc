@props(['title'])

<div id="modal" class="text-neutral-950 dark:text-neutral-50 rounded-lg border border-neutral-400 dark:border-neutral-500">
  <div class="flex justify-between items-center font-medium space-x-2 py-2 px-4 border-b border-neutral-400 dark:border-neutral-500">
    <div>{{ $title }}</div>
    <button class="btn btn-icon">
      <span wire:click="$emit('closeModal')" class="mdi mdi-window-close"></span>
    </button>
  </div>

  <div class="px-4 py-2">
    {{ $slot }}
  </div>

  @if($footer)
    <div class="flex justify-end space-x-2 py-2 px-4 border-t border-neutral-400 dark:border-neutral-500">
      {{ $footer }}
    </div>
  @endif
</div>
