<div>
  <h2>Scripts</h2>
  <div class="grid grid-cols-1 md:grid-cols-2 gap-4 my-3">
    @foreach($scripts as $script)
      <div class="flex flex-col w-full h-full rounded-lg bg-zinc-200 dark:bg-zinc-800">
        <div class="px-4 py-2 font-semibold border-b border-zinc-300 dark:border-zinc-700">{{ $script->getName() }}</div>
        <div class="px-4 py-2 h-full">
          {{ $script->getDescription() }}
        </div>
        <div class="px-4 py-2 border-t border-zinc-300 dark:border-zinc-700 flex justify-end gap-4">
          @if($script->runs()->exists())
            <button data-tippy-content="{{ __('Show history') }}"
                    wire:click.prevent="$emit('openModal', 'modals.shell-script-history', {{ json_encode(['shellScriptId' => $script->id]) }})" class="btn btn-sm py-0 px-0 text-xl text-sky-400 hover:text-sky-500">
              <span class="mdi mdi-history"></span>
            </button>
          @endif
          <button wire:click.prevent="$emit('openModal', 'modals.edit-shell-script', {{ json_encode(['shellScriptId' => $script->id]) }})" class="btn btn-sm btn-secondary">{{ __('Modify & Preview') }}</button>
          <button wire:click="runScript({{ $script->id }})" wire:key="{{ $script->id }}" wire:loading.remove wire:target="runScript" class="btn btn-sm btn-primary">{{ __('Run') }}</button>
          <button wire:loading wire:target="runScript" disabled class="btn btn-sm btn-primary"><i class="fa-solid fa-circle-notch fa-spin"></i></button>
        </div>
      </div>
    @endforeach
    @if($templates->isNotEmpty())
      <div class="flex flex-col w-full h-32 min-h-full rounded-lg bg-zinc-200 dark:bg-zinc-800 hover:bg-zinc-300 hover:dark:bg-zinc-700">
        <button wire:click.prevent="$emit('openModal', 'modals.edit-shell-script')" class="w-full h-full">
          <span class="mdi mdi-plus text-6xl"></span>
        </button>
      </div>
    @endif
  </div>

  <h2>Templates</h2>
  <div class="grid grid-cols-1 md:grid-cols-2 gap-4 my-3">
    @foreach($templates as $template)
      <div class="flex flex-col w-full h-full rounded-lg bg-zinc-200 dark:bg-zinc-800">
        <div class="px-4 py-2 font-semibold border-b border-zinc-300 dark:border-zinc-700">{{ $template->getName() }}</div>
        <div class="px-4 py-2 h-full">{{ $template->getDescription() }}</div>
        <div class="px-4 py-2 border-t border-zinc-300 dark:border-zinc-700 flex justify-end gap-4">
          <button wire:click.prevent="$emit('openModal', 'modals.edit-shell-script-template', {{ json_encode(['shellScriptId' => $template->id]) }})" class="btn btn-sm btn-secondary">{{ __('Modify') }}</button>
        </div>
      </div>
    @endforeach
    <div class="flex flex-col w-full h-32 min-h-full rounded-lg bg-zinc-200 dark:bg-zinc-800 hover:bg-zinc-300 hover:dark:bg-zinc-700">
      <button wire:click.prevent="$emit('openModal', 'modals.edit-shell-script-template')" class="w-full h-full">
        <span class="mdi mdi-plus text-6xl"></span>
      </button>
    </div>
  </div>

</div>
