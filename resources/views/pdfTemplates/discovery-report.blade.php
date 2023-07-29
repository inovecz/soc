<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SOC Devices Discovery report</title>
    <style>
        table {
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            text-align: left;
            padding: 8px;
        }
    </style>
  </head>
  <body>
    <div>
      <h2>{{ __('SOC Devices Discovery report') }} - {{ now()->format('d.m.Y H:i:s')}}</h2>

      <h3>{{ __('Filter criteria') }}:</h3>
      <table>
        <tbody>
          <tr>
            <td><strong>{{ __('Search') }}:</strong></td>
            <td>{{ $search !== '' ? $search : '-' }}</td>
          </tr>
          <tr>
            <td><strong>{{ __('Running at') }}:</strong></td>
            <td>{{ '-' }}</td>
          </tr>
          <tr>
            <td><strong>{{ __('Discovered before') }}:</strong></td>
            <td>{{ '-' }}</td>
          </tr>
          <tr>
            <td><strong>{{ __('Discovered after') }}:</strong></td>
            <td>{{ '-' }}</td>
          </tr>
          <tr>
            <td><strong>{{ __('Rule') }}:</strong></td>
            <td>{{ '-' }}</td>
          </tr>
          <tr>
            <td><strong>{{ __('Check') }}:</strong></td>
            <td>{{ '-' }}</td>
          </tr>
        </tbody>
      </table>

      <h3>{{ __('Discovered devices').' ('.count($devices).')' }}:</h3>

      @foreach($devices ?? collect() as $device)
        <table style="width: 100%;">
          <tbody>
            <tr style="background-color: #ccc; border-bottom: 2px solid #333">
              <td>#{{ $device->getHostId() }}</td>
              <td colspan="2">
                <div style="font-size: 8px">{{ __('First discover') }}: {{ Carbon\Carbon::parse($device->first_created_at)->format('d.m.Y H:i:s') }}</div>
                <div style="font-size: 8px">{{ __('Last discover') }}: {{ $device->getCreatedAt()->format('d.m.Y H:i:s') }}</div>
              </td>
              <td style="color: {{$device->getStatus() ? '#0d9488' : '#9f1239'}}; text-align: right">{{ $device->getStatus() ? __('Up') : __('Down') }}</td>
            </tr>
            <tr>
              <td>{{ __('Rule ID') }}</td>
              <td>{{ $device->getRuleId() }}</td>
              <td></td>
              <td></td>
            </tr>
            <tr>
              <td>{{ __('Last up') }}</td>
              <td>
                @if($device->getLastUp())
                  {{ $device->getLastUp()->format('d.m.Y H:i:s') }}
                @else
                  N/A
                @endif</td>
              <td>{{ __('Last down') }}</td>
              <td>
                @if($device->getLastDown())
                  {{ $device->getLastDown()->format('d.m.Y H:i:s') }}
                @else
                  N/A
                @endif
              </td>
            </tr>
            <tr>
              <td colspan="4" style="padding-left: 16px;">
                <table style="width: 100%;">
                  <tbody>
                    @foreach($device->getServices() as $service)
                      <tr style="background-color: #ddd; border-bottom: 1px dashed #666">
                        <td>{{ __('Service') }} #{{ $service['service_id'] }}</td>
                        <td style="color: {{$service['status'] ? '#0d9488' : '#9f1239'}}; text-align: right">{{ $service['status'] ? __('Up') : __('Down') }}</td>
                      </tr>
                      <tr>
                        <td>{{ __('Value') }}</td>
                        <td>{{ $service['value'] ?? 'N/A' }}</td>
                      </tr>
                      <tr>
                        <td>{{ __('IP address(:port)') }}</td>
                        <td>{{ $service['ip'] ?? 'N/A' }}{{ $service['port'] ? ':'.$service['port'] : '' }}</td>
                      </tr>
                      <tr>
                        <td>{{ __('DNS') }}</td>
                        <td>{{ $service['dns'] ?? 'N/A' }}</td>
                      </tr>
                      <tr>
                        <td>{{ __('Check ID') }}</td>
                        <td>{{ $service['check_id'] ?? 'N/A' }}</td>
                      </tr>
                      <tr>
                        <td>{{ __('Last up') }}</td>
                        <td>
                          @if($service['last_up'])
                            {{ Carbon\Carbon::parse($service['last_up'])->format('d.m.Y H:i:s') }}
                          @else
                            N/A
                          @endif
                        </td>
                      </tr>
                      <tr>
                        <td>{{ __('Last down') }}</td>
                        <td>
                          @if($service['last_down'])
                            {{ Carbon\Carbon::parse($service['last_down'])->format('d.m.Y H:i:s') }}
                          @else
                            N/A
                          @endif
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </td>
            </tr>
          </tbody>
        </table>
      @endforeach
    </div>
  </body>
</html>
