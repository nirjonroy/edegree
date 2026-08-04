@php
    $label = $label ?? 'Load More';
    $summary = $summary ?? true;
@endphp

@if ($paginator->hasPages())
    <div class="text-center mt-12" data-aos="fade-up">
        @if ($summary)
            <p class="text-xs text-mutedGray font-semibold mb-4">
                Showing {{ $paginator->firstItem() }}-{{ $paginator->lastItem() }} of {{ $paginator->total() }}
            </p>
        @endif

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="bg-white border border-borderGray hover:border-brand-red/50 text-ink hover:text-brand-red font-bold px-8 py-3 rounded-xl shadow-sm hover:shadow transition-all duration-150 text-sm inline-flex items-center space-x-2">
                <span>{{ $label }}</span>
                <i data-lucide="chevron-down" class="w-4 h-4"></i>
            </a>
        @else
            <span class="inline-flex items-center justify-center px-6 py-3 rounded-xl bg-altBg border border-borderGray text-xs font-bold text-mutedGray">
                No more results
            </span>
        @endif
    </div>
@endif
