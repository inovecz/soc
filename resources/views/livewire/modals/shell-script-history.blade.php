<x-livewire-modal title="{{ __('Shell script history (showing last 10 items)') }}">

  <div x-data="{ openTab: 0 }" class="w-full">
    @foreach($shellScriptRuns as $index => $shellScriptRun)
      <div class="mb-4">
        <div x-on:click="openTab = (openTab === {{$index}} ? 0 : {{$index}})" class="w-full py-2 px-4 rounded bg-neutral-800 hover:bg-neutral-700 cursor-pointer" :class="{'bg-neutral-900': openTab === {{$index}}}">
          @switch($shellScriptRun->getState())
            @case(\App\Enums\ScriptStatus::PENDING)
              <span class="mdi mdi-timer-sand text-gray-500"></span>
              @break
            @case(\App\Enums\ScriptStatus::FINISHED)
              <span class="mdi mdi-check-circle-outline text-green-500"></span>
              @break
            @case(\App\Enums\ScriptStatus::FAILED)
              <span class="mdi mdi-alert-circle text-rose-500"></span>
              @break
            @case(\App\Enums\ScriptStatus::RUNNING)
              <span class="mdi mdi-run text-sky-500"></span>
              @break
          @endswitch
          {{ $shellScriptRun->getCreatedAt()->format('d.m.Y H:i:s') }}
        </div>
        <div x-show="openTab === {{$index}}" class="py-4">
          <pre class="bg-gray-900 w-full p-2 font-mono text-gray-50 text-xs overflow-x-auto">{{ $shellScriptRun->getOutput() ?? __('Waiting for output...') }}</pre>
        </div>
      </div>
    @endforeach
  </div>

  @slot('footer')
    <button wire:click="$emit('closeModal')" class="btn btn-link">
      {{ __('Cancel') }}
    </button>
  @endslot
</x-livewire-modal>
