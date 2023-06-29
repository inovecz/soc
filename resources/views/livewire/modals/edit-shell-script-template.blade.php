<x-livewire-modal title="{{ __('Edit Shell Script Template') }}">

  <div class="flex flex-col space-y-3">
    <div class="space-y-2 w-full">
      <label for="name" class="block font-medium whitespace-nowrap">{{ __('Name') }}:</label>
      <input id="name" type="text" class="input" wire:model="name" placeholder="{{ __('Template name') }}"/>
      <x-input-error for="name" :messages="$errors->get('name')" class="mt-2"/>
    </div>
    <div class="space-y-2 w-full">
      <label for="description" class="block font-medium whitespace-nowrap">{{ __('Description') }}:</label>
      <input id="description" type="text" class="input" wire:model="description" placeholder="{{ __('Template description') }}"/>
      <x-input-error for="description" :messages="$errors->get('description')" class="mt-2"/>
    </div>
    <div class="space-y-2 w-full">
      <label for="script" class="block font-medium whitespace-nowrap">{{ __('Script') }} ({{ __('enclose parameters by $$Parameter name$$') }}):</label>
      <textarea rows="5" id="script" type="text" class="input" wire:model.debounce.500ms="script"></textarea>
      <x-input-error for="script" :messages="$errors->get('script')" class="mt-2"/>
    </div>
    @foreach($parameters as $name => $parameter)
      <div class="space-y-2 w-full">
        <label for="parameter_{{$name}}" class="block font-medium whitespace-nowrap">{{$name}}:</label>
        <div class="flex space-x-4">
          <div class="flex flex-col w-full">
            <label for="parameter_{{$name}}_default" class="text-xs">{{ __('Data type') }}:</label>
            <select id="parameter_{{$name}}" class="input" wire:model="parameters.{{$name}}.type">
              <option value="text" @if($parameter['type'] === 'text') selected @endif>{{ __('Text') }}</option>
              <option value="number" @if($parameter['type'] === 'number') selected @endif>{{ __('Number') }}</option>
              <option value="boolean" @if($parameter['type'] === 'boolean') selected @endif>{{ __('Boolean') }}</option>
              <option value="select" @if($parameter['type'] === 'select') selected @endif>{{ __('Select') }}</option>
              <option value="uuid" @if($parameter['type'] === 'uuid') selected @endif>{{ __('Random Uuid') }}</option>
            </select>
          </div>
          @if($parameter['type'] === 'text')
            <div class="flex flex-col w-full">
              <label for="parameter_{{$name}}_default" class="text-xs">{{ __('Default value') }}:</label>
              <input id="parameter_{{$name}}_default" type="text" class="input" wire:model.debounce.500ms="parameters.{{$name}}.value.default" placeholder="{{ __('Default value') }}"/>
            </div>
          @endif
          @if ($parameter['type'] === 'select')
            <div class="flex flex-col w-full">
              <label for="parameter_{{$name}}_default" class="text-xs">{{ __('Options separated by ";"') }}:</label>
              <input id="parameter_{{$name}}_options" type="text" class="input" wire:model.debounce.500ms="parameters.{{$name}}.value.options" placeholder="{{ __('Options separated by ;') }}"/>
            </div>
          @endif
          @if ($parameter['type'] === 'number')
            <div class="flex flex-col w-full">
              <label for="parameter_{{$name}}_default" class="text-xs">{{ __('Minimal value') }}:</label>
              <input id="parameter_{{$name}}_min" type="text" class="input" wire:model.debounce.500ms="parameters.{{$name}}.value.min" placeholder="{{ __('Minimal value') }}"/>
            </div>
            <div class="flex flex-col w-full">
              <label for="parameter_{{$name}}_default" class="text-xs">{{ __('Maximal value') }}:</label>
              <input id="parameter_{{$name}}_max" type="text" class="input" wire:model.debounce.500ms="parameters.{{$name}}.value.max" placeholder="{{ __('Maximal value') }}"/>
            </div>
            <div class="flex flex-col w-full">
              <label for="parameter_{{$name}}_default" class="text-xs">{{ __('Default value') }}:</label>
              <input id="parameter_{{$name}}_default" type="text" class="input" wire:model.debounce.500ms="parameters.{{$name}}.value.default" placeholder="{{ __('Default value') }}"/>
            </div>
          @endif
          @if ($parameter['type'] === 'boolean')
            <div class="flex flex-col w-full">
              <label for="parameter_{{$name}}_default" class="text-xs">{{ __('Default value') }}:</label>
              <select id="parameter_{{$name}}_default" class="input" wire:model.debounce.500ms="parameters.{{$name}}.value.default">
                <option value="0" @if(($parameters[$name]['value']['default'] ?? '0') === '0') selected @endif>{{ __('Off ("0")') }}</option>
                <option value="1" @if(($parameters[$name]['value']['default'] ?? '0') === '1') selected @endif>{{ __('On ("1")') }}</option>
              </select>
            </div>
          @endif
        </div>
        <x-input-error for="parameter_{{$name}}" :messages="$errors->get('parameters.'.$name.'.type')" class="mt-2"/>
        <x-input-error for="parameter_{{$name}}_options" :messages="$errors->get('parameters.'.$name.'.value.options')" class="mt-2"/>
        <x-input-error for="parameter_{{$name}}_min" :messages="$errors->get('parameters.'.$name.'.value.min')" class="mt-2"/>
        <x-input-error for="parameter_{{$name}}_max" :messages="$errors->get('parameters.'.$name.'.value.max')" class="mt-2"/>
        <x-input-error for="parameter_{{$name}}_default" :messages="$errors->get('parameters.'.$name.'.value.default')" class="mt-2"/>
      </div>
    @endforeach
  </div>


  @slot('footer')
    <button wire:click="$emit('closeModal')" class="btn btn-link">
      {{ __('Cancel') }}
    </button>
    <button wire:click="save" wire:loading.remove wire:target="save" class="btn btn-primary">
      {{ __('Save') }}
    </button>
    <button wire:loading disabled wire:target="save" class="btn btn-primary">
      <i class="fa-solid fa-circle-notch fa-spin"></i>
    </button>
  @endslot
</x-livewire-modal>
