@extends('frontend.layout')

@section('title', 'Sitemap | eDegree+')
@section('meta_description', 'Access the complete webpage tree and index of programs, universities, blogs, news, and company pages for eDegree+.')
@section('seos')
    @include('frontend.partials.seos', ['seo' => [
        'title' => 'Sitemap | eDegree+',
        'description' => 'Access the complete webpage tree and index of programs, universities, blogs, news, and company pages for eDegree+.',
        'url' => route('frontend.sitemap.page'),
    ]])
@endsection

@php
    $labels = [
        'static' => 'Directory Indexes',
        'program' => 'Programs',
        'university' => 'Universities',
        'blog_post' => 'Blog',
        'news' => 'News',
        'custom_page' => 'Company & Custom Pages',
    ];
@endphp

@section('content')
    <main class="flex-grow bg-altBg py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex mb-3 text-xs font-semibold uppercase tracking-wider text-mutedGray space-x-2" data-aos="fade-up">
                <a href="{{ route('frontend.home') }}" class="hover:text-brand-red">Home</a>
                <span>/</span>
                <span class="text-ink">Sitemap</span>
            </nav>

            <h1 class="font-heading font-bold text-3xl md:text-4xl text-ink tracking-tight mb-8" data-aos="fade-up">eDegree+ Site Index</h1>

            <article class="bg-white p-6 md:p-10 border border-borderGray rounded-custom shadow-sm space-y-8" data-aos="fade-up">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 text-sm">
                    @forelse ($entries as $group => $items)
                        <div>
                            <h3 class="font-heading font-bold text-ink uppercase tracking-wider text-xs mb-3 border-b border-borderGray pb-1.5">{{ $labels[$group] ?? \Illuminate\Support\Str::headline($group) }}</h3>
                            <ul class="space-y-2">
                                @foreach ($items as $entry)
                                    <li>
                                        <a href="{{ $entry->absolute_url }}" class="text-charcoal hover:text-brand-red transition font-semibold">
                                            {{ $entry->title ?: $entry->url }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @empty
                        <div>
                            <h3 class="font-heading font-bold text-ink uppercase tracking-wider text-xs mb-3 border-b border-borderGray pb-1.5">Directory Indexes</h3>
                            <ul class="space-y-2">
                                <li><a href="{{ route('frontend.home') }}" class="text-charcoal hover:text-brand-red transition font-semibold">Homepage Overview</a></li>
                                <li><a href="{{ route('frontend.programs.index') }}" class="text-charcoal hover:text-brand-red transition font-semibold">Online Degree Program Finder</a></li>
                                <li><a href="{{ route('frontend.universities.index') }}" class="text-charcoal hover:text-brand-red transition font-semibold">Partner University Directories</a></li>
                                <li><a href="{{ route('frontend.blog.index') }}" class="text-charcoal hover:text-brand-red transition font-semibold">Insights Guides Blog Archive</a></li>
                                <li><a href="{{ route('frontend.news.index') }}" class="text-charcoal hover:text-brand-red transition font-semibold">Admissions News Index</a></li>
                            </ul>
                        </div>
                    @endforelse
                </div>
            </article>
        </div>
    </main>

    @include('frontend.partials.subscribe')
@endsection
