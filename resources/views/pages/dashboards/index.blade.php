<x-app-layout>
  <x-slot name="header">
    {{ __('Dashboard / Home - Manage') }}
  </x-slot>

  <!--<editor-fold desc="ALERTS">-->
  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    <x-alert type="info" label="Total Alerts">3</x-alert>
    <x-alert type="danger" label="High Alerts">0</x-alert>
    <x-alert type="warning" label="Medium Alerts">1</x-alert>
    <x-alert type="success" label="Low Alerts">2</x-alert>
  </div>
  <!--</editor-fold desc="ALERTS">-->

  <!--<editor-fold desc="CHARTS">-->
  <h2>{{ __('Panels') }}</h2>
  <div class="grid-stack my-2">
    @foreach($panelMembers as $panelMember)
      <div gs-w="3" gs-h="1" class="grid-stack-item">
        <div class="p-2 w-full h-full">
          <div class="grid-stack-item-content overflow-hidden p-4 w-full h-full rounded-lg bg-zinc-200 dark:bg-zinc-800">
            <embed class="w-full h-full" src="{{ $panelMember['url'] }}" frameborder="0"/>
          </div>
        </div>
      </div>
    @endforeach
  </div>
  <!--</editor-fold desc="CHARTS">-->

  <!--<editor-fold desc="TABLE">-->
  <x-table label="Current problems">
    @slot('head')
      <th class="w-12">{{ __('Time') }}</th>
      <th class="w-96">{{ __('Host') }}</th>
      <th class="w-64">{{ __('Problem - Severity') }}</th>
      <th class="w-24">{{ __('Duration') }}</th>
      <th class="w-24">{{ __('Update') }}</th>
      <th class="w-48">{{ __('Tags') }}</th>
    @endslot

    @slot('body')
      @for($i = 0; $i < 5; $i++)
        <tr>
          <td>{{ fake()->time() }}</td>
          <td class="underline">{{ fake()->url() }}</td>
          <td>
            <x-tag type="{{ $i % 2 === 0 ? 'danger' : 'info' }}">Cert: Fingerprint has changed (new version: {{ fake()->uuid() }})</x-tag>
          </td>
          <td class="underline">{{ fake()->time('i\m\ s\s') }}</td>
          <td>
            <x-tag type="info">Update</x-tag>
          </td>
          <td>
            @for($j = 0; $j < random_int(0, 5); $j++)
              <x-tag>{{ fake()->word() }}</x-tag>
            @endfor
          </td>
        </tr>
      @endfor
    @endslot
  </x-table>

  <!--</editor-fold desc="TABLE">-->
  @push('styles')
    <link rel="stylesheet" href="{{ Vite::asset('css/gridstack.min.css') }}">
    <link rel="stylesheet" href="{{ Vite::asset('css/gridstack-extra.min.css') }}">
  @endpush

  @push('scripts')
    <script src="{{ Vite::asset('js/gridstack-all.js') }}"></script>
    <script>
        GridStack.init({column: 6});
    </script>
  @endpush

</x-app-layout>

