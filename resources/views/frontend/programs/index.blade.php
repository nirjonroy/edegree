@extends('frontend.layout')

@section('title', 'Explore Programs | eDegree+')
@section('meta_description', 'Browse accredited online degree programs including MBA, DBA, Master and Bachelor programs. Filter by level, domain and university.')
@section('seos')
    @include('frontend.partials.seos', ['seo' => [
        'title' => 'Explore Programs | eDegree+',
        'description' => 'Browse accredited online degree programs including MBA, DBA, Master and Bachelor programs. Filter by level, domain and university.',
        'url' => route('frontend.programs.index'),
    ]])
@endsection

@section('content')
    <section class="bg-altBg py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-10 text-left" data-aos="fade-up">
                <nav class="flex mb-3 text-xs font-semibold uppercase tracking-wider text-mutedGray space-x-2">
                    <a href="{{ route('frontend.home') }}" class="hover:text-brand-red">Home</a>
                    <span>/</span>
                    <span class="text-ink">Programs</span>
                </nav>
                <h1 class="font-heading font-bold text-3xl md:text-4xl text-ink tracking-tight">Explore Degree Programs</h1>
                <p class="text-charcoal mt-1 text-sm md:text-base">Compare and select accredited, fully-online Bachelor, Master, MBA, and DBA program options.</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <aside class="lg:col-span-3 lg:sticky lg:top-24 bg-white p-6 border border-borderGray rounded-custom shadow-sm h-fit space-y-6" data-aos="fade-right">
                    <form method="GET" action="{{ route('frontend.programs.index') }}" class="space-y-6">
                        <div>
                            <h3 class="font-heading font-bold text-sm text-ink mb-3 uppercase tracking-wider">Search Keywords</h3>
                            <div class="relative">
                                <input type="text" name="query" value="{{ $query }}" placeholder="Type keywords..."
                                       class="w-full pl-10 pr-3 py-2 bg-altBg border border-borderGray rounded-lg text-sm text-charcoal focus:ring-2 focus:ring-brand-red focus:outline-none">
                                <i data-lucide="search" class="w-4 h-4 text-mutedGray absolute left-3 top-1/2 -translate-y-1/2"></i>
                            </div>
                        </div>

                        <div>
                            <h3 class="font-heading font-bold text-sm text-ink mb-3 uppercase tracking-wider">Degree Levels</h3>
                            <div class="space-y-2">
                                <label class="flex items-center space-x-2.5 text-sm text-charcoal cursor-pointer">
                                    <input type="radio" name="degree" value="" @checked($selectedDegree === '') class="text-brand-red focus:ring-brand-red border-borderGray rounded-full">
                                    <span>All Degrees</span>
                                </label>
                                @foreach ($programCategories as $degree)
                                    <label class="flex items-center space-x-2.5 text-sm text-charcoal cursor-pointer">
                                        <input type="radio" name="degree" value="{{ $degree->name }}" @checked($selectedDegree === $degree->name) class="text-brand-red focus:ring-brand-red border-borderGray rounded-full">
                                        <span>{{ $degree->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div>
                            <h3 class="font-heading font-bold text-sm text-ink mb-3 uppercase tracking-wider">Universities</h3>
                            <select name="university" class="w-full px-3 py-2 bg-altBg border border-borderGray rounded-lg text-sm text-charcoal focus:ring-2 focus:ring-brand-red focus:outline-none">
                                <option value="">All Universities</option>
                                @foreach ($filterUniversities as $university)
                                    <option value="{{ $university->slug }}" @selected($selectedUniversity === $university->slug)>{{ $university->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-2 gap-3 pt-4 border-t border-borderGray">
                            <a href="{{ route('frontend.programs.index') }}" class="text-center text-xs font-bold text-brand-red hover:text-brand-darkRed py-2 bg-brand-tint rounded-lg transition-colors">Reset</a>
                            <button type="submit" class="text-center text-xs font-bold text-white py-2 bg-brand-red hover:bg-brand-darkRed rounded-lg transition-colors">Apply</button>
                        </div>
                    </form>
                </aside>

                <section class="lg:col-span-9 space-y-6">
                    <div class="flex justify-between items-center bg-white px-5 py-3 border border-borderGray rounded-lg text-sm text-charcoal" data-aos="fade-up">
                        <div>
                            Showing <span class="font-bold text-ink">{{ $programsPage->total() }}</span> programs
                        </div>
                        <div class="flex items-center space-x-2 text-xs font-semibold text-mutedGray">
                            <span class="w-2.5 h-2.5 rounded-full bg-brand-successGreen"></span>
                            <span>100% Accredited Partners Only</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @forelse ($programsPage as $program)
                            @php
                                $imagePath = $program->image ?: $program->university?->image_1;
                                $image = \App\Support\FrontendMedia::image($imagePath);
                                $logo = \App\Support\FrontendMedia::image($program->university?->image_1, \App\Support\FrontendMedia::LOGO_FALLBACK);
                                $programUrl = route('frontend.programs.show', $program->slug);
                                $applyUrl = $program->link ?: $programUrl;
                            @endphp
                            <article class="bg-white border border-borderGray rounded-custom overflow-hidden shadow-sm hover:shadow-lg transition-all flex flex-col h-full justify-between card-hover-lift" data-aos="fade-up">
                                <div class="flex-grow flex flex-col justify-between">
                                    <div class="relative h-44 bg-altBg overflow-hidden flex-shrink-0">
                                        <a href="{{ $programUrl }}" class="block w-full h-full" aria-label="View {{ $program->program }}">
                                            <img src="{{ $image }}" alt="{{ $program->program }}" class="w-full h-full object-cover">
                                        </a>
                                        <span class="absolute top-4 left-4 bg-white/95 px-2.5 py-0.5 rounded-full text-[10px] font-bold tracking-wider text-brand-red uppercase shadow-sm border border-brand-tint">
                                            {{ $program->degree?->name ?? $program->type ?? 'Program' }}
                                        </span>
                                        <span class="absolute top-4 right-4 text-[10px] font-bold text-white px-2.5 py-1 rounded-full shadow-md border border-white/20 {{ $program->recommend ? 'bg-brand-warningGold' : 'bg-brand-successGreen' }}">
                                            {{ $program->recommend ? 'Popular' : 'Accredited' }}
                                        </span>
                                    </div>

                                    <div class="p-6 flex-grow flex flex-col justify-between">
                                        <div>
                                            <div class="flex items-center space-x-2 mb-2">
                                                <img src="{{ $logo }}" alt="University Logo" class="w-4 h-4 rounded-full object-cover">
                                                <span class="text-xs font-bold text-mutedGray">{{ $program->university?->name ?? 'Partner University' }}</span>
                                            </div>
                                            <h3 class="font-heading font-bold text-base text-ink mb-3 leading-snug">
                                                <a href="{{ $programUrl }}" class="hover:text-brand-red transition-colors">{{ $program->program }}</a>
                                            </h3>
                                        </div>

                                        <div class="mt-auto border-t border-b border-borderGray/50 py-3">
                                            <div class="flex justify-between items-center text-xs text-charcoal">
                                                <div class="flex items-center space-x-1.5">
                                                    <i data-lucide="clock" class="w-3.5 h-3.5 text-brand-red flex-shrink-0"></i>
                                                    <span>{{ $program->duration ?: 'Flexible' }}</span>
                                                </div>
                                                <div class="flex items-center space-x-1.5">
                                                    <i data-lucide="credit-card" class="w-3.5 h-3.5 text-brand-red flex-shrink-0"></i>
                                                    <span class="text-base font-extrabold text-brand-red">{{ $program->total_fee ?: 'Contact' }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-altBg/50 border-t border-borderGray/40 px-6 py-4 flex items-center justify-between flex-shrink-0">
                                    <a href="{{ $programUrl }}" class="text-brand-red text-xs font-bold hover:text-brand-darkRed inline-flex items-center">
                                        <span>View Curriculum</span>
                                        <i data-lucide="arrow-right" class="w-3.5 h-3.5 ml-1"></i>
                                    </a>
                                    <a href="{{ $applyUrl }}" class="bg-brand-red hover:bg-brand-darkRed text-white px-5 py-2 rounded-lg text-xs font-bold transition-all duration-150 shadow">
                                        Apply Online
                                    </a>
                                </div>
                            </article>
                        @empty
                            <div class="md:col-span-2 bg-white p-12 text-center rounded-custom border border-borderGray" data-aos="fade-up">
                                <i data-lucide="alert-circle" class="w-12 h-12 text-mutedGray mx-auto mb-4"></i>
                                <h3 class="font-heading font-bold text-ink text-lg mb-1">No Matching Programs Found</h3>
                                <p class="text-sm text-charcoal">Try resetting filters or add programs from the admin panel.</p>
                            </div>
                        @endforelse
                    </div>

                    @include('frontend.partials.load-more-pagination', [
                        'paginator' => $programsPage,
                        'label' => 'Load More Programs',
                    ])
                </section>
            </div>
        </div>
    </section>
@endsection
