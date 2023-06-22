<div wire:poll.1000ms="loadMessages">
  <x-table label="Messages">
    @slot('head')
      <th class="w-48">{{ __('Timestamp') }}</th>
      <th class="w-48">{{ __('Source') }}</th>
      <th>{{ __('Message') }}</th>
    @endslot
    @slot('body')
      @foreach($messages as $message)
        <tr>
          <td>{{ \Carbon\Carbon::parse($message['timestamp'])->format('H:i:s') }}</td>
          <td>{{ $message['source'] }}</td>
          <td>{{ $message['message'] }}</td>
        </tr>
      @endforeach
    @endslot
  </x-table>
</div>
