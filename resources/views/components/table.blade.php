@props(['label' => 'Table title'])

<div class="w-full bg-zinc-200 dark:bg-zinc-800 overflow-hidden shadow-sm sm:rounded-lg px-4 py-2 mb-6">
  <div class="flex justify-between items-center mb-4 font-bold">
    <div class="text-xs">{{ $label }}</div>
    <div class="text-md">{{--<span class="mdi mdi-dots-horizontal text-sky-400"></span>--}}</div>
  </div>
  <div class="w-full overflow-x-auto">
    <table class="w-full datatable table-fixed text-left">
      <thead>
        <tr>
          {{ $head }}
        </tr>
      </thead>


      <tbody>
        {{ $body ?? '' }}
      </tbody>
      {{ $bodies ?? '' }}
    </table>
  </div>
</div>
