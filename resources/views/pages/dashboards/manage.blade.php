<x-app-layout>
  <x-slot name="header">
    {{ __('Dashboard / Home - Manage') }}
  </x-slot>

  @foreach($dashboards as $folderTitle => $folderDashboards)
    <h2>{{ $folderTitle !== '' ? $folderTitle : __('Without folder')}}</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 my-3">
      @foreach($folderDashboards as $dashboard)
        <div class="flex flex-col w-full h-full rounded-lg bg-zinc-200 dark:bg-zinc-800">
          <div class="px-4 py-2 font-semibold border-b border-zinc-300 dark:border-zinc-700 flex justify-between">
            <span>{{ $dashboard['title'] }}</span>
            @if($dashboard['isStarred'])
              <span class="mdi mdi-star text-yellow-500 mr"></span>
            @endif
          </div>
          <div class="px-4 py-2 h-full">
            {{ __('Tags') }}:
            @foreach($dashboard['tags'] as $tag)
              <x-tag>{{ $tag }}</x-tag>
            @endforeach
          </div>
          <div class="px-4 py-2 border-t border-zinc-300 dark:border-zinc-700 flex justify-end gap-4">
            <a href="{{route('dashboards.index',['dashboardUid' => $dashboard['uid']])}}" class="btn btn-primary">{{ __('Go to') }}</a>
          </div>
        </div>
      @endforeach
    </div>
  @endforeach

</x-app-layout>

