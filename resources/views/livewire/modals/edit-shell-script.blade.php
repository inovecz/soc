<div id="modal" class="text-neutral-950 dark:text-neutral-50 rounded-lg border border-neutral-400 dark:border-neutral-500">
  <div class="flex justify-between items-center font-medium space-x-2 py-2 px-4 border-b border-neutral-400 dark:border-neutral-500">
    <div>{{ __('Edit Shell Script') }}</div>
    <button class="btn btn-icon">
      <span wire:click="$emit('closeModal')" class="mdi mdi-window-close"></span>
    </button>
  </div>

  <div class="px-4 py-2">
    <div class="flex flex-col space-y-3">
      <div class="space-y-2 w-full">
        <label for="name" class="block font-medium whitespace-nowrap">{{ __('Name') }}:</label>
        <input id="name" type="text" class="input" wire:model="name" placeholder="{{ __('Script name') }}"/>
        <x-input-error for="name" :messages="$errors->get('name')" class="mt-2"/>
      </div>
      <div class="space-y-2 w-full">
        <label for="description" class="block font-medium whitespace-nowrap">{{ __('Description') }}:</label>
        <input id="description" type="text" class="input" wire:model="description" placeholder="{{ __('Script description') }}"/>
        <x-input-error for="description" :messages="$errors->get('description')" class="mt-2"/>
      </div>
      <div class="space-y-2 w-full">
        <label for="shellScriptTemplateId" class="block font-medium whitespace-nowrap">{{ __('Shell Script Template') }}:</label>
        <select id="shellScriptTemplateId" class="input input-select" wire:model="shellScriptTemplateId">
          @foreach($shellScriptTemplates as $shellScriptTemplate)
            <option value="{{ $shellScriptTemplate->id }}">{{ $shellScriptTemplate->getName() }}</option>
          @endforeach
        </select>
      </div>

      @foreach($parameters as $name => $parameter)
        @switch($parameter['type'])
          @case('text')
            <label for="parameter_{{$name}}" class="block font-medium whitespace-nowrap">{{$name}}:</label>
            <input id="parameter_{{$name}}" type="text" class="input" wire:model="values.{{$name}}"/>
            <x-input-error for="parameters.{{$name}}.value" :messages="$errors->get('parameters.'.$name.'.value')" class="mt-2"/>
            @break
          @case('number')
            <label for="parameter_{{$name}}" class="block font-medium whitespace-nowrap">{{$name}}:</label>
            <input id="parameter_{{$name}}"
                   @if(isset($parameter['value']['min'])) min="{{ $parameter['value']['min'] }}" @endif
                   @if(isset($parameter['value']['max'])) max="{{ $parameter['value']['max'] }}" @endif
                   type="number" class="input"
                   wire:model="values.{{$name}}"/>
            <x-input-error for="parameters.{{$name}}.value" :messages="$errors->get('parameters.'.$name.'.value')" class="mt-2"/>
            @break
          @case('boolean')
            <x-toggle wireModel="values.{{$name}}" label="{{ $name }}"/>
            @break
          @case('select')
            <label for="parameter_{{$name}}" class="block font-medium whitespace-nowrap">{{$name}}:</label>
            <select id="parameter_{{$name}}" class="input input-select" wire:model="values.{{$name}}">
              @php
                $options = explode(';', $parameter['value']['options']);
              @endphp
              @foreach($options as $option)
                <option value="{{ $option }}">{{ $option }}</option>
              @endforeach
            </select>
            @break
        @endswitch
      @endforeach
    </div>
  </div>

  <div class="flex flex-col space-y-2 py-2 px-4 border-t border-neutral-400 dark:border-neutral-500">
    <div class="font-semibold">{{ __('Preview') }}</div>
    <pre class="bg-gray-900 w-full p-2 font-mono text-gray-50 text-xs overflow-x-auto">{{ $scriptPreview }}</pre>
  </div>

  <div class="flex justify-end space-x-2 py-2 px-4 border-t border-neutral-400 dark:border-neutral-500">
    <button wire:click="$emit('closeModal')" class="btn btn-link">
      {{ __('Cancel') }}
    </button>
    <button wire:click="save" wire:loading.remove wire:target="save" class="btn btn-primary">
      {{ __('Save') }}
    </button>
    <button wire:loading disabled wire:target="save" class="btn btn-primary">
      <i class="fa-solid fa-circle-notch fa-spin"></i>
    </button>
  </div>
</div>
