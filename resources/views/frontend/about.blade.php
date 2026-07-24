@extends('frontend.layout')

@section('title', ($about?->meta_title ?: (($about?->page_title ?: 'About eDegree+').' | eDegree+')))
@section('meta_description', $about?->meta_description ?: 'Learn about eDegree+ and how we help professionals compare accredited online university degree programs.')
@section('seos')
    @include('frontend.partials.seos', ['seoModel' => $about, 'seo' => [
        'title' => $about?->page_title ?: 'About eDegree+',
        'description' => $about?->about_us ?: 'Learn about eDegree+ and how we help professionals compare accredited online university degree programs.',
        'url' => route('frontend.about'),
    ]])
@endsection

@section('content')
    <main class="flex-grow bg-altBg py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex mb-3 text-xs font-semibold uppercase tracking-wider text-mutedGray space-x-2" data-aos="fade-up">
                <a href="{{ route('frontend.home') }}" class="hover:text-brand-red">Home</a>
                <span>/</span>
                <span class="text-ink">About Us</span>
            </nav>

            <h1 class="font-heading font-bold text-3xl md:text-4xl text-ink tracking-tight mb-8" data-aos="fade-up">
                {{ $about?->page_title ?: 'About eDegree+' }}
            </h1>

            <article class="bg-white p-6 md:p-10 border border-borderGray rounded-custom shadow-sm space-y-8" data-aos="fade-up">
                <div class="space-y-4">
                    <h2 class="font-heading font-bold text-xl text-ink">{{ $about?->profile_title ?: 'Our Institutional Profile' }}</h2>
                    <div class="text-charcoal leading-relaxed text-sm md:text-base space-y-4">
                        {!! $about?->about_us ?: '<p>eDegree+ is a premium online education marketplace built strictly around university-degree options. We select and compile accredited distance-learning curricula, mapping online MBA, DBA, Master\'s, and Bachelor\'s programs from top partner institutions worldwide.</p><p>Our mission is simple: to help working professionals identify recognized academic programs, compare syllabus requirements, and submit applications directly to universities without career disruption.</p>' !!}
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 border-t border-b border-borderGray/65 py-8 my-6">
                    @foreach ([[$about?->stat_1_value ?: '50+', $about?->stat_1_label ?: 'Accredited Partners'], [$about?->stat_2_value ?: '100%', $about?->stat_2_label ?: 'Online Formats'], [$about?->stat_3_value ?: '24-Hr', $about?->stat_3_label ?: 'Advisor Response']] as $stat)
                        <div class="text-center {{ $loop->iteration === 2 ? 'border-t md:border-t-0 md:border-l md:border-r border-borderGray/60 py-4 md:py-0' : '' }}">
                            <h4 class="text-2xl font-bold text-brand-red">{{ $stat[0] }}</h4>
                            <p class="text-xs text-mutedGray font-semibold uppercase tracking-wider mt-1">{{ $stat[1] }}</p>
                        </div>
                    @endforeach
                </div>

                <div class="space-y-4" id="faq">
                    <h3 class="font-heading font-bold text-lg text-ink mb-4">{{ $about?->faq_title ?: 'Frequently Asked Questions' }}</h3>
                    <div class="space-y-3" x-data="{ activeFaq: null }">
                        @foreach ([[1, $about?->faq_question_1, $about?->faq_answer_1], [2, $about?->faq_question_2, $about?->faq_answer_2], [3, $about?->faq_question_3, $about?->faq_answer_3]] as [$index, $question, $answer])
                            @if ($question && $answer)
                                <div class="border border-borderGray rounded-lg overflow-hidden">
                                    <button @click="activeFaq = (activeFaq === {{ $index }} ? null : {{ $index }})" class="w-full text-left p-4 font-heading font-bold text-sm text-ink bg-altBg/30 hover:text-brand-red flex justify-between items-center focus:outline-none">
                                        <span>{{ $question }}</span>
                                        <i data-lucide="chevron-down" class="w-4 h-4 transition-transform" :class="{ 'rotate-180': activeFaq === {{ $index }} }"></i>
                                    </button>
                                    <div class="p-4 text-xs text-charcoal border-t border-borderGray bg-white leading-relaxed" x-show="activeFaq === {{ $index }}" style="display: none;">
                                        {{ $answer }}
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </article>
        </div>
    </main>
@endsection
