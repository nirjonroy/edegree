@extends('frontend.layout')

@section('title', 'Partner Universities | eDegree+')
@section('meta_description', 'Explore eDegree+ partner universities offering accredited online MBA, Master, Bachelor and doctorate programs.')

@section('content')
    <section class="bg-altBg py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-10 text-left" data-aos="fade-up">
                <nav class="flex mb-3 text-xs font-semibold uppercase tracking-wider text-mutedGray space-x-2">
                    <a href="{{ route('frontend.home') }}" class="hover:text-brand-red">Home</a>
                    <span>/</span>
                    <span class="text-ink">Universities</span>
                </nav>
                <h1 class="font-heading font-bold text-3xl md:text-4xl text-ink tracking-tight">Partner Universities</h1>
                <p class="text-charcoal mt-1 text-sm md:text-base">Acquire accredited global degrees from leading institutions partnering with eDegree+.</p>
            </div>

            <form method="GET" action="{{ route('frontend.universities.index') }}" class="bg-white p-5 border border-borderGray rounded-custom shadow-sm mb-8 flex flex-col md:flex-row gap-4 items-center justify-between" data-aos="fade-up">
                <div class="relative w-full md:max-w-md">
                    <input type="text" name="query" value="{{ $query }}" placeholder="Search by name, location or accreditation..."
                           class="w-full pl-10 pr-4 py-2.5 bg-altBg border border-borderGray rounded-lg text-sm text-charcoal focus:ring-2 focus:ring-brand-red focus:outline-none">
                    <i data-lucide="search" class="w-4 h-4 text-mutedGray absolute left-3.5 top-1/2 -translate-y-1/2"></i>
                </div>
                <div class="flex items-center gap-3">
                    <div class="hidden md:flex items-center space-x-2 text-xs font-semibold text-mutedGray">
                        <i data-lucide="shield-check" class="w-4 h-4 text-brand-successGreen"></i>
                        <span>Accredited university partners</span>
                    </div>
                    <button type="submit" class="bg-brand-red hover:bg-brand-darkRed text-white px-5 py-2.5 rounded-lg text-sm font-bold">Search</button>
                </div>
            </form>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse ($universitiesPage as $university)
                    @php
                        $image = $university->image_1
                            ? (\Illuminate\Support\Str::startsWith($university->image_1, ['http://', 'https://']) ? $university->image_1 : asset($university->image_1))
                            : 'https://images.unsplash.com/photo-1562774053-701939374585?w=800&h=500&fit=crop&q=80';
                    @endphp
                    <article class="bg-white border border-borderGray rounded-custom overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col justify-between card-hover-lift" data-aos="fade-up">
                        <div>
                            <div class="h-44 bg-altBg overflow-hidden relative">
                                <img src="{{ $image }}" alt="{{ $university->name }}" class="w-full h-full object-cover">
                                <div class="absolute bottom-4 left-4 bg-white/95 px-3 py-1.5 rounded-lg shadow flex items-center space-x-2 border border-brand-tint">
                                    <span class="text-xs font-bold text-ink">{{ \Illuminate\Support\Str::limit($university->name, 22) }}</span>
                                </div>
                            </div>

                            <div class="p-6">
                                <h3 class="font-heading font-bold text-lg text-ink mb-2 leading-snug">
                                    <a href="{{ route('frontend.universities.show', $university->slug) }}" class="hover:text-brand-red transition">{{ $university->name }}</a>
                                </h3>
                                <div class="flex items-center text-xs text-mutedGray font-medium mb-4">
                                    <i data-lucide="map-pin" class="w-3.5 h-3.5 text-brand-red mr-1"></i>
                                    <span>{{ $university->location ?: 'Global Online' }}</span>
                                </div>
                                <p class="text-xs text-charcoal leading-relaxed line-clamp-3">
                                    {{ $university->short_description ?: \Illuminate\Support\Str::limit(strip_tags($university->long_description ?: $university->profile_description), 180) }}
                                </p>
                            </div>
                        </div>

                        <div class="px-6 py-4 bg-altBg/50 border-t border-borderGray/40 flex items-center justify-between">
                            <a href="{{ route('frontend.universities.show', $university->slug) }}" class="text-brand-red text-xs font-bold hover:text-brand-darkRed inline-flex items-center">
                                <span>View Profile</span>
                                <i data-lucide="arrow-right" class="w-3.5 h-3.5 ml-1"></i>
                            </a>
                            <span class="text-xs font-bold text-mutedGray">{{ $university->programs_count }} Programs</span>
                        </div>
                    </article>
                @empty
                    <div class="lg:col-span-3 bg-white p-12 text-center rounded-custom border border-borderGray">
                        <i data-lucide="alert-circle" class="w-12 h-12 text-mutedGray mx-auto mb-4"></i>
                        <h3 class="font-heading font-bold text-ink text-lg mb-1">No Universities Found</h3>
                        <p class="text-sm text-charcoal">Try another search term or add universities from the admin panel.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-10">
                {{ $universitiesPage->links() }}
            </div>
        </div>
    </section>
@endsection
