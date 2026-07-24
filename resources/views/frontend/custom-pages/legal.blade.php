@extends('frontend.layout')

@section('title', $page->meta_title ?: ($fallbackTitle ?: $page->page_name).' | eDegree+')
@section('meta_description', $page->meta_description ?: ($page->short_description ?: \Illuminate\Support\Str::limit(strip_tags($page->description), 155)))
@section('seos')
    @include('frontend.partials.seos', ['seoModel' => $page, 'seo' => [
        'title' => $page->page_name,
        'description' => $page->short_description ?: $page->description,
        'url' => $page->canonical_url ?: url($page->desired_url ?: $page->slug),
    ]])
@endsection

@section('content')
    <main class="flex-grow bg-altBg py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex mb-3 text-xs font-semibold uppercase tracking-wider text-mutedGray space-x-2" data-aos="fade-up">
                <a href="{{ route('frontend.home') }}" class="hover:text-brand-red">Home</a>
                <span>/</span>
                <span class="text-ink">{{ $page->page_name }}</span>
            </nav>

            <h1 class="font-heading font-bold text-3xl md:text-4xl text-ink tracking-tight mb-8" data-aos="fade-up">{{ $page->page_name }}</h1>

            <article class="bg-white p-6 md:p-10 border border-borderGray rounded-custom shadow-sm space-y-6 prose max-w-none text-charcoal text-sm leading-relaxed" data-aos="fade-up">
                @if ($page->short_description)
                    <p class="text-base text-charcoal">{{ $page->short_description }}</p>
                @endif

                {!! $page->description !!}
            </article>
        </div>
    </main>

    @include('frontend.partials.subscribe')
@endsection
