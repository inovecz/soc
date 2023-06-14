@props(['type' => 'info', 'label' => 'Alert Label'])
@php
  $textColor = match($type) {
      'info' => 'text-sky-400',
      'danger' => 'text-rose-600',
      'warning' => 'text-amber-500',
      'success' => 'text-teal-500'
  };
  $icon = match($type) {
      'info' => 'mdi-alert-circle-outline',
      'danger' => 'mdi-alert-octagon',
      'warning' => 'mdi-alert',
      'success' => 'mdi-alert-circle'
  };
@endphp

<div class="bg-zinc-200 dark:bg-zinc-800 rounded-lg py-6 flex flex-col items-center space-y-1">
  <div class="text-3xl font-bold {{ $textColor }}">{{ $slot }}</div>
  <div class="flex items-center space-x-2">
    <span class="mdi {{ $icon }} {{ $textColor }}"></span>
    <span class="text-xs">{{ $label }}</span>
  </div>
</div>
