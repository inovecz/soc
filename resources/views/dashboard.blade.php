<x-app-layout>
  <x-slot name="header">
    {{ __('Dashboard / Home - Manage') }}
  </x-slot>

  <!--<editor-fold desc="ALERTS">-->
  <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    <x-alert type="info" label="Total Alerts">3</x-alert>
    <x-alert type="danger" label="High Alerts">0</x-alert>
    <x-alert type="warning" label="Medium Alerts">1</x-alert>
    <x-alert type="success" label="Low Alerts">2</x-alert>
  </div>
  <!--</editor-fold desc="ALERTS">-->

  <!--<editor-fold desc="PANELS">-->
  <h2>{{ __('Panels') }}</h2>
  <div class="grid grid-cols-2 gap-4 mb-6 mt-2">
    @if(!empty($panels))
      @foreach($panels as $panel)
        <div class="flex flex-col px-4 py-2 min-h-20 text-6xl rounded-lg bg-zinc-200 dark:bg-zinc-800">
          <div class="text-lg">{{ $panel['title'] }}</div>
          <div class="grid grid-cols-2 text-sm">
            <div>Datasource - type:</div>
            <div>{{ $panel['datasource']['type'] }}</div>
            <div>Datasource - uid:</div>
            <div>{{ $panel['datasource']['uid'] }}</div>
          </div>
        </div>
      @endforeach
    @endif
  </div>
  <!--</editor-fold desc="PANELS">-->

  <!--<editor-fold desc="CHARTS">-->

  <div class="grid grid-rows-2 grid-flow-col gap-4 mb-6"
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
           class="flex items-center justify-center min-h-20 text-6xl rounded-lg bg-zinc-200 dark:bg-zinc-800 relative cursor-move">

        <p class="font-semibold p-3" x-text="member.name"></p>

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
      <th>{{ __('Time') }}</th>
      <th class="w-64">{{ __('Host') }}</th>
      <th class="w-64">{{ __('Problem - Severity') }}</th>
      <th>{{ __('Duration') }}</th>
      <th>{{ __('Update') }}</th>
      <th>{{ __('Tags') }}</th>
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
          let savedMembers = localStorage.getItem('dragDropMembers');
          let initialMembers = [
              {name: '01', size: 1},
              {name: '02', size: 1},
              {name: '03', size: 2},
              {name: '04', size: 2},
              {name: '05', size: 2}
          ];

          let members = savedMembers ? JSON.parse(savedMembers) : initialMembers;
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
                      localStorage.setItem('dragDropMembers', JSON.stringify(this.members));
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

