@props(['label', 'wireModel' => null, 'name' => null, 'disabled' => false, 'trueColor' => 'peer-checked:bg-sky-500', 'falseColor' => 'bg-gray-500'])

<label for="toggle-{{ $wireModel }}" class="flex items-center cursor-pointer">
  <div class="relative group">
    <input @if($wireModel)wire:model="{{ $wireModel }}" @endif name="{{ $name }}" id="toggle-{{ $wireModel }}" type="checkbox" class="sr-only peer" {{ $disabled ? 'disabled' : '' }}/>
    <div class="w-10 h-4 bg-gray-400 rounded-full shadow-inner"></div>
    <div class="absolute w-6 h-6 {{ $falseColor }} {{ $trueColor }} peer-checked:translate-x-6 peer-checked:hover:translate-x-5 rounded-full shadow -left-1 -top-1 transition duration-500 group-hover:translate-x-1 ease-in-out"></div>
  </div>
  <div class="ml-3 font-medium">
    {{ $label }}
  </div>
</label>

