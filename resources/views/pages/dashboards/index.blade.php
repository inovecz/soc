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

  <!--<editor-fold desc="PANELS">-->
  {{--<h2>{{ __('Panels') }}</h2>
  <div class="grid grid-cols-2 gap-4 mb-6 mt-2">
    @if(!empty($panels))
      @foreach($panels as $panel)
        <div class="flex flex-col px-4 py-2 min-h-20 text-6xl rounded-lg bg-zinc-200 dark:bg-zinc-800">
          <div class="text-lg">{{ $panel['title'] ?? __('Untitled') }}</div>
          <div class="grid grid-cols-2 text-sm">
            <div>Id:</div>
            <div class="text-xs flex items-center">{{ $panel['id'] }}</div>
            <div>Datasource:</div>
            <div>Type: {{ $panel['datasource']['type'] }} <br> Uid: {{ $panel['datasource']['uid'] }}</div>
            <div>gridPos:</div>
            <div>
              x: {{ $panel['gridPos']['x'] }}, y: {{ $panel['gridPos']['y'] }},
              w: {{ $panel['gridPos']['w'] }}, h: {{ $panel['gridPos']['h'] }}
            </div>
            <div>Targets:</div>
            <div>
              @foreach($panel['targets'] as $target)
                <div>Type: {{ $target['datasource']['type'] }} <br> Uid: {{ $target['datasource']['uid'] }}</div>
                <div>refId: {{ $target['refId'] }}</div>
              @endforeach
            </div>
            <div>Type:</div>
            <div>{{ $panel['type'] }}</div>
            <div>Embed link:</div>
            <div>{{ config('services.grafana.host_no_api') }}/d-solo/{{ $dashboard['uid'] }}/{{ $dashboard['slug'] }}?orgId=1&refresh=30s&panelId={{ $panel['id'] }}</div>
          </div>
        </div>
      @endforeach
    @endif
  </div>--}}
  <!--</editor-fold desc="PANELS">-->

  <!--<editor-fold desc="CHARTS">-->

  <h2>{{ __('Panels') }}</h2>
  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mt-2 mb-6"
       x-data="members()"
       @drop.prevent='onDrop($event)'
       @dragover.prevent='onDragover($event)'>

    <template x-for="(member, index) in members" :key='index'>
      <div draggable="true"
           @dragstart='onDragstart(index)'
           @dragend='onDragend()'
           :class="{
            'opacity-25': draggingIndex === index,
            'pt-20': droppingIndex == index && draggingIndex > index,
            'pb-20': droppingIndex == index && draggingIndex < index,
            'row-span-2': member.size == 2
         }"
           class="flex flex-col items-center justify-center min-h-20 rounded-lg bg-zinc-200 dark:bg-zinc-800 relative cursor-move">

        <div class="font-semibold p-3" x-text="member.title"></div>
        <embed :src="member.url" class="w-full" frameborder="0"/>

        <div class="absolute inset-0 opacity-60 cursor-move z-10"
             @dragenter.prevent="onDragenter(event, index)" @dragleave="onDragleave">

        </div>

        <div :class="{'h-20 top-0 bg-neutral-300': droppingIndex === index && draggingIndex > index, 'h-20 bottom-0 bg-gray-300': droppingIndex === index && draggingIndex < index}" class="absolute h-0 w-full bg-neutral-300 opacity-50 rounded">
        </div>
      </div>
    </template>
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

  <script>
      function members() {
          let members = @json($panelMembers);
          let panelIndexes = localStorage.getItem('panelIndexes_{{$dashboardUid}}');
          if (panelIndexes) {
              panelIndexes = JSON.parse(panelIndexes);
              members.sort((a, b) => {
                  const indexA = panelIndexes.find(item => item.id === a.id).index;
                  const indexB = panelIndexes.find(item => item.id === b.id).index;
                  return indexA - indexB;
              });
          }

          return {
              draggingIndex: null,
              droppingIndex: null,
              members: members,
              onDrop(event) {
                  // rearrange the array by inserting the dropped element
                  if (this.draggingIndex !== null && this.droppingIndex !== null) {
                      if (this.draggingIndex < this.droppingIndex) {

                          this.members = [
                              ...this.members.slice(0, this.draggingIndex),
                              ...this.members.slice(this.draggingIndex + 1, this.droppingIndex + 1),
                              this.members[this.draggingIndex],
                              ...this.members.slice(this.droppingIndex + 1)
                          ];
                      } else if (this.draggingIndex === this.droppingIndex) {
                          // do nothing if the drag and drop index is the same
                      } else {
                          this.members = [
                              ...this.members.slice(0, this.droppingIndex),
                              this.members[this.draggingIndex],
                              ...this.members.slice(this.droppingIndex, this.draggingIndex),
                              ...this.members.slice(this.draggingIndex + 1)
                          ];
                      }
                      const positions = this.members.map((member, index) => ({
                          index: index,
                          id: member.id
                      }));
                      localStorage.setItem('panelIndexes_{{ $dashboardUid }}', JSON.stringify(positions));
                  }
              },
              onDragover(event) {
                  event.dataTransfer.dropEffect = 'move';
              },
              onDragstart(index) {
                  this.draggingIndex = index;
              },
              onDragend() {
                  this.draggingIndex = null;
                  this.droppingIndex = null;
              },
              onDragenter(event, index) {
                  event.preventDefault();
                  this.droppingIndex = index;

              },
              onDragleave(index) {
                  if (index === this.droppingIndex) {
                      this.droppingIndex = null;
                  }
              },
          }
      }
  </script>

</x-app-layout>

