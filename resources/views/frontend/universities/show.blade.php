@extends('frontend.layout')

@section('title', ($university->meta_title ?: $university->name.' | eDegree+'))
@section('meta_description', $university->meta_description ?: ($university->short_description ?: 'Explore partner university accreditation details, online degrees, admissions and graduate reviews.'))
@section('seos')
    @include('frontend.partials.seos', ['seoModel' => $university, 'seo' => [
        'title' => $university->name,
        'description' => $university->short_description ?: $university->long_description,
        'url' => route('frontend.universities.show', $university->slug),
    ]])
@endsection

@php
    $image = $university->image_1
        ? (\Illuminate\Support\Str::startsWith($university->image_1, ['http://', 'https://']) ? $university->image_1 : asset($university->image_1))
        : 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?w=1600&h=600&fit=crop&q=80';
    $stats = [
        ['label' => 'Founded', 'value' => $university->founded_year ?: 'Online'],
        ['label' => 'Ranking', 'value' => $university->ranking_badge ?: ($university->rank ?: 'Accredited')],
        ['label' => 'Accreditation', 'value' => $university->accreditation_badge ?: 'Approved'],
        ['label' => 'Degrees', 'value' => $university->degree_badge ?: 'Online'],
    ];
    $reviews = collect([
        ['name' => $university->review_1_name, 'text' => $university->review_1_text, 'rating' => $university->review_1_rating ?: 5],
        ['name' => $university->review_2_name, 'text' => $university->review_2_text, 'rating' => $university->review_2_rating ?: 5],
    ])->filter(fn ($review) => $review['name'] || $review['text']);
@endphp

@section('content')
    <section class="bg-altBg py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex mb-6 text-xs font-semibold uppercase tracking-wider text-mutedGray space-x-2" data-aos="fade-up">
                <a href="{{ route('frontend.home') }}" class="hover:text-brand-red">Home</a>
                <span>/</span>
                <a href="{{ route('frontend.universities.index') }}" class="hover:text-brand-red">Universities</a>
                <span>/</span>
                <span class="text-ink truncate">{{ $university->name }}</span>
            </nav>

            <section class="bg-white border border-borderGray rounded-custom overflow-hidden shadow-sm mb-8" data-aos="fade-up">
                <div class="h-64 md:h-80 relative bg-ink">
                    <img src="{{ $image }}" alt="{{ $university->name }}" class="w-full h-full object-cover opacity-60">
                </div>

                <div class="p-6 md:p-8 flex flex-col md:flex-row justify-between items-start md:items-end gap-6 relative -mt-10 z-10">
                    <div class="flex flex-col md:flex-row items-start md:items-end gap-4">
                        <div class="w-24 h-24 bg-white p-2 rounded-xl shadow-md border border-borderGray flex-shrink-0 flex items-center justify-center">
                            <i data-lucide="graduation-cap" class="w-12 h-12 text-brand-red"></i>
                        </div>
                        <div>
                            <h1 class="font-heading font-bold text-2xl md:text-3xl text-ink tracking-tight">{{ $university->name }}</h1>
                            <div class="flex flex-wrap items-center gap-2 mt-2">
                                <span class="text-xs font-semibold text-mutedGray">{{ $university->location ?: 'Global Online' }}</span>
                                @if ($university->founded_year)
                                    <span class="text-xs text-mutedGray">&middot;</span>
                                    <span class="bg-brand-tint border border-brand-red/25 px-2.5 py-0.5 rounded-full text-[10px] font-bold text-brand-red uppercase">Founded {{ $university->founded_year }}</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-2 w-full md:w-auto">
                        @foreach ($stats as $stat)
                            <div class="bg-altBg px-3 py-1.5 rounded-lg border border-borderGray/60 text-center flex-1 sm:flex-initial">
                                <div class="text-xs font-bold text-ink">{{ $stat['value'] }}</div>
                                <div class="text-[9px] uppercase tracking-wider text-mutedGray">{{ $stat['label'] }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <article class="lg:col-span-12 space-y-8" data-aos="fade-right" x-data="{ activeTab: 'programs' }">
                    <div class="bg-white border border-borderGray rounded-lg shadow-sm flex overflow-x-auto">
                        <button @click="activeTab = 'programs'" class="flex-1 text-center py-4 px-3 text-xs md:text-sm font-semibold border-b-2 transition-colors whitespace-nowrap focus:outline-none" :class="activeTab === 'programs' ? 'border-brand-red text-brand-red' : 'border-transparent text-charcoal hover:text-brand-red'">
                            Programs Offered ({{ $universityPrograms->count() }})
                        </button>
                        <button @click="activeTab = 'accreditation'" class="flex-1 text-center py-4 px-3 text-xs md:text-sm font-semibold border-b-2 transition-colors whitespace-nowrap focus:outline-none" :class="activeTab === 'accreditation' ? 'border-brand-red text-brand-red' : 'border-transparent text-charcoal hover:text-brand-red'">Accreditation</button>
                        <button @click="activeTab = 'admissions'" class="flex-1 text-center py-4 px-3 text-xs md:text-sm font-semibold border-b-2 transition-colors whitespace-nowrap focus:outline-none" :class="activeTab === 'admissions' ? 'border-brand-red text-brand-red' : 'border-transparent text-charcoal hover:text-brand-red'">Admissions</button>
                        <button @click="activeTab = 'reviews'" class="flex-1 text-center py-4 px-3 text-xs md:text-sm font-semibold border-b-2 transition-colors whitespace-nowrap focus:outline-none" :class="activeTab === 'reviews' ? 'border-brand-red text-brand-red' : 'border-transparent text-charcoal hover:text-brand-red'">Reviews</button>
                    </div>

                    <div class="bg-white border border-borderGray p-6 md:p-8 rounded-custom shadow-sm min-h-64">
                        <div x-show="activeTab === 'programs'" class="space-y-8">
                            <div>
                                <h2 class="font-heading font-bold text-xl text-ink mb-4">Accredited Online Programs</h2>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    @forelse ($universityPrograms as $program)
                                        <div class="p-4 border border-borderGray rounded-lg hover:border-brand-red hover:shadow-sm transition flex flex-col justify-between">
                                            <div>
                                                <div class="flex justify-between items-start gap-4">
                                                    <span class="text-[10px] font-bold text-brand-red uppercase tracking-wider">{{ $program->degree?->name ?? $program->type ?? 'Program' }}</span>
                                                    <span class="text-sm font-extrabold text-brand-red">{{ $program->total_fee ?: 'Contact' }}</span>
                                                </div>
                                                <h4 class="font-heading font-bold text-sm text-ink mt-1">{{ $program->program }}</h4>
                                            </div>
                                            <div class="flex justify-between items-center mt-4 pt-3 border-t border-borderGray/40 text-xs">
                                                <span class="text-mutedGray font-medium">{{ $program->duration ?: 'Flexible' }}</span>
                                                <a href="{{ $program->link ?: route('frontend.programs.show', $program->slug) }}" class="text-brand-red font-bold">View Syllabus &rarr;</a>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="md:col-span-2 p-6 border border-borderGray rounded-lg text-sm text-charcoal">No programs are attached to this university yet.</div>
                                    @endforelse
                                </div>
                            </div>

                            <div class="@if ($university->long_description) border-t border-borderGray pt-8 @endif">
                                @if ($university->long_description)
                                    <div class="text-charcoal leading-relaxed text-sm md:text-base prose max-w-none">
                                        {!! $university->long_description !!}
                                    </div>
                                @endif

                                @if ($university->accomplishment_text || $university->rank)
                                    <div class="mt-6 border-t border-borderGray pt-4">
                                        <h4 class="font-heading font-bold text-xs uppercase text-mutedGray mb-2">{{ $university->accomplishment_title ?: 'Key Accomplishments' }}</h4>
                                        <div class="flex items-center space-x-2 text-sm text-ink font-semibold">
                                            <i data-lucide="award" class="w-5 h-5 text-brand-warningGold"></i>
                                            <span>{{ $university->accomplishment_text ?: $university->rank }}</span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div x-show="activeTab === 'accreditation'" class="space-y-4" style="display: none;">
                            <h2 class="font-heading font-bold text-xl text-ink">{{ $university->accreditation_title ?: 'Recognized Status' }}</h2>
                            <div class="text-charcoal leading-relaxed text-sm md:text-base prose max-w-none">
                                {!! $university->accreditation_description ?: 'This university maintains recognized accreditation and licensing rules for its degree pathways.' !!}
                            </div>
                            <div class="bg-brand-tint border border-brand-red/20 p-5 rounded-lg mt-6">
                                <h4 class="font-heading font-bold text-xs uppercase text-brand-red tracking-wider mb-2">{{ $university->accrediting_commission_title ?: 'Accrediting Commission' }}</h4>
                                <p class="text-xs text-charcoal font-semibold leading-relaxed">{{ $university->accrediting_commission_text ?: $university->accreditation_badge }}</p>
                            </div>
                        </div>

                        <div x-show="activeTab === 'admissions'" class="space-y-4" style="display: none;">
                            <h2 class="font-heading font-bold text-xl text-ink">{{ $university->admissions_title ?: 'Admissions Guidelines' }}</h2>
                            <div class="text-charcoal leading-relaxed text-sm md:text-base prose max-w-none">
                                {!! $university->admissions_description ?: 'Admissions requirements vary by program. Contact an advisor for the latest eligibility and document checklist.' !!}
                            </div>
                        </div>

                        <div x-show="activeTab === 'reviews'" class="space-y-6" style="display: none;">
                            <h2 class="font-heading font-bold text-xl text-ink">{{ $university->reviews_title ?: 'Graduate Testimonials' }}</h2>
                            <div class="space-y-4">
                                @forelse ($reviews as $review)
                                    <div class="p-5 border border-borderGray rounded-lg bg-altBg/30">
                                        <div class="flex items-center justify-between mb-2 gap-4">
                                            <h4 class="font-heading font-bold text-sm text-ink">{{ $review['name'] ?: 'Graduate Student' }}</h4>
                                            <div class="flex items-center text-brand-warningGold text-xs">
                                                @for ($i = 0; $i < min(5, (int) $review['rating']); $i++)
                                                    <i data-lucide="star" class="w-3.5 h-3.5 fill-current"></i>
                                                @endfor
                                            </div>
                                        </div>
                                        <p class="text-xs text-charcoal italic">"{{ $review['text'] }}"</p>
                                    </div>
                                @empty
                                    <div class="p-5 border border-borderGray rounded-lg bg-altBg/30 text-sm text-charcoal">No reviews have been added yet.</div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </article>

                <!--<aside class="lg:col-span-12 lg:sticky lg:top-24">-->
                <!--    <div class="bg-white p-6 border border-borderGray rounded-custom shadow-lg space-y-5" x-data="{ success: false }">-->
                <!--        <div>-->
                <!--            <h3 class="font-heading font-bold text-lg text-ink mb-1">{{ $university->advisor_title ?: 'Talk to an Advisor' }}</h3>-->
                <!--            <p class="text-xs text-mutedGray">{{ $university->advisor_description ?: 'Connect directly with admissions advisors concerning registration guidelines.' }}</p>-->
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

                <!--        <div class="text-[10px] text-mutedGray text-center mt-3 flex items-center justify-center space-x-1.5">-->
                <!--            <i data-lucide="lock" class="w-3.5 h-3.5"></i>-->
                <!--            <span>Data is securely encrypted.</span>-->
                <!--        </div>-->
                <!--    </div>-->
                <!--</aside>-->
            </div>
        </div>
    </section>
@endsection
