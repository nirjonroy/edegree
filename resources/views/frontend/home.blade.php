@extends('frontend.layout')

@section('title', $siteinfo?->homepage_section_title ?: 'eDegree+ | Accredited Online University Degree Programs')
@section('meta_description', 'Advance your career with internationally accredited online university degrees. Discover online MBA, DBA, Master and Bachelor programs from top global institutions.')

@php
    $heroImage = $slider?->image
        ? (\Illuminate\Support\Str::startsWith($slider->image, ['http://', 'https://']) ? $slider->image : asset($slider->image))
        : 'https://images.unsplash.com/photo-1541339907198-e08756dedf3f?q=80&w=1170&auto=format&fit=crop';
    $heroBadge = $slider?->badge_text ?: 'Accredited Global Partners';
    $heroTitle = $slider?->title ?: 'Advance Your Career with Accredited Online University Degrees';
    $heroSubtitle = $slider?->subtitle ?: "Secure recognized MBA, DBA, Master's, and Bachelor's programs without career disruption. 100% online schedules curated for working professionals.";
    $primaryTab = $slider?->primary_tab_text ?: 'Find a Program';
    $secondaryTab = $slider?->secondary_tab_text ?: 'Find a University';
    $searchPlaceholder = $slider?->search_placeholder ?: 'Search course names, domains or keywords...';
    $buttonText = $slider?->button_text ?: 'Search';
@endphp

@section('content')
    <section class="relative bg-ink text-white py-20 md:py-32 overflow-hidden">
        <div class="absolute inset-0 z-0">
            <img src="{{ $heroImage }}" alt="Online Degree Campus" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-black/70 z-10"></div>
        </div>

        <div class="relative z-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl" data-aos="fade-right">
                <span class="inline-flex items-center space-x-1.5 bg-brand-red/25 text-brand-tint border border-brand-red/45 px-3 py-1 rounded-full text-xs font-semibold mb-6">
                    <span class="w-2 h-2 rounded-full bg-brand-red animate-pulse"></span>
                    <span>{{ $heroBadge }}</span>
                </span>
                <h1 class="font-heading font-bold text-4xl md:text-5xl lg:text-6xl text-white mb-6 leading-tight">{{ $heroTitle }}</h1>
                <p class="text-lg md:text-xl text-brand-tint/90 mb-8 leading-relaxed font-light">{{ $heroSubtitle }}</p>

                <div class="bg-white p-6 rounded-custom shadow-2xl text-ink" x-data="homePage()">
                    <div class="flex p-1 bg-altBg border border-borderGray rounded-xl mb-4 w-fit">
                        <button type="button" @click="searchType = 'program'" class="px-4 py-2 text-xs font-bold rounded-lg transition-all duration-200" :class="searchType === 'program' ? 'bg-brand-red text-white shadow-sm' : 'text-charcoal hover:text-brand-red'">
                            {{ $primaryTab }}
                        </button>
                        <button type="button" @click="searchType = 'university'" class="px-4 py-2 text-xs font-bold rounded-lg transition-all duration-200" :class="searchType === 'university' ? 'bg-brand-red text-white shadow-sm' : 'text-charcoal hover:text-brand-red'">
                            {{ $secondaryTab }}
                        </button>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4" x-show="searchType === 'program'">
                        <div class="md:col-span-10 relative">
                            <i data-lucide="search" class="absolute left-4 top-1/2 -translate-y-1/2 text-mutedGray w-5 h-5"></i>
                            <input type="text" placeholder="{{ $searchPlaceholder }}" x-model="query" class="w-full pl-12 pr-4 py-3 bg-altBg border border-borderGray rounded-xl text-ink text-sm focus:ring-2 focus:ring-brand-red focus:border-transparent focus:outline-none transition duration-150">
                        </div>
                        <div class="md:col-span-2">
                            <button @click="submitSearch()" class="w-full bg-brand-red hover:bg-brand-darkRed text-white py-3 rounded-xl font-bold shadow-md hover:shadow-lg transition-colors duration-150 text-sm">{{ $buttonText }}</button>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4" x-show="searchType === 'university'" style="display: none;">
                        <div class="md:col-span-10 relative">
                            <i data-lucide="search" class="absolute left-4 top-1/2 -translate-y-1/2 text-mutedGray w-5 h-5"></i>
                            <input type="text" placeholder="Search university names or location..." x-model="query" class="w-full pl-12 pr-4 py-3 bg-altBg border border-borderGray rounded-xl text-ink text-sm focus:ring-2 focus:ring-brand-red focus:border-transparent focus:outline-none transition duration-150">
                        </div>
                        <div class="md:col-span-2">
                            <button @click="submitSearch()" class="w-full bg-brand-red hover:bg-brand-darkRed text-white py-3 rounded-xl font-bold shadow-md hover:shadow-lg transition-colors duration-150 text-sm">{{ $buttonText }}</button>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-3 gap-6 mt-10 pt-8 border-t border-white/10 text-white">
                    <div>
                        <div class="text-2xl md:text-3xl font-heading font-bold text-brand-red">{{ $universities->count() ?: '50+' }}</div>
                        <div class="text-xs md:text-sm text-brand-tint/70">Partner Universities</div>
                    </div>
                    <div>
                        <div class="text-2xl md:text-3xl font-heading font-bold text-brand-red">100%</div>
                        <div class="text-xs md:text-sm text-brand-tint/70">Accredited Online</div>
                    </div>
                    <div>
                        <div class="text-2xl md:text-3xl font-heading font-bold text-brand-red">{{ $programs->count() ?: '10k+' }}</div>
                        <div class="text-xs md:text-sm text-brand-tint/70">Available Programs</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-16 md:py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16" data-aos="fade-up">
                <span class="bg-brand-tint border border-brand-red/30 px-3 py-1 rounded-full text-xs font-bold text-brand-red uppercase tracking-wider">Top Tier Choice</span>
                <h2 class="font-heading font-bold text-3xl md:text-4xl text-ink tracking-tight mt-3 mb-4">Popular Degree Programs</h2>
                <p class="text-charcoal text-sm md:text-base">Acquire elite, career-ready qualifications from accredited university partners.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse ($popularPrograms as $program)
                    @include('frontend.partials.program-card', ['program' => $program])
                @empty
                    <div class="lg:col-span-3 bg-altBg border border-borderGray rounded-custom p-10 text-center text-charcoal">
                        No featured programs have been added yet.
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <section class="py-16 bg-altBg border-t border-b border-borderGray">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-12">
                <div data-aos="fade-up">
                    <h2 class="font-heading font-bold text-3xl text-ink tracking-tight mb-2">Browse Degrees by Level</h2>
                    <p class="text-charcoal text-sm">Select degree categories below to discover accredited online university curriculums.</p>
                </div>
                <div class="mt-6 md:mt-0 flex flex-wrap gap-2" data-aos="fade-up">
                    <a href="{{ route('frontend.programs.index') }}" class="px-4 py-2 rounded-full text-xs font-semibold tracking-wider transition-all duration-200 border bg-brand-red border-brand-red text-white">All Degrees</a>
                    @foreach ($programCategories as $category)
                        <a href="{{ route('frontend.programs.index', ['degree' => $category->name]) }}" class="px-4 py-2 rounded-full text-xs font-semibold tracking-wider transition-all duration-200 border bg-white border-borderGray text-charcoal hover:border-brand-red hover:text-brand-red">{{ $category->name }}</a>
                    @endforeach
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse ($programs as $program)
                    @include('frontend.partials.program-card', ['program' => $program])
                @empty
                    <div class="lg:col-span-3 bg-white border border-borderGray rounded-custom p-10 text-center text-charcoal">
                        No programs have been added yet.
                    </div>
                @endforelse
            </div>

            <div class="text-center mt-12" data-aos="fade-up">
                <a href="{{ route('frontend.programs.index') }}" class="inline-flex items-center space-x-2 bg-ink hover:bg-brand-red text-white px-8 py-3.5 rounded-lg font-semibold transition-all duration-200 shadow shadow-ink/20">
                    <span>Browse All Degrees</span>
                    <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </a>
            </div>
        </div>
    </section>

    <section class="py-16 md:py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-16" data-aos="fade-up">
                <h2 class="font-heading font-bold text-3xl text-ink tracking-tight mb-3">Your Journey to a Credible Degree</h2>
                <p class="text-charcoal text-sm md:text-base">Find accredited curricula, compare options, talk with advisors, and move into direct enrollment.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                @foreach ([['Explore Options', 'Search recognized graduate and executive degree structures filtered by levels and subjects.'], ['Compare Curricula', 'Check credentials, duration, fees, and study outcomes before applying.'], ['Speak to Advisors', 'Get professional counseling and qualification guidance before enrollment.'], ['Direct Enrollment', 'Submit files directly and begin studying through online delivery.']] as $step)
                    <div class="bg-altBg p-6 rounded-custom border border-borderGray shadow-sm text-center" data-aos="fade-up">
                        <div class="w-12 h-12 rounded-full bg-brand-tint text-brand-red flex items-center justify-center mx-auto mb-4 font-heading font-bold text-lg">{{ $loop->iteration }}</div>
                        <h3 class="font-heading font-bold text-base text-ink mb-2">{{ $step[0] }}</h3>
                        <p class="text-xs text-charcoal leading-relaxed">{{ $step[1] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="py-16 md:py-24 bg-altBg border-t border-b border-borderGray overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @php
                $testimonialSection = $homeSections->get('testimonials');
            @endphp
            <div class="text-center max-w-2xl mx-auto mb-16" data-aos="fade-up">
                <h2 class="font-heading font-bold text-3xl text-ink tracking-tight mb-3">{{ $testimonialSection?->title ?? 'Learner Testimonials' }}</h2>
                <p class="text-charcoal text-sm">{{ $testimonialSection?->subtitle ?? 'Hear from graduates who secured international qualifications while retaining their job roles.' }}</p>
            </div>
            <div class="swiper testimonial-swiper max-w-4xl mx-auto" data-aos="fade-up">
                <div class="swiper-wrapper">
                    @forelse ($homeTestimonials as $testimonial)
                        <div class="swiper-slide p-8 bg-white rounded-custom border border-borderGray flex flex-col justify-between h-auto">
                            <div>
                                <div class="flex items-center space-x-1 mb-4 text-brand-warningGold">
                                    @for ($i = 0; $i < max(1, min(5, (int) $testimonial->rating)); $i++)
                                        <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                                    @endfor
                                </div>
                                <p class="text-ink text-base md:text-lg italic leading-relaxed mb-6 font-light">"{{ $testimonial->quote }}"</p>
                            </div>
                            <div>
                                <h4 class="font-heading font-bold text-sm text-ink">{{ $testimonial->name }}</h4>
                                @if ($testimonial->designation)
                                    <p class="text-xs text-mutedGray">{{ $testimonial->designation }}</p>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="swiper-slide p-8 bg-white rounded-custom border border-borderGray h-auto">
                            <div class="flex items-center space-x-1 mb-4 text-brand-warningGold">
                                @for ($i = 0; $i < 5; $i++)
                                    <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                                @endfor
                            </div>
                            <p class="text-ink text-base md:text-lg italic leading-relaxed mb-6 font-light">"The online DBA provided research frameworks that directly improved my consultancy work."</p>
                            <h4 class="font-heading font-bold text-sm text-ink">Dr. Sarah Chen</h4>
                            <p class="text-xs text-mutedGray">Doctor of Business Administration Alum, GGU USA</p>
                        </div>
                    @endforelse
                </div>
                <div class="swiper-pagination mt-8 !relative"></div>
            </div>
        </div>
    </section>

    <section class="py-16 md:py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <div data-aos="fade-right">
                    <div class="flex justify-between items-end mb-8">
                        <h3 class="font-heading font-bold text-2xl text-ink tracking-tight">Education Insights</h3>
                        <a href="{{ route('frontend.blog.index') }}" class="text-brand-red text-xs font-bold hover:text-brand-darkRed flex items-center">View Blog <i data-lucide="arrow-right" class="w-3 h-3 ml-1"></i></a>
                    </div>
                    <div class="space-y-6">
                        @forelse ($blogPosts as $post)
                            <article class="bg-altBg/30 p-6 rounded-custom border border-borderGray shadow-sm hover:shadow transition flex space-x-4 h-36 items-center">
                                <img src="{{ $post->image ? asset($post->image) : 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=150&h=150&fit=crop&q=80' }}" alt="{{ $post->title }}" class="w-20 h-20 rounded-lg object-cover flex-shrink-0">
                                <div class="flex flex-col justify-between h-full py-1">
                                    <div>
                                        <span class="text-[9px] font-bold text-brand-red tracking-wider uppercase">{{ $post->category?->name ?? 'Education Insights' }}</span>
                                        <h4 class="font-heading font-bold text-sm text-ink mt-1 hover:text-brand-red transition line-clamp-2">
                                            <a href="{{ route('frontend.blog.show', $post->slug) }}">{{ $post->title }}</a>
                                        </h4>
                                    </div>
                                    <p class="text-[11px] text-mutedGray">{{ optional($post->published_at)->format('F d, Y') ?: $post->created_at->format('F d, Y') }}</p>
                                </div>
                            </article>
                        @empty
                            <div class="bg-altBg/30 p-6 rounded-custom border border-borderGray text-sm">No blog posts have been published yet.</div>
                        @endforelse
                    </div>
                </div>

                <div data-aos="fade-left">
                    <div class="flex justify-between items-end mb-8">
                        <h3 class="font-heading font-bold text-2xl text-ink tracking-tight">Admissions News</h3>
                        <a href="{{ route('frontend.news.index') }}" class="text-brand-red text-xs font-bold hover:text-brand-darkRed flex items-center">View News Archive <i data-lucide="arrow-right" class="w-3 h-3 ml-1"></i></a>
                    </div>
                    <div class="space-y-6">
                        @forelse ($newsItems as $news)
                            <article class="bg-altBg/30 p-6 rounded-custom border border-borderGray shadow-sm hover:shadow transition flex flex-col justify-between h-36">
                                <div>
                                    <div class="flex justify-between items-center mb-2 gap-4">
                                        <span class="text-[9px] font-bold text-brand-warningGold tracking-wider uppercase">{{ $news->category ?: 'Admissions News' }}</span>
                                        <span class="text-[10px] font-mono text-mutedGray font-semibold">{{ optional($news->published_at)->format('M d, Y') ?: $news->created_at->format('M d, Y') }}</span>
                                    </div>
                                    <h4 class="font-heading font-bold text-sm text-ink hover:text-brand-red transition line-clamp-2">
                                        <a href="{{ route('frontend.news.show', $news->slug) }}">{{ $news->title }}</a>
                                    </h4>
                                </div>
                                <p class="text-[11px] text-mutedGray mt-auto">{{ $news->short_description ?: 'Official Circular' }}</p>
                            </article>
                        @empty
                            <div class="bg-altBg/30 p-6 rounded-custom border border-borderGray text-sm">No news items have been published yet.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-16 bg-altBg border-t border-b border-borderGray overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @php
                $partnerSection = $homeSections->get('partners');
            @endphp
            <h3 class="text-center font-heading text-xs font-bold text-mutedGray uppercase tracking-widest mb-10">{{ $partnerSection?->title ?? 'Our Partner Universities & Accreditation Standards' }}</h3>
            <div class="swiper partner-swiper">
                <div class="swiper-wrapper items-center">
                    @if ($homePartners->isNotEmpty())
                        @foreach ($homePartners as $partner)
                            @php
                                $partnerImage = $partner->logo
                                    ? (\Illuminate\Support\Str::startsWith($partner->logo, ['http://', 'https://']) ? $partner->logo : asset($partner->logo))
                                    : asset('frontend/assets/img/edegree-plus-square-white-bg-logo.png');
                            @endphp
                            <div class="swiper-slide flex flex-col items-center justify-center grayscale opacity-60 hover:grayscale-0 hover:opacity-100 transition-all duration-300">
                                @if ($partner->link)
                                    <a href="{{ $partner->link }}" target="_blank" rel="noopener" class="flex flex-col items-center">
                                        <img src="{{ $partnerImage }}" alt="{{ $partner->name }}" class="w-12 h-12 rounded-full object-cover mb-2">
                                        <span class="font-heading font-bold text-xs text-ink text-center">{{ $partner->name }}</span>
                                    </a>
                                @else
                                    <img src="{{ $partnerImage }}" alt="{{ $partner->name }}" class="w-12 h-12 rounded-full object-cover mb-2">
                                    <span class="font-heading font-bold text-xs text-ink text-center">{{ $partner->name }}</span>
                                @endif
                            </div>
                        @endforeach
                    @else
                        @foreach ($universities as $university)
                            <div class="swiper-slide flex flex-col items-center justify-center grayscale opacity-60 hover:grayscale-0 hover:opacity-100 transition-all duration-300">
                                <img src="{{ $university->image_1 ? asset($university->image_1) : asset('frontend/assets/img/edegree-plus-square-white-bg-logo.png') }}" alt="{{ $university->name }}" class="w-12 h-12 rounded-full object-cover mb-2">
                                <span class="font-heading font-bold text-xs text-ink text-center">{{ $university->name }}</span>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </section>

    <section class="py-16 bg-brand-dark text-white relative" x-data="subscribeSection()">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @php
                $subscribeSection = $homeSections->get('subscribe');
            @endphp
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                <div class="lg:col-span-7" data-aos="fade-right">
                    <h2 class="font-heading font-bold text-2xl md:text-3xl text-white mb-2">{{ $subscribeSection?->title ?? 'Stay Ahead in Your Career' }}</h2>
                    <p class="text-sm text-brand-tint/70">{{ $subscribeSection?->subtitle ?? 'Subscribe to receive program alerts, scholarship updates, and university admissions deadlines.' }}</p>
                </div>
                <div class="lg:col-span-5" data-aos="fade-left">
                    <form @submit.prevent="submitSubscribe()" class="flex flex-col sm:flex-row gap-3">
                        <input type="email" placeholder="{{ $subscribeSection?->input_placeholder ?? 'Enter your work email' }}" x-model="email" class="flex-grow px-4 py-3 bg-white/10 border border-white/20 rounded-lg text-white placeholder-brand-tint/50 focus:ring-2 focus:ring-brand-red focus:border-transparent focus:outline-none text-sm transition-all duration-150">
                        <button type="submit" class="bg-brand-red hover:bg-brand-darkRed text-white font-bold px-6 py-3 rounded-lg text-sm shadow transition-colors duration-150 whitespace-nowrap">{{ $subscribeSection?->button_text ?? 'Subscribe Alerts' }}</button>
                    </form>
                    <div class="mt-2 text-xs text-brand-tint/50 flex items-center space-x-1">
                        <i data-lucide="shield-check" class="w-3.5 h-3.5"></i>
                        <span>{{ $subscribeSection?->privacy_note ?? 'No spam. Unsubscribe at any time.' }}</span>
                    </div>
                    <p class="text-xs text-brand-red font-bold mt-2" x-show="error" x-text="error" style="display: none;"></p>
                    <p class="text-xs text-brand-successGreen font-bold mt-2" x-show="success" style="display: none;">Successfully subscribed! Check your inbox for program alerts.</p>
                </div>
            </div>
        </div>
    </section>
@endsection
