@props(['items', 'level' => 0, 'mobile' => false])

@foreach ($items as $item)
    @php
        $visible = empty($item['roles'])
            || (auth()->check() && auth()->user()->hasAnyRole($item['roles']));
    @endphp

    @if ($visible)
        <div class="mb-1" style="margin-left: {{ $level * 1.0 }}rem;">
            @if (!empty($item['children']))
                <details class="space-y-1">
                    <summary class="flex items-center justify-between px-2 py-2 rounded-md text-sm font-medium text-left text-gray-700 hover:bg-gray-100 cursor-pointer list-none">
                        <span>{{ $item['label'] }}</span>
                        <span class="text-gray-500">▸</span>
                    </summary>
                    <div class="space-y-1">
                        @include('layouts.partials.sidebar-menu-items', ['items' => $item['children'], 'level' => $level + 1, 'mobile' => $mobile])
                    </div>
                </details>
            @else
                <a href="{{ url($item['href']) }}" class="block w-full px-2 py-2 rounded-md text-sm font-medium text-left {{ $level === 0 ? 'text-gray-700 hover:bg-gray-100' : 'text-gray-600 hover:bg-gray-50' }}">
                    {{ $item['label'] }}
                </a>
            @endif
        </div>
    @endif
@endforeach
