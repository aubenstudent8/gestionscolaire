<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    @php
        $menuItems = collect(config('menu.items'))
            ->filter(function ($item) {
                return empty($item['roles'])
                    || (auth()->check() && auth()->user()->hasAnyRole($item['roles']));
            });
    @endphp

    @include('layouts.partials.connected-navigation')

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            @foreach ($menuItems as $item)
                <x-responsive-nav-link :href="url($item['href'])" :active="request()->is(ltrim($item['href'], '/'))">
                    {{ $item['label'] }}
                </x-responsive-nav-link>
            @endforeach
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="px-4 mb-2 flex items-center space-x-3 bg-gray-50 rounded-md p-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path d="M10 0a10 10 0 100 20A10 10 0 0010 0zm4.93 6.588a8 8 0 01-1.28 6.352L10 15l-3.65-2.06A8 8 0 115.07 3.412L8 5l2 1 2 1 2 1 .93-.824z"/>
                </svg>
                <span class="text-sm text-gray-700">{{ __('languages.' . app()->getLocale()) }}</span>
                <form method="POST" action="{{ route('locale.change') }}" class="flex-1">
                    @csrf
                    <select name="locale" onchange="this.form.submit()" class="block w-full rounded-md border-gray-300 px-2 py-1 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition ease-in-out duration-150">
                        <option value="en" {{ app()->getLocale() === 'en' ? 'selected' : '' }}>{{ __('languages.en') }}</option>
                        <option value="fr" {{ app()->getLocale() === 'fr' ? 'selected' : '' }}>{{ __('languages.fr') }}</option>
                        <option value="es" {{ app()->getLocale() === 'es' ? 'selected' : '' }}>{{ __('languages.es') }}</option>
                    </select>
                </form>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
