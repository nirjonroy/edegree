@php
    $logo = \App\Support\FrontendMedia::image($siteinfo?->logo, 'frontend/assets/img/edegree-plus-logo.png');
    $featuredProgram = isset($popularPrograms) ? $popularPrograms->first() : null;
@endphp

<header class="sticky top-0 z-50 bg-white border-b border-borderGray transition-all duration-300" :class="{ 'shadow-md': $store.global.isScrolled }" x-data="{ mobileMenuOpen: false, megaMenuOpen: false, companyDropdownOpen: false }">
    <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20 items-center">
            <a href="{{ route('frontend.home') }}" class="flex items-center">
                <img src="{{ $logo }}" alt="eDegree+" class="h-10 w-auto" @if (! empty($siteinfo?->logo_width)) style="width: {{ (int) $siteinfo->logo_width }}px; height: auto;" @endif>
            </a>

            <div class="hidden lg:flex space-x-8 items-center h-full">
                <div class="relative h-full flex items-center" @mouseenter="megaMenuOpen = true" @mouseleave="megaMenuOpen = false">
                    <button class="flex items-center space-x-1 text-ink font-medium hover:text-brand-red transition-colors duration-150 py-4 focus:outline-none">
                        <span>Programs</span>
                        <i data-lucide="chevron-down" class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': megaMenuOpen }"></i>
                    </button>
                    <div class="absolute left-1/2 -translate-x-1/2 top-full w-[800px] bg-white border border-borderGray shadow-2xl rounded-custom overflow-hidden transition-all duration-200"
                         x-show="megaMenuOpen" x-transition style="display: none;">
                        <div class="grid grid-cols-12 p-6 gap-6">
                            <div class="col-span-4">
                                <p class="font-heading font-bold text-ink uppercase tracking-wider text-xs mb-3">By Degree Level</p>
                                <ul class="space-y-2">
                                    @forelse ($programCategories ?? [] as $category)
                                        <li><a href="{{ route('frontend.programs.index', ['degree' => $category->name]) }}" class="text-charcoal text-sm hover:text-brand-red transition-colors duration-150 block py-1">{{ $category->name }}</a></li>
                                    @empty
                                        <li><a href="{{ route('frontend.programs.index', ['degree' => 'MBA']) }}" class="text-charcoal text-sm hover:text-brand-red transition-colors duration-150 block py-1">MBA Programs</a></li>
                                        <li><a href="{{ route('frontend.programs.index', ['degree' => 'DBA']) }}" class="text-charcoal text-sm hover:text-brand-red transition-colors duration-150 block py-1">DBA Doctorates</a></li>
                                        <li><a href="{{ route('frontend.programs.index', ['degree' => "Master's"]) }}" class="text-charcoal text-sm hover:text-brand-red transition-colors duration-150 block py-1">Master's Degrees</a></li>
                                        <li><a href="{{ route('frontend.programs.index', ['degree' => "Bachelor's"]) }}" class="text-charcoal text-sm hover:text-brand-red transition-colors duration-150 block py-1">Bachelor's Degrees</a></li>
                                    @endforelse
                                </ul>
                            </div>
                            <div class="col-span-4 border-l border-borderGray pl-6">
                                <p class="font-heading font-bold text-ink uppercase tracking-wider text-xs mb-3">Universities</p>
                                <ul class="space-y-2">
                                    @forelse (($universities ?? collect())->take(4) as $university)
                                        <li><a href="{{ route('frontend.universities.show', $university->slug) }}" class="text-charcoal text-sm hover:text-brand-red transition-colors duration-150 block py-1">{{ $university->name }}</a></li>
                                    @empty
                                        <li><a href="{{ route('frontend.universities.index') }}" class="text-charcoal text-sm hover:text-brand-red transition-colors duration-150 block py-1">Partner Universities</a></li>
                                    @endforelse
                                </ul>
                            </div>
                            <div class="col-span-4 bg-brand-tint rounded-lg p-4 flex flex-col justify-between">
                                <div>
                                    <span class="inline-block bg-brand-red text-white text-[10px] uppercase font-bold tracking-wider px-2 py-0.5 rounded-full mb-2">Featured</span>
                                    {{-- <p class="font-heading font-bold text-ink text-sm mb-1 leading-snug">{{ $featuredProgram?->program ?? 'Doctor of Business Administration (DBA)' }}</p> --}}
                                    <p class="text-xs text-mutedGray leading-relaxed">{{ $featuredProgram?->short_description ?? 'Advance to top-tier leadership roles with accredited online study pathways.' }}</p>
                                </div>
                                <a href="{{ route('frontend.programs.index') }}" class="mt-4 text-brand-red text-xs font-bold hover:text-brand-darkRed inline-flex items-center">
                                    <span>View Programs</span>
                                    <i data-lucide="arrow-right" class="w-3 h-3 ml-1"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <a href="{{ route('frontend.universities.index') }}" class="text-ink font-medium hover:text-brand-red transition-colors duration-150 py-4">Universities</a>
                <a href="{{ route('frontend.blog.index') }}" class="text-ink font-medium hover:text-brand-red transition-colors duration-150 py-4">Blog</a>
                <a href="{{ route('frontend.news.index') }}" class="text-ink font-medium hover:text-brand-red transition-colors duration-150 py-4">News</a>

                <div class="relative h-full flex items-center" @mouseenter="companyDropdownOpen = true" @mouseleave="companyDropdownOpen = false">
                    <button class="flex items-center space-x-1 text-ink font-medium hover:text-brand-red transition-colors duration-150 py-4 focus:outline-none">
                        <span>Company</span>
                        <i data-lucide="chevron-down" class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': companyDropdownOpen }"></i>
                    </button>
                    <div class="absolute right-0 top-full w-48 bg-white border border-borderGray shadow-xl rounded-lg overflow-hidden transition-all duration-200"
                         x-show="companyDropdownOpen" x-transition style="display: none;">
                        <ul class="py-1">
                            <li><a href="{{ route('frontend.about') }}" class="px-4 py-2 text-charcoal text-sm hover:bg-brand-tint hover:text-brand-red block">About Us</a></li>
                            <li><a href="{{ route('frontend.privacy-policy') }}" class="px-4 py-2 text-charcoal text-sm hover:bg-brand-tint hover:text-brand-red block">Privacy Policy</a></li>
                            <li><a href="{{ route('frontend.terms') }}" class="px-4 py-2 text-charcoal text-sm hover:bg-brand-tint hover:text-brand-red block">Terms of Service</a></li>
                            <li><a href="{{ route('frontend.sitemap.page') }}" class="px-4 py-2 text-charcoal text-sm hover:bg-brand-tint hover:text-brand-red block">Sitemap</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="hidden lg:flex items-center space-x-4">
                <button @click="$store.global.toggleSearchModal()" class="text-charcoal hover:text-brand-red transition-colors duration-150 p-2 rounded-full focus:outline-none">
                    <i data-lucide="search" class="w-6 h-6"></i>
                </button>
                <a href="{{ route('frontend.programs.index') }}" class="bg-brand-red hover:bg-brand-darkRed text-white px-5 py-2.5 rounded-lg text-sm font-semibold tracking-wide shadow-sm hover:shadow transition-all duration-150">
                    Explore Programs
                </a>
            </div>

            <div class="lg:hidden flex items-center space-x-3">
                <button @click="$store.global.toggleSearchModal()" class="text-charcoal hover:text-brand-red p-2 focus:outline-none">
                    <i data-lucide="search" class="w-6 h-6"></i>
                </button>
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-charcoal hover:text-brand-red p-2 focus:outline-none">
                    <i data-lucide="menu" class="w-6 h-6" x-show="!mobileMenuOpen"></i>
                    <i data-lucide="x" class="w-6 h-6" x-show="mobileMenuOpen" style="display: none;"></i>
                </button>
            </div>
        </div>
    </nav>

    <div class="lg:hidden fixed inset-0 z-40 flex" x-show="mobileMenuOpen" style="display: none;">
        <div class="fixed inset-0 bg-black bg-opacity-50" @click="mobileMenuOpen = false"></div>
        <div class="fixed inset-y-0 right-0 max-w-xs w-full bg-white shadow-xl flex flex-col z-50 p-6 overflow-y-auto" x-show="mobileMenuOpen" x-transition>
            <div class="flex justify-between items-center mb-8">
                <a href="{{ route('frontend.home') }}"><img src="{{ $logo }}" alt="eDegree+" class="h-9 w-auto" @if (! empty($siteinfo?->logo_width)) style="width: {{ (int) $siteinfo->logo_width }}px; height: auto;" @endif></a>
                <button @click="mobileMenuOpen = false" class="text-charcoal hover:text-brand-red focus:outline-none"><i data-lucide="x" class="w-6 h-6"></i></button>
            </div>
            <div class="flex flex-col space-y-6">
                <a href="{{ route('frontend.programs.index') }}" class="text-ink font-semibold hover:text-brand-red block border-b border-borderGray/40 pb-4">Programs</a>
                <a href="{{ route('frontend.universities.index') }}" class="text-ink font-semibold hover:text-brand-red block border-b border-borderGray/40 pb-4">Universities</a>
                <a href="{{ route('frontend.blog.index') }}" class="text-ink font-semibold hover:text-brand-red block border-b border-borderGray/40 pb-4">Blog</a>
                <a href="{{ route('frontend.news.index') }}" class="text-ink font-semibold hover:text-brand-red block border-b border-borderGray/40 pb-4">News</a>
                <a href="{{ route('frontend.about') }}" class="text-ink font-semibold hover:text-brand-red block border-b border-borderGray/40 pb-4">About Us</a>
                <a href="{{ route('frontend.privacy-policy') }}" class="text-ink font-semibold hover:text-brand-red block border-b border-borderGray/40 pb-4">Privacy Policy</a>
                <a href="{{ route('frontend.terms') }}" class="text-ink font-semibold hover:text-brand-red block border-b border-borderGray/40 pb-4">Terms of Service</a>
                <a href="{{ route('frontend.sitemap.page') }}" class="text-ink font-semibold hover:text-brand-red block border-b border-borderGray/40 pb-4">Sitemap</a>
                <a href="{{ route('frontend.programs.index') }}" class="w-full text-center bg-brand-red hover:bg-brand-darkRed text-white block py-3 rounded-lg text-sm font-semibold shadow-sm transition-all duration-150">Explore Programs</a>
            </div>
        </div>
    </div>
</header>
