@php
  $colorMap = [
      'info' => ['confirm_btn' => 'btn-primary', 'border' => 'border-blue-500', 'bg' => 'bg-blue-500', 'bg_light' => 'bg-blue-500/10'],
      'warning' => ['confirm_btn' => 'btn-warning', 'border' => 'border-amber-500', 'bg' => 'bg-amber-500', 'bg_light' => 'bg-amber-500/10'],
      'danger' => ['confirm_btn' => 'btn-danger', 'border' => 'border-red-500', 'bg' => 'bg-red-500', 'bg_light' => 'bg-red-500/10'],
      'success' => ['confirm_btn' => 'btn-success', 'border' => 'border-green-500', 'bg' => 'bg-green-500', 'bg_light' => 'bg-green-500/10'],
]
@endphp


<div class="flex flex-col border {{ $colorMap[$type]['border'] }} rounded-b-lg">
  <div class="w-full {{ $colorMap[$type]['bg'] }} text-neutral-950 dark:text-neutral-50 px-4 py-2">
    <div class="text-xl">{{ $title }}</div>
  </div>

  <div class="w-full p-4 border-b {{ $colorMap[$type]['border'] }} text-neutral-950 dark:text-neutral-50">
    <span>{{ $message }}</span>
  </div>
  <div class="w-full px-4 py-2 {{ $colorMap[$type]['bg_light'] }} flex justify-end space-x-4">
    <button type="button" class="btn btn-secondary" wire:click="$emit('closeModal')">{{ __('No') }}</button>
    <button type="button" class="btn {{ $colorMap[$type]['confirm_btn'] }}" wire:click="confirm">{{ __('Yes') }}</button>
  </div>
</div>
