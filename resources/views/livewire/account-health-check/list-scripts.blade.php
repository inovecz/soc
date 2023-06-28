<div>
  <h2>Scripts</h2>
  <div class="grid grid-cols-2 gap-4 my-3">
    @foreach($scripts as $script)
      <div class="flex flex-col w-full h-full rounded-lg bg-zinc-200 dark:bg-zinc-800">
        <div class="px-4 py-2 font-semibold border-b border-zinc-300 dark:border-zinc-700">{{ $script->getName() }}</div>
        <div class="px-4 py-2 h-full">
          {{ $script->getDescription() }}
        </div>
        <div class="px-4 py-2 border-t border-zinc-300 dark:border-zinc-700 flex justify-end gap-4">
          <button data-tippy-content="{{ __('Delete script') }}"
                  wire:click.prevent="$emit('openModal', 'modals.yes-no-modal', {{ json_encode(['action' => 'deleteScript', 'type' => 'danger', 'params' => ['shellScriptId' => $script->id], 'title' => __('Delete script'), 'message' => __('Do you really wish to delete this script? Along with that, its execution history will be deleted too.')]) }})" class="btn btn-sm py-0 px-0 text-xl text-rose-400 hover:text-rose-500">
            <span class="mdi mdi-trash-can"></span>
          </button>
          <button wire:click.prevent="$emit('openModal', 'modals.edit-shell-script', {{ json_encode(['shellScriptId' => $script->id]) }})" class="btn btn-sm btn-secondary">{{ __('Modify & Preview') }}</button>
          <button class="btn btn-sm btn-primary">{{ __('Run') }}</button>
        </div>
      </div>
    @endforeach
    @if($templates->isNotEmpty())
      <div class="flex flex-col w-full h-32 min-h-full rounded-lg bg-zinc-200 dark:bg-zinc-800 hover:bg-zinc-300 hover:dark:bg-zinc-700">
        <button onclick="Livewire.emit('openModal', 'modals.edit-shell-script')" class="w-full h-full">
          <span class="mdi mdi-plus text-6xl"></span>
        </button>
      </div>
    @endif
  </div>

  <h2>Templates</h2>
  <div class="grid grid-cols-2 gap-4 my-3">
    @foreach($templates as $template)
      <div class="flex flex-col w-full h-full rounded-lg bg-zinc-200 dark:bg-zinc-800">
        <div class="px-4 py-2 font-semibold border-b border-zinc-300 dark:border-zinc-700">{{ $template->getName() }}</div>
        <div class="px-4 py-2 h-full">{{ $template->getDescription() }}</div>
        <div class="px-4 py-2 border-t border-zinc-300 dark:border-zinc-700 flex justify-end gap-4">
          <button onclick="Livewire.emit('openModal', 'modals.edit-shell-script-template', {{ json_encode(['shellScriptId' => $template->id]) }})" class="btn btn-sm btn-secondary">{{ __('Modify') }}</button>
        </div>
      </div>
    @endforeach
    <div class="flex flex-col w-full h-32 min-h-full rounded-lg bg-zinc-200 dark:bg-zinc-800 hover:bg-zinc-300 hover:dark:bg-zinc-700">
      <button onclick="Livewire.emit('openModal', 'modals.edit-shell-script-template')" class="w-full h-full">
        <span class="mdi mdi-plus text-6xl"></span>
      </button>
    </div>
  </div>

</div>
