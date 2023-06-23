<nav x-data="{ isMenuExpanded: $persist(@entangle('isMenuExpanded')).as('isMenuExpanded')}"
     x-init="$watch('isMenuExpanded', value => {
              if (value) {
                document.body.classList.add('isMenuExpanded');

              } else {
                document.body.classList.remove('isMenuExpanded');
              }
              $dispatch('is-expanded-updated', value)
             })">
  <aside class="h-screen bg-zinc-200 dark:bg-zinc-800 flex flex-col items-center transition-[width] duration-300 overflow-hidden"
         :class="isMenuExpanded ? 'w-52' : 'w-10'">
    <span class="w-full text-start py-1 px-2.5 text-2xl">
      <button @click="isMenuExpanded = !isMenuExpanded; $dispatch('is-expanded-updated', isMenuExpanded)"
              class="transition-transform duration-300"
              :class="isMenuExpanded ? 'rotate-180' : 'rotate-0'">
        <span class="mdi mdi-chevron-right"></span>
      </button>
      @if($logo)
        <div class="flex justify-center">
        <img src="{{ $logo }}" class="max-h-10 object-contain" alt="logo"/>
        </div>
      @endif
    </span>
    @foreach($menuItems as $menuItem)
      @if (empty($menuItem))
        <div class="w-full text-2xl">&nbsp;</div>
      @else
        @if(!array_key_exists('role_id', $menuItem) || auth()->user()->hasRole($menuItem['role_id']))
          @php
            $activeClass = '';
            if ($menuItem['active']) {
                if ($isMenuExpanded) {
                    $activeClass = 'border-l-8 border-sky-400';
                } else {
                    $activeClass = 'border-l-0 bg-sky-400';
                }
            }

          @endphp
          <div class="w-full menu-item" x-data="{ open: false }">

            <button class="w-full flex items-center justify-start text-left cursor-pointer
                  {{ $menuItem['active'] ? $activeClass : 'hover:bg-zinc-600' }}"
                    @if(!$menuItem['route'] && !empty($menuItem['submenu']))
                      @click="open = !open"
                    @else
                      wire:click="routeTo('{{$menuItem['route']}}')"
                @endif
            >

          <span class="mdi {{ $menuItem['icon'] }} py-1 px-2 text-2xl
              {{ $menuItem['active'] ? 'text-neutral-950 dark:text-neutral-50' : 'text-sky-400' }}"></span>
              <div class="text-xs pl-2 whitespace-nowrap overflow-hidden" :class="isMenuExpanded ? 'w-full' : 'w-0'">{{ $menuItem['label'] }}</div>
              <div class="px-2">
                @if(!empty($menuItem['submenu']))
                  <span class="mdi mdi-chevron-down"></span>
                @endif
              </div>
            </button>
            @if(!empty($menuItem['submenu']))
              <div x-show="open"
                   x-transition:enter="transition ease-out duration-200"
                   x-transition:enter-start="transform opacity-0 scale-95"
                   x-transition:enter-end="transform opacity-100 scale-100"
                   x-transition:leave="transition ease-in duration-75"
                   x-transition:leave-start="transform opacity-100 scale-100"
                   x-transition:leave-end="transform opacity-0 scale-95"
                   class="bg-neutral-50 dark:bg-neutral-950 w-full pl-12">
                @foreach($menuItem['submenu'] as $submenu)
                  @if(isset($submenu['route']))
                    <button class="w-full pl-4 py-2 text-xs flex items-center justify-start text-left border-l-8 cursor-pointer {{ $submenu['active'] ? 'border-sky-400' : 'border-transparent bg-neutral-100 dark:bg-neutral-900' }}"
                            wire:click="routeTo('{{ $submenu['route'] }}', {{ isset($submenu['params']) ? json_encode($submenu['params']) : null }})"
                            x-init="!open ? open = {{ json_encode($submenu['active']) }} && !open : false">
                      {{ $submenu['label'] }}
                    </button>
                  @else
                    <button class="w-full pl-4 py-2 text-rose-500 text-xs flex items-center justify-start text-left border-l-8 cursor-default border-transparent bg-neutral-100 dark:bg-neutral-900">
                      {{ $submenu['label'] }}
                    </button>
                  @endif
                @endforeach
              </div>
            @endif
          </div>
        @endif
      @endif
    @endforeach
  </aside>
</nav>
