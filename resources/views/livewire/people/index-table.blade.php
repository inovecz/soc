<x-table label="Users list">
  @slot('head')
    <th class="w-8">ID</th>
    <th class="w-32">{{ __('Username') }}</th>
    <th class="w-24">{{ __('Name') }}</th>
    <th class="w-32">{{ __('Surname') }}</th>
    <th class="w-24">{{ __('Autologin') }}</th>
    <th class="w-24">{{ __('Autologout') }}</th>
    <th class="w-24">{{ __('Lang') }}</th>
    <th class="w-24">{{ __('Timezone') }}</th>
    <th class="w-24">{{ __('Role') }}</th>
    <th class="w-32">{{ __('SOC') }}</th>
    <th class="w-32 text-right">{{ __('Actions') }}</th>
  @endslot

  @slot('body')
    @foreach($users as $user)
      @php
        $localUser = \App\Models\User::where('zabbix_id', $user['userid'])->first();
      @endphp
      <tr class="h-10">
        <td>{{ $user['userid'] }}</td>
        <td>{{ $user['username'] }}</td>
        <td>{{ $user['name'] }}</td>
        <td>{{ $user['surname'] }}</td>
        <td>
          <x-led type="{{ $user['autologin'] === '1' ? 'success' : 'danger' }}"></x-led>
        </td>
        <td>
          @if($user['autologout'] === '0')
            <x-led type="danger"></x-led>
          @else
            {{ $user['autologout'] }}
          @endif
        </td>
        <td>{{ $user['lang'] === 'default' ? $settings['default_lang'] : $user['lang'] }}</td>
        <td>{{ $user['timezone'] === 'default' ? $settings['default_timezone'] : $user['timezone'] }}</td>
        <td>
          @if(isset($user['role']['name']))
            {{ $user['role']['name'] }}
          @else
            <x-led type="danger"></x-led>
          @endif
        </td>
        <td>
          <x-led type="{{ $localUser ? 'success' : 'danger' }}"></x-led>
        </td>
        <td class="text-right">
          @if($localUser)
            <button class="btn btn-icon" data-tippy-content="{{ __('IP Whitelist') }}">
              <span class="mdi mdi-ip-network" wire:click="$emit('openModal', 'people.modals.edit-ip-whitelist', {{ json_encode(['user' => $localUser->id]) }})"></span>
            </button>
          @endif
        </td>
      </tr>
    @endforeach
  @endslot
</x-table>
