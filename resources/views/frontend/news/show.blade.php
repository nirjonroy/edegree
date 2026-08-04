@extends('frontend.layout')

@section('title', ($news->meta_title ?: $news->title.' | eDegree+'))
@section('meta_description', $news->meta_description ?: ($news->short_description ?: 'Read the latest admissions news from eDegree+.'))
@section('seos')
    @include('frontend.partials.seos', ['seoModel' => $news, 'seo' => [
        'title' => $news->title,
        'description' => $news->short_description ?: $news->description,
        'url' => route('frontend.news.show', $news->slug),
    ]])
@endsection

@php
    $imagePath = $news->image;
    $image = $imagePath ? \App\Support\FrontendMedia::image($imagePath) : null;
@endphp

@section('content')
    <section class="bg-altBg py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex mb-6 text-xs font-semibold uppercase tracking-wider text-mutedGray space-x-2" data-aos="fade-up">
                <a href="{{ route('frontend.home') }}" class="hover:text-brand-red">Home</a>
                <span>/</span>
                <a href="{{ route('frontend.news.index') }}" class="hover:text-brand-red">News</a>
                <span>/</span>
                <span class="text-ink truncate">{{ $news->title }}</span>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <article class="lg:col-span-9 bg-white border border-borderGray rounded-custom shadow-sm p-6 md:p-10 mb-8" data-aos="fade-right">
                    <div class="text-center max-w-3xl mx-auto border-b-4 border-double border-ink pb-8 mb-8">
                        <span class="text-xs font-bold text-brand-red uppercase tracking-widest block mb-2">{{ $news->category ?: 'Admissions News' }}</span>
                        <h1 class="font-heading font-bold text-3xl md:text-4xl text-ink leading-tight tracking-tight">{{ $news->title }}</h1>

                        <div class="flex items-center justify-center space-x-4 mt-4 text-xs font-semibold text-mutedGray">
                            <span class="font-mono">{{ optional($news->published_at)->format('F d, Y') ?: $news->created_at->format('F d, Y') }}</span>
                            @if ($news->author)
                                <span>&middot;</span>
                                <span class="uppercase">By {{ $news->author }}</span>
                            @endif
                        </div>
                    </div>

                    @if ($image)
                        <div class="h-64 md:h-96 bg-altBg overflow-hidden rounded-lg mb-8">
                            <img src="{{ $image }}" alt="{{ $news->title }}" class="w-full h-full object-cover">
                        </div>
                    @endif

                    @if ($news->quote)
                        <blockquote class="border-l-4 border-brand-red pl-4 mb-8 font-heading font-semibold italic text-ink">
                            {{ $news->quote }}
                        </blockquote>
                    @endif

                    <div class="prose max-w-none text-charcoal leading-relaxed text-sm md:text-base broadsheet-columns">
                        {!! $news->description ?: '<p>'.e($news->short_description).'</p>' !!}
                    </div>
                </article>

                <aside class="lg:col-span-3 lg:sticky lg:top-24 space-y-6" data-aos="fade-left">
                    <div class="bg-white p-6 border border-borderGray rounded-custom shadow-sm space-y-4">
                        <h3 class="font-heading font-bold text-sm text-ink uppercase tracking-wider border-b border-borderGray pb-2">Recent News</h3>
                        <div class="space-y-4">
                            @forelse ($recentNews as $recent)
                                <div>
                                    <span class="text-[10px] font-bold text-brand-red uppercase">{{ $recent->category ?: 'News' }}</span>
                                    <h4 class="font-heading font-bold text-xs text-ink line-clamp-2 hover:text-brand-red transition mt-1">
                                        <a href="{{ route('frontend.news.show', $recent->slug) }}">{{ $recent->title }}</a>
                                    </h4>
                                    <span class="text-[10px] text-mutedGray font-medium">{{ optional($recent->published_at)->format('M d, Y') ?: $recent->created_at->format('M d, Y') }}</span>
                                </div>
                            @empty
                                <p class="text-xs text-charcoal">No other news published yet.</p>
                            @endforelse
                        </div>
                    </div>

                    <div class="bg-white p-6 border border-borderGray rounded-custom shadow-sm space-y-4">
                        <h3 class="font-heading font-bold text-sm text-ink uppercase tracking-wider border-b border-borderGray pb-2">Marketplace Links</h3>
                        <ul class="space-y-2 text-xs font-semibold">
                            <li><a href="{{ route('frontend.programs.index') }}" class="text-charcoal hover:text-brand-red block py-1">Explore Online Degrees &rarr;</a></li>
                            <li><a href="{{ route('frontend.universities.index') }}" class="text-charcoal hover:text-brand-red block py-1">Partner Universities &rarr;</a></li>
                            <li><a href="{{ route('frontend.blog.index') }}" class="text-charcoal hover:text-brand-red block py-1">Insights Blog &rarr;</a></li>
                        </ul>
                    </div>
                </aside>
            </div>
        </div>
    </section>
@endsection
