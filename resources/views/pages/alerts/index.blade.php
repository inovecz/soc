<x-app-layout>
  <x-slot name="header">
    {{ __('Alerts') }}
  </x-slot>
  @dump($alerts)
</x-app-layout>
