<x-app-layout>
  <x-slot name="header">
    {{ __('Servers - Graylog test') }}
  </x-slot>
  <div class="bg-zinc-200 dark:bg-zinc-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
    <div class="p-6 text-gray-900 dark:text-gray-100">

      <div class="relative overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
          <thead class="text-xs text-gray-700 uppercase bg-zinc-300 dark:bg-zinc-700 dark:text-gray-400">
            <tr>
              <th class="px-2 py-3"></th>
              <th scope="col" class="px-2 py-3 whitespace-nowrap">
                Cluster
              </th>
              <th scope="col" class="px-2 py-3 whitespace-nowrap">
                ID
              </th>
              <th scope="col" class="px-2 py-3 whitespace-nowrap">
                Started at
              </th>
              <th scope="col" class="px-2 py-3 whitespace-nowrap">
                OS
              </th>
            </tr>
          </thead>
          <tbody>
            <tr class="border-b bg-zinc-200 dark:bg-zinc-800 dark:border-gray-700">
              @foreach($clusters as $cluster)
                <td scope="row" class="px-2 py-4">
                  <div class="w-4 h-4 {{ $cluster['is_processing'] ? 'bg-green-500' : 'bg-red-500' }} rounded-full"></div>
                </td>
                <th scope="row" class="px-2 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                  <div><span class="text-gray-500 mr-2">Facility:</span>{{ $cluster['facility'] }}</div>
                  <div><span class="text-gray-500 mr-2">Codename:</span>{{ $cluster['codename'] }}</div>
                </th>
                <td class="px-2 py-4 whitespace-nowrap">
                  <div><span class="text-gray-500 mr-2">Node ID:</span>{{ $cluster['node_id'] }}</div>
                  <div><span class="text-gray-500 mr-2">Cluster ID:</span>{{ $cluster['cluster_id'] }}</div>
                </td>
                <td class="px-2 py-4">
                  {{ Carbon\Carbon::parse($cluster['started_at'])->format('d.n.Y H:i')}}
                </td>
                <td class="px-2 py-4">
                  {{ $cluster['operating_system'] }}
                </td>
              @endforeach
            </tr>
          </tbody>
        </table>
      </div>

    </div>
  </div>


  <livewire:graylog.messages/>

</x-app-layout>
