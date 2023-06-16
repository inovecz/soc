<x-app-layout>
  <x-slot name="header">
    {{ __('Settings') }}
  </x-slot>


  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
      <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
          {{ __('Menu Settings') }}
        </h2>

        <p class="mt-1 mb-4 text-sm text-gray-600 dark:text-gray-400">
          {{ __("Update visibility of menu items") }}
        </p>

        <livewire:settings.menu-settings/>

        {{--<form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
          @csrf
          @method('patch')


          <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
              <p
                  x-data="{ show: true }"
                  x-show="show"
                  x-transition
                  x-init="setTimeout(() => show = false, 2000)"
                  class="text-sm text-gray-600 dark:text-gray-400"
              >{{ __('Saved.') }}</p>
            @endif
          </div>
        </form>--}}
      </div>
    </div>
  </div>

</x-app-layout>
