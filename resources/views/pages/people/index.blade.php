<x-app-layout>
  <x-slot name="header">
    {{ __('People') }}
  </x-slot>

  <x-table label="Users list">
    @slot('head')
      <th class="w-8">ID</th>
      <th class="w-32">{{ __('Username') }}</th>
      <th class="w-32">{{ __('Name') }}</th>
      <th class="w-32">{{ __('Surname') }}</th>
      <th class="w-32">{{ __('Autologin') }}</th>
      <th class="w-32">{{ __('Autologout') }}</th>
      <th class="w-32">{{ __('Lang') }}</th>
      <th class="w-32">{{ __('Timezone') }}</th>
      <th class="w-32">{{ __('Role') }}</th>
      <th class="w-32">{{ __('SOC') }}</th>
    @endslot

    @slot('body')
      @foreach($users as $user)
        <tr>
          <td>{{ $user['userid'] }}</td>
          <td>{{ $user['username'] }}</td>
          <td>{{ $user['name'] }}</td>
          <td>{{ $user['surname'] }}</td>
          <td>{{ $user['autologin'] }}</td>
          <td>{{ $user['autologout'] }}</td>
          <td>{{ $user['lang'] }}</td>
          <td>{{ $user['timezone'] }}</td>
          <td>{{ $user['roleid'] }}</td>
          <td>{{ \App\Models\User::where('zabbix_id', $user['userid'])->exists() ? 'Ano' : 'Ne'}}</td>
        </tr>
      @endforeach
    @endslot
  </x-table>

</x-app-layout>
