<div>
  @if ($logo)
    <div class="relative max-w-full">
      <img src="{{ $logo }}" class="max-w-full object-contain" alt="logo"/>
      <div wire:click="removeLogo()" class="absolute right-0 top-0 w-6 h-6 translate-x-1/2 -translate-y-1/2 flex justify-center items-center bg-red-500 hover:bg-red-600 cursor-pointer rounded-full text-gray-50"><span class="mdi mdi-close"></span></div>
    </div>
  @else

    <form wire:submit.prevent="submit">
      @csrf
      <div class="mb-6">
        <label class="block">
          <span class="sr-only">Choose File</span>
          <input type="file" wire:model="uploadedLogo" class="btn btn-file" accept="image/*">
        </label>
        @error('uploadedLogo')
        <div class="flex items-center text-sm text-red-600">
          {{ $message }}
        </div>
        @enderror
      </div>
      <div class="flex justify-end">
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </form>
  @endif
</div>
