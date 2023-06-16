@props(['type' => null])

@php
  $bgColor = match($type) {
  'info' => 'bg-sky-300 dark:bg-sky-700 border border-sky-400 dark:border-sky-600',
  'danger' => 'bg-rose-300 dark:bg-rose-700 border border-rose-400 dark:border-rose-600',
  'warning' => 'bg-amber-300 dark:bg-amber-700 border border-amber-400 dark:border-amber-600',
  'success' => 'bg-teal-300 dark:bg-teal-700 border border-teal-400 dark:border-teal-600',
  default => 'bg-neutral-300 dark:bg-neutral-700 border border-neutral-400 dark:border-neutral-600',
};
@endphp

<span class="px-1.5 py-0.5 my-0.5 inline-block rounded {{ $bgColor }} font-medium mr-1">{{ $slot }}</span>
