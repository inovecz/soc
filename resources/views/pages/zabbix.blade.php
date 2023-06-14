<x-app-layout>
  <x-slot name="header">
    {{ __('Servers - Zabbix test') }}
  </x-slot>
  <div class="bg-zinc-200 dark:bg-zinc-800 overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-6 text-gray-900 dark:text-gray-100">

      <div class="relative overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
          <thead class="text-xs text-gray-700 uppercase bg-zinc-300 dark:bg-zinc-700 dark:text-gray-400">
            <tr>
              <th scope="col" class="px-2 py-3 whitespace-nowrap">
                Host ID
              </th>
              <th scope="col" class="px-2 py-3 whitespace-nowrap">
                Host name
              </th>
              <th scope="col" class="px-2 py-3 whitespace-nowrap">
                OS
              </th>
            </tr>
          </thead>
          <tbody>
            @foreach($hosts as $host)
              <tr class="border-b bg-zinc-200 dark:bg-zinc-800 dark:border-gray-700">
                <th scope="row" class="px-2 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                  {{ $host['hostid'] }}
                </th>
                <td class="px-2 py-4 whitespace-nowrap">
                  {{ $host['host'] }}
                </td>
                <td class="px-2 py-4">
                  <p class="whitespace-nowrap overflow-hidden text-ellipsis">{{ $host['inventory']['os'] }}</p>
                </td>
              </tr>
            @endforeach

          </tbody>
        </table>
      </div>

    </div>
  </div>
</x-app-layout>
