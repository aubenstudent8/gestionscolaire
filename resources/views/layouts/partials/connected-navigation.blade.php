<div class="w-full px-0" style="position:relative;">
    <div style="display:flex; align-items:center; justify-content:space-between; gap:1rem; flex-wrap:wrap; width:100%; padding:0.75rem;">
        <div style="display:flex; align-items:center; gap:1rem; flex-wrap:wrap;">
            <a href="{{ route('dashboard') }}">
                <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
            </a>
        </div>

        <div style="display:flex; align-items:center; gap:0.75rem; flex-wrap:wrap;">
            <form method="POST" action="{{ route('locale.change') }}" class="flex items-center">
                @csrf
                <select name="locale" onchange="this.form.submit()" class="form-select rounded-md border-gray-300 px-2 py-1 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition ease-in-out duration-150">
                    <option value="en" {{ app()->getLocale() === 'en' ? 'selected' : '' }}>{{ __('languages.en') }}</option>
                    <option value="fr" {{ app()->getLocale() === 'fr' ? 'selected' : '' }}>{{ __('languages.fr') }}</option>
                    <option value="es" {{ app()->getLocale() === 'es' ? 'selected' : '' }}>{{ __('languages.es') }}</option>
                </select>
            </form>
            @auth
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-sm font-medium text-gray-700 hover:bg-gray-100 rounded-md px-3 py-2">
                        Déconnexion
                    </button>
                </form>
            @endauth
        </div>
    </div>
</div>
