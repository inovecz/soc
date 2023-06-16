<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4 gap-4">
  @foreach($settings as $key => $setting)
    <div class="w-full">

      <label for="menu-toggle-{{$key}}" class="flex items-center cursor-pointer">
        <div class="relative">
          <input wire:model="settings.{{$key}}" id="menu-toggle-{{$key}}" type="checkbox" class="sr-only"/>
          <div class="w-10 h-4 bg-gray-400 rounded-full shadow-inner"></div>
          <div class="dot absolute w-6 h-6 bg-white rounded-full shadow -left-1 -top-1 transition"></div>
        </div>
        <div class="ml-3 font-medium">
          {{ \Illuminate\Support\Str::of($key)->replace(['_n_', '_'], ['_&_', ' '])->title() }}
        </div>
      </label>

    </div>
  @endforeach
</div>
