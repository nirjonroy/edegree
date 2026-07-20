@if (isset($item['header']))
    <li class="nav-header">{{ $item['header'] }}</li>
@else
    <li class="nav-item {{ ! empty($item['open']) ? 'menu-open' : '' }}">
        <a href="{{ $item['url'] ?? '#' }}" class="nav-link {{ ! empty($item['active']) ? 'active' : '' }}">
            <i class="nav-icon bi {{ $item['icon'] ?? 'bi-circle' }}{{ isset($item['icon_class']) ? ' '.$item['icon_class'] : '' }}"></i>
            <p class="{{ $item['text_class'] ?? '' }}">
                {{ $item['label'] }}
                @isset($item['badge'])
                    <span class="nav-badge badge {{ $item['badge_class'] ?? 'text-bg-secondary' }} me-3">{{ $item['badge'] }}</span>
                @endisset
                @if (! empty($item['children']))
                    <i class="nav-arrow bi bi-chevron-right"></i>
                @endif
            </p>
        </a>

        @if (! empty($item['children']))
            <ul class="nav nav-treeview">
                @foreach ($item['children'] as $item)
                    @include('admin.partials.sidebar-menu-item', ['item' => $item])
                @endforeach
            </ul>
        @endif
    </li>
@endif
