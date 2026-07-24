@php
    $programImage = $program->university?->image_1
        ? (\Illuminate\Support\Str::startsWith($program->university->image_1, ['http://', 'https://']) ? $program->university->image_1 : asset($program->university->image_1))
        : 'https://images.unsplash.com/photo-1434030216411-0b793f4b4173?w=600&h=400&fit=crop&q=80';
    $programUrl = $program->link ?: url('/frontend/program-single.html?id='.($program->slug ?: $program->id));
    $universityLogo = $program->university?->image_1
        ? (\Illuminate\Support\Str::startsWith($program->university->image_1, ['http://', 'https://']) ? $program->university->image_1 : asset($program->university->image_1))
        : 'https://images.unsplash.com/photo-1562774053-701939374585?w=120&h=120&fit=crop&q=80';
@endphp

<article class="bg-white border border-borderGray rounded-custom overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col h-full card-hover-lift" data-aos="fade-up">
    <div class="relative h-48 bg-altBg overflow-hidden">
        <img src="{{ $programImage }}" alt="{{ $program->program }}" class="w-full h-full object-cover">
        <span class="absolute top-4 left-4 bg-white/95 px-3 py-1 rounded-full text-[10px] font-bold tracking-wider text-brand-red uppercase shadow-sm border border-brand-tint">
            {{ $program->degree?->name ?? $program->type ?? 'Program' }}
        </span>
        <span class="absolute top-4 right-4 text-[10px] font-bold text-white px-2.5 py-1 rounded-full shadow-md bg-brand-successGreen border border-white/20">Accredited</span>
    </div>

    <div class="p-6 flex-grow flex flex-col justify-between">
        <div>
            <div class="flex items-center space-x-2 mb-3">
                <img src="{{ $universityLogo }}" alt="University Logo" class="w-5 h-5 rounded-full object-cover">
                <span class="text-xs font-bold tracking-wide text-mutedGray">{{ $program->university?->name ?? 'Partner University' }}</span>
            </div>
            <h3 class="font-heading font-bold text-base md:text-lg text-ink mb-3 leading-snug">
                <a href="{{ $programUrl }}" class="hover:text-brand-red transition-colors">{{ $program->program }}</a>
            </h3>
        </div>

        <div class="mt-auto w-full">
            <div class="flex justify-between items-center border-t border-b border-borderGray/60 py-3 mb-4">
                <div class="flex items-center space-x-1.5 text-xs text-charcoal">
                    <i data-lucide="clock" class="w-4 h-4 text-brand-red flex-shrink-0"></i>
                    <span class="font-semibold">{{ $program->duration ?: 'Flexible' }}</span>
                </div>
                <div class="flex items-center space-x-1.5 text-xs text-charcoal justify-end">
                    <i data-lucide="credit-card" class="w-4 h-4 text-brand-red flex-shrink-0"></i>
                    <span class="text-base font-extrabold text-brand-red">{{ $program->total_fee ?: 'Contact' }}</span>
                </div>
            </div>

            <div class="flex items-center justify-between gap-2">
                <a href="{{ $programUrl }}" class="text-brand-red text-xs font-bold hover:text-brand-darkRed inline-flex items-center">
                    <span>View Curriculum</span>
                    <i data-lucide="arrow-right" class="w-3.5 h-3.5 ml-1"></i>
                </a>
                <a href="{{ $programUrl }}#inquiry-form" class="bg-brand-red hover:bg-brand-darkRed text-white px-4 py-2 rounded-lg text-xs font-bold shadow hover:shadow-md transition-all duration-150 whitespace-nowrap">
                    Apply Online
                </a>
            </div>
        </div>
    </div>
</article>
