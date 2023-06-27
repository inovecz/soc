<div>

  <div class="flex flex-col md:flex-row justify-end mb-3 space-x-4 space-y-2">
    <input wire:model.debounce.500ms="search" class="input input-search" placeholder="{{ __('Search for...') }}">
    <div class="flex items-center space-x-4">
      <label for="hosts" class="block text-sm font-medium whitespace-nowrap">{{ __('Saved search') }}:</label>
      <select wire:model="searchId" id="hosts" class="input input-select">
        @foreach($savedSearches as $savedSearch)
          <option value="{{ $savedSearch['search_id'] }}">{{ $savedSearch['title'] }}</option>
        @endforeach
      </select>
    </div>
  </div>


  <x-table label="Messages ({{ $filteredMessages->count() }})">
    @slot('head')
      <th class="w-48">{{ __('Timestamp') }}</th>
      <th class="w-32">{{ __('Source') }}</th>
      <th>{{ __('Message') }}</th>
    @endslot
    @slot('body')
      <div class="flex justify-center w-full">
        <div wire:loading>
          <i class="fa-solid fa-circle-notch fa-spin mb-3 fa-2x"></i>
        </div>
      </div>
      @foreach($filteredMessages as $message)
        <tr wire:loading.remove>
          <td>{{ \Carbon\Carbon::parse($message['message']['timestamp'])->format('d.m.Y H:i:s') }}</td>
          <td>{{ $message['message']['source'] }}</td>
          <td>{{ $message['message']['message'] }}</td>
        </tr>
      @endforeach
    @endslot
  </x-table>
</div>
