<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      x-cloak
      x-show="darkMode"
      x-data="{darkMode: localStorage.getItem('darkMode') || localStorage.setItem('darkMode', 'system')}"
      x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val))"
      x-bind:class="{'dark': darkMode === 'dark' || (darkMode === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches)}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    @livewireStyles
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
  </head>
  <body class="font-sans antialiased">
    @include('helpers.screen-size', ['location' => 'bottom-center', 'margin' => 'lg'])
    <div class="min-h-screen bg-neutral-50 dark:bg-neutral-950 text-neutral-950 dark:text-neutral-50">

      <div class="flex">
        <div>
          <livewire:components.side-navigation/>
        </div>
        <div class="flex-1">
          <div class="flex flex-col">
            @include('layouts.navigation')
            <main>
              <div class="px-4 sm:px-6 lg:px-8">
                {{ $slot }}
              </div>
            </main>
          </div>
        </div>
      </div>


      <!-- Page Content -->

    </div>
    @stack('scripts')
    @livewireScripts
  </body>
</html>
