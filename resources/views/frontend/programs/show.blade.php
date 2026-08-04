@extends('frontend.layout')

@section('title', ($program->meta_title ?: $program->program.' | eDegree+'))
@section('meta_description', $program->meta_description ?: ($program->short_description ?: 'View accredited online program syllabus, eligibility rules and fee structures.'))
@section('seos')
    @include('frontend.partials.seos', ['seoModel' => $program, 'seo' => [
        'title' => $program->program,
        'description' => $program->short_description ?: $program->long_description,
        'url' => route('frontend.programs.show', $program->slug),
    ]])
@endsection

@php
    $imagePath = $program->image ?: $program->university?->image_1;
    $image = \App\Support\FrontendMedia::image($imagePath, 'https://images.unsplash.com/photo-1434030216411-0b793f4b4173?w=1600&h=600&fit=crop&q=80');
    $overview = $program->long_description ?: '<p>Program overview has not been added from the admin panel yet.</p>';
    $curriculum = $program->curriculum_description ?: '<p>Curriculum details have not been added from the admin panel yet.</p>';
    $eligibility = $program->eligibility_description ?: '<p>Eligibility details have not been added from the admin panel yet.</p>';
    $documents = $program->documents_required;
    $feesDescription = $program->fees_description ?: '<p>Fees and scholarship details have not been added from the admin panel yet.</p>';
    $outcomes = $program->outcomes_description ?: '<p>Outcome details have not been added from the admin panel yet.</p>';
    $applyUrl = $program->link ?: route('frontend.programs.show', $program->slug);
    $categoryName = $program->degree?->name ?? $program->type;
    $categoryUrl = $categoryName ? route('frontend.programs.index', ['degree' => $categoryName]) : route('frontend.programs.index');
    $universityUrl = $program->university?->slug ? route('frontend.universities.show', $program->university->slug) : null;
@endphp

@section('content')
    <section class="bg-altBg py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex mb-6 text-xs font-semibold uppercase tracking-wider text-mutedGray space-x-2" data-aos="fade-up">
                <a href="{{ route('frontend.home') }}" class="hover:text-brand-red">Home</a>
                <span>/</span>
                <a href="{{ route('frontend.programs.index') }}" class="hover:text-brand-red">Programs</a>
                <span>/</span>
                <span class="text-ink truncate">{{ $program->program }}</span>
            </nav>

            <section class="bg-white border border-borderGray rounded-custom overflow-hidden shadow-sm mb-8" data-aos="fade-up">
                <div class="h-64 md:h-80 relative bg-altBg">
                    <img src="{{ $image }}" alt="{{ $program->program }}" class="w-full h-full object-cover">
                </div>

                <div class="p-6 md:p-8 flex flex-col md:flex-row justify-between items-start gap-6">
                    <div class="max-w-3xl">
                        <div class="flex flex-wrap gap-2 mb-3">
                            <a href="{{ $categoryUrl }}" class="bg-brand-tint border border-brand-red/25 px-2.5 py-0.5 rounded-full text-[10px] font-bold text-brand-red uppercase hover:bg-brand-red hover:text-white transition-colors">
                                {{ $categoryName ?? 'Program' }}
                            </a>
                            @if ($program->recommend)
                                <span class="bg-brand-warningGold text-white px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase">Popular</span>
                            @endif
                        </div>
                        <h1 class="font-heading font-bold text-2xl md:text-4xl text-ink tracking-tight">{{ $program->program }}</h1>
                        <p class="text-sm text-charcoal mt-3">{{ $program->short_description ?: 'Accredited online program delivered for working professionals.' }}</p>
                        <div class="flex flex-wrap gap-3 mt-5">
                            @if ($universityUrl)
                                <a href="{{ $universityUrl }}" class="flex items-center space-x-1.5 bg-altBg px-3 py-2 rounded-lg border border-borderGray/50 text-xs text-charcoal hover:border-brand-red/50 hover:text-brand-red transition-colors">
                                    <i data-lucide="building-2" class="w-4 h-4 text-brand-red"></i>
                                    <span class="font-bold text-ink">{{ $program->university->name }}</span>
                                </a>
                            @else
                                <div class="flex items-center space-x-1.5 bg-altBg px-3 py-2 rounded-lg border border-borderGray/50 text-xs text-charcoal">
                                    <i data-lucide="building-2" class="w-4 h-4 text-brand-red"></i>
                                    <span class="font-bold text-ink">Partner University</span>
                                </div>
                            @endif
                            <div class="flex items-center space-x-1.5 bg-altBg px-3 py-2 rounded-lg border border-borderGray/50 text-xs text-charcoal">
                                <i data-lucide="clock" class="w-4 h-4 text-brand-red"></i>
                                <span class="font-bold text-ink">{{ $program->duration ?: 'Flexible' }}</span>
                            </div>
                            <div class="flex items-center space-x-1.5 bg-altBg px-3 py-2 rounded-lg border border-borderGray/50 text-xs text-charcoal">
                                <i data-lucide="monitor" class="w-4 h-4 text-brand-red"></i>
                                <span class="font-bold text-ink">{{ $program->delivery_mode ?: 'Online' }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-altBg/60 border border-borderGray rounded-xl p-5 w-full md:w-80 flex-shrink-0 space-y-4">
                        <div>
                            <div class="text-[10px] uppercase font-extrabold tracking-widest text-mutedGray">Total Tuition Fee</div>
                            <div class="text-3xl font-black text-brand-red mt-1">{{ $program->total_fee ?: 'Contact' }}</div>
                            @if ($program->scholarship_description)
                                <div class="text-[10px] text-mutedGray mt-1">{{ $program->scholarship_description }}</div>
                            @endif
                        </div>
                        <a href="{{ $applyUrl }}" class="w-full bg-brand-red hover:bg-brand-darkRed text-white py-3 rounded-lg text-sm font-bold text-center shadow hover:shadow-md transition-all duration-150 block">
                            {{ $program->apply_button_text ?: 'Apply Online Now' }}
                        </a>
                    </div>
                </div>
            </section>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <article class="lg:col-span-12 space-y-8" data-aos="fade-right" x-data="{ activeTab: 'overview' }">
                    <div class="bg-white border border-borderGray rounded-lg shadow-sm flex overflow-x-auto">
                        @foreach (['overview' => 'Overview', 'curriculum' => 'Curriculum', 'eligibility' => 'Eligibility', 'fees' => 'Fees & Aid', 'outcomes' => 'Outcomes'] as $key => $label)
                            <button @click="activeTab = '{{ $key }}'" class="flex-1 text-center py-4 px-3 text-xs md:text-sm font-semibold border-b-2 transition-colors whitespace-nowrap focus:outline-none" :class="activeTab === '{{ $key }}' ? 'border-brand-red text-brand-red' : 'border-transparent text-charcoal hover:text-brand-red'">
                                {{ $label }}
                            </button>
                        @endforeach
                    </div>

                    <div class="bg-white border border-borderGray p-6 md:p-8 rounded-custom shadow-sm min-h-64">
                        <div x-show="activeTab === 'overview'" class="space-y-4">
                            <h2 class="font-heading font-bold text-xl text-ink">{{ $program->overview_title ?: 'Program Summary' }}</h2>
                            <div class="text-charcoal leading-relaxed text-sm md:text-base prose max-w-none">
                                {!! $overview !!}
                            </div>
                        </div>

                        <div x-show="activeTab === 'curriculum'" class="space-y-4" style="display: none;">
                            <h2 class="font-heading font-bold text-xl text-ink mb-2">{{ $program->curriculum_title ?: 'Curriculum' }}</h2>
                            @if ($program->syllabus_pdf)
                                <a href="{{ asset($program->syllabus_pdf) }}" class="inline-flex items-center text-brand-red font-bold text-sm mb-4" target="_blank">
                                    <i data-lucide="file-text" class="w-4 h-4 mr-2"></i> Download Syllabus PDF
                                </a>
                            @endif
                            <div class="text-charcoal leading-relaxed text-sm md:text-base prose max-w-none">
                                {!! $curriculum !!}
                            </div>
                        </div>

                        <div x-show="activeTab === 'eligibility'" class="space-y-4" style="display: none;">
                            <h2 class="font-heading font-bold text-xl text-ink">{{ $program->eligibility_title ?: 'Eligibility' }}</h2>
                            <div class="text-charcoal leading-relaxed text-sm md:text-base prose max-w-none">
                                {!! $eligibility !!}
                            </div>
                            @if ($documents)
                                <div class="mt-6 border-t border-borderGray pt-4">
                                    <h4 class="font-heading font-bold text-xs uppercase text-mutedGray mb-2">Documents Required</h4>
                                    <div class="text-xs text-charcoal prose max-w-none">
                                        {!! $documents !!}
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div x-show="activeTab === 'fees'" class="space-y-4" style="display: none;">
                            <h2 class="font-heading font-bold text-xl text-ink">{{ $program->fees_title ?: 'Fees & Aid' }}</h2>
                            <div class="p-4 bg-altBg rounded-lg border border-borderGray/40 my-3">
                                <p class="text-xs text-mutedGray uppercase tracking-wider font-bold">Total cost tuition</p>
                                <p class="text-2xl font-extrabold text-brand-red">{{ $program->total_fee ?: 'Contact advisor' }}</p>
                                @if ($program->yearly)
                                    <p class="text-xs text-mutedGray mt-1">Yearly: {{ $program->yearly }}</p>
                                @endif
                            </div>
                            <div class="text-charcoal leading-relaxed text-sm md:text-base prose max-w-none mb-6">
                                {!! $feesDescription !!}
                            </div>
                            @if ($program->scholarship_title || $program->scholarship_description)
                                <div class="bg-brand-tint border border-brand-red/20 p-5 rounded-lg mt-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                                    <div class="flex-grow">
                                        <h4 class="font-heading font-bold text-sm text-brand-red mb-2">{{ $program->scholarship_title ?: 'Scholarships & Financing Options' }}</h4>
                                        @if ($program->scholarship_description)
                                            <p class="text-xs text-charcoal leading-relaxed">{{ $program->scholarship_description }}</p>
                                        @endif
                                    </div>
                                    <a href="{{ $applyUrl }}" class="bg-brand-red hover:bg-brand-darkRed text-white px-5 py-3 rounded-lg text-xs font-bold whitespace-nowrap shadow transition duration-150">
                                        {{ $program->apply_button_text ?: 'Apply Now' }}
                                    </a>
                                </div>
                            @endif
                        </div>

                        <div x-show="activeTab === 'outcomes'" class="space-y-4" style="display: none;">
                            <h2 class="font-heading font-bold text-xl text-ink">{{ $program->outcomes_title ?: 'Outcomes' }}</h2>
                            <div class="text-charcoal leading-relaxed text-sm md:text-base prose max-w-none">
                                {!! $outcomes !!}
                            </div>
                        </div>
                    </div>

                    @if ($relatedPrograms->isNotEmpty())
                        <div class="bg-white border border-borderGray p-6 rounded-custom shadow-sm">
                            <h2 class="font-heading font-bold text-xl text-ink mb-4">Related Programs</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach ($relatedPrograms as $related)
                                    <a href="{{ route('frontend.programs.show', $related->slug) }}" class="p-4 border border-borderGray rounded-lg hover:border-brand-red transition">
                                        <span class="text-[10px] font-bold text-brand-red uppercase">{{ $related->degree?->name ?? $related->type ?? 'Program' }}</span>
                                        <h3 class="font-heading font-bold text-sm text-ink mt-1">{{ $related->program }}</h3>
                                        <p class="text-xs text-mutedGray mt-2">{{ $related->duration ?: 'Flexible' }} &middot; {{ $related->total_fee ?: 'Contact' }}</p>
                                    </a>
                                @endforeach
                            </div>
                            @include('frontend.partials.load-more-pagination', ['paginator' => $relatedPrograms, 'label' => 'Load More Related Programs'])
                        </div>
                    @endif
                </article>

                <!--<aside class="lg:col-span-12 lg:sticky lg:top-24" id="inquiry-form" data-aos="fade-left">-->
                <!--    <div class="bg-white p-6 border border-borderGray rounded-custom shadow-lg space-y-5" x-data="{ success: false }">-->
                <!--        <div>-->
                <!--            <h3 class="font-heading font-bold text-lg text-ink mb-1">{{ $program->advisor_title ?: 'Request Free Counseling' }}</h3>-->
                <!--            <p class="text-xs text-mutedGray">{{ $program->advisor_description ?: 'Leave details below and academic advisors will call back soon.' }}</p>-->
                <!--        </div>-->

                <!--        <form @submit.prevent="success = true" class="space-y-3">-->
                <!--            <div>-->
                <!--                <label class="block text-xs font-bold text-charcoal mb-1">Full Name</label>-->
                <!--                <input type="text" placeholder="John Doe" class="w-full p-2.5 bg-altBg border border-borderGray rounded-lg text-sm text-ink focus:ring-2 focus:ring-brand-red focus:outline-none">-->
                <!--            </div>-->
                <!--            <div>-->
                <!--                <label class="block text-xs font-bold text-charcoal mb-1">Work Email</label>-->
                <!--                <input type="email" placeholder="john.doe@company.com" class="w-full p-2.5 bg-altBg border border-borderGray rounded-lg text-sm text-ink focus:ring-2 focus:ring-brand-red focus:outline-none">-->
                <!--            </div>-->
                <!--            <div>-->
                <!--                <label class="block text-xs font-bold text-charcoal mb-1">Mobile Number</label>-->
                <!--                <input type="tel" placeholder="+1 (555) 123-4567" class="w-full p-2.5 bg-altBg border border-borderGray rounded-lg text-sm text-ink focus:ring-2 focus:ring-brand-red focus:outline-none">-->
                <!--            </div>-->
                <!--            <button type="submit" class="w-full bg-brand-red hover:bg-brand-darkRed text-white py-3 rounded-lg font-bold shadow text-sm transition-colors duration-150">Request Information &rarr;</button>-->
                <!--        </form>-->

                <!--        <div class="p-4 bg-brand-tint border border-brand-red/25 rounded-lg text-center" x-show="success" style="display: none;">-->
                <!--            <h4 class="text-xs font-bold text-brand-red mb-1">Information Requested!</h4>-->
                <!--            <p class="text-[10px] text-charcoal">We have logged your query and advisors will connect shortly.</p>-->
                <!--        </div>-->
                <!--    </div>-->
                <!--</aside>-->
            </div>
        </div>
    </section>
@endsection
