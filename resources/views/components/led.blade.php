@props(['type' => null])
@php
  $bgColor = match($type) {
      'info' => 'bg-sky-500',
      'danger' => 'bg-rose-500',
      'warning' => 'bg-amber-500',
      'success' => 'bg-teal-500',
      default => 'bg-gray-500'
  };
@endphp

<div class="w-3 h-3 rounded-full {{ $bgColor }}"></div>
