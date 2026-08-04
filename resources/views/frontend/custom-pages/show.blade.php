@extends('frontend.layout')

@section('title', $page->meta_title ?: $page->page_name.' | eDegree+')
@section('meta_description', $page->meta_description ?: ($page->short_description ?: \Illuminate\Support\Str::limit(strip_tags($page->description), 155)))
@section('seos')
    @include('frontend.partials.seos', ['seoModel' => $page, 'seo' => [
        'title' => $page->page_name,
        'description' => $page->short_description ?: $page->description,
        'url' => $page->canonical_url ?: url($page->desired_url ?: $page->slug),
    ]])
@endsection

@php
    $background = $page->background_image ?: $page->meta_image;
    $backgroundUrl = $background ? \App\Support\FrontendMedia::image($background) : null;
@endphp

@section('content')
    <section class="relative bg-ink text-white overflow-hidden">
        @if ($backgroundUrl)
            <div class="absolute inset-0">
                <img src="{{ $backgroundUrl }}" alt="{{ $page->page_name }}" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-black/70"></div>
            </div>
        @else
            <div class="absolute inset-0 bg-gradient-to-br from-ink via-brand-dark to-black"></div>
        @endif

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 md:py-28">
            <nav class="flex mb-6 text-xs font-semibold uppercase tracking-wider text-white/70 space-x-2" data-aos="fade-up">
                <a href="{{ route('frontend.home') }}" class="hover:text-white">Home</a>
                <span>/</span>
                <span class="text-white">{{ $page->page_name }}</span>
            </nav>

            <div class="max-w-3xl" data-aos="fade-up">
                <h1 class="font-heading font-bold text-4xl md:text-5xl text-white tracking-tight leading-tight">{{ $page->page_name }}</h1>
                @if ($page->subtitle)
                    <p class="mt-5 text-lg text-brand-tint/90 leading-relaxed">{{ $page->subtitle }}</p>
                @elseif ($page->short_description)
                    <p class="mt-5 text-lg text-brand-tint/90 leading-relaxed">{{ $page->short_description }}</p>
                @endif
            </div>
        </div>
    </section>

    <section class="bg-altBg py-12 md:py-16">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <article class="bg-white border border-borderGray rounded-custom shadow-sm p-6 md:p-10" data-aos="fade-up">
                @if ($page->short_description)
                    <div class="border-l-4 border-brand-red pl-4 mb-8">
                        <p class="text-charcoal text-base md:text-lg leading-relaxed">{{ $page->short_description }}</p>
                    </div>
                @endif

                <div class="prose max-w-none text-charcoal leading-relaxed space-y-4 text-sm md:text-base">
                    {!! $page->description !!}
                </div>
            </article>
        </div>
    </section>
@endsection
