<x-app-layout>
  <x-slot name="header">
    {{ __('Dashboard / Home - Manage') }}
  </x-slot>

  @dump($dashboards)

</x-app-layout>

