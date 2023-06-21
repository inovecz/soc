<x-app-layout>
  <x-slot name="header">
    {{ __('Settings') }}
  </x-slot>

  <div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
      <div class="p-4 sm:p-8 bg-zinc-200 dark:bg-zinc-800 sm:rounded-lg">
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
          {{ __('Menu Settings') }}
        </h2>

        <p class="mt-1 mb-4 text-sm text-gray-600 dark:text-gray-400">
          {{ __('Update visibility of menu items') }}
        </p>

        <livewire:settings.menu-settings/>
      </div>
    </div>
  </div>

  <div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
      <div class="p-4 sm:p-8 bg-zinc-200 dark:bg-zinc-800 sm:rounded-lg">
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
          {{ __('Logo') }}
        </h2>

        <p class="mt-1 mb-4 text-sm text-gray-600 dark:text-gray-400">
          {{ __('Upload an logo for your account') }}
        </p>
        <livewire:settings.logo/>
      </div>
    </div>
  </div>
</x-app-layout>
