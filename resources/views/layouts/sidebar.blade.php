<!-- Sidebar: visible on md+; mobile version is off-canvas -->
<div>
    <!-- Sidebar -->
    <aside class="w-48 bg-white border-r h-screen sticky top-0">
        @php
            $isItemVisible = function ($item) use (&$isItemVisible) {
                if (empty($item['roles']) || (auth()->check() && auth()->user()->hasAnyRole($item['roles']))) {
                    return true;
                }

                if (!empty($item['children'])) {
                    foreach ($item['children'] as $child) {
                        if ($isItemVisible($child)) {
                            return true;
                        }
                    }
                }

                return false;
            };

            $sidebarItems = collect(config('menu.items'))
                ->filter($isItemVisible);
            $homeItem = $sidebarItems->firstWhere('label', 'Accueil');
            $menuItems = $sidebarItems->filter(function ($item) {
                return $item['label'] !== 'Accueil';
            });
        @endphp
        <div class="px-3 py-4 overflow-y-auto">
            @if ($homeItem)
                <a href="{{ url($homeItem['href']) }}" class="block w-full px-2 py-2 mb-3 rounded-md text-sm font-semibold text-left text-gray-900 bg-gray-100 hover:bg-gray-200">
                    {{ $homeItem['label'] }}
                </a>
            @endif
            <nav class="space-y-2 text-left">
                @include('layouts.partials.sidebar-menu-items', ['items' => $menuItems, 'level' => 0, 'mobile' => false])
            </nav>
        </div>
    </aside>

    <!-- Mobile off-canvas sidebar (hidden by default) -->
    <div id="mobile-sidebar" class="fixed inset-0 z-50 bg-white p-4 md:hidden hidden">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold">Menu</h3>
            <button onclick="document.getElementById('mobile-sidebar').classList.add('hidden')" class="text-gray-600">
                Fermer
            </button>
        </div>
        <nav class="space-y-2 overflow-y-auto text-left">
            @include('layouts.partials.sidebar-menu-items', ['items' => $sidebarItems, 'level' => 0, 'mobile' => true])
        </nav>
    </div>
</div>
