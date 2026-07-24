@extends('frontend.layout')

@section('title', ($post->meta_title ?: $post->title.' | eDegree+'))
@section('meta_description', $post->meta_description ?: ($post->short_description ?: $post->excerpt))
@section('seos')
    @include('frontend.partials.seos', ['seoModel' => $post, 'seo' => [
        'title' => $post->title,
        'description' => $post->short_description ?: $post->excerpt ?: $post->long_description,
        'url' => route('frontend.blog.show', $post->slug),
    ]])
@endsection

@php
    $imagePath = $post->image ?: $post->featured_image_path;
    $image = $imagePath
        ? (\Illuminate\Support\Str::startsWith($imagePath, ['http://', 'https://']) ? $imagePath : asset($imagePath))
        : 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=1200&h=650&fit=crop&q=80';
    $content = $post->long_description ?: $post->content;
@endphp

@section('content')
    <main class="flex-grow bg-altBg py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex mb-6 text-xs font-semibold uppercase tracking-wider text-mutedGray space-x-2" data-aos="fade-up">
                <a href="{{ route('frontend.home') }}" class="hover:text-brand-red">Home</a>
                <span>/</span>
                <a href="{{ route('frontend.blog.index') }}" class="hover:text-brand-red">Blog</a>
                <span>/</span>
                <span class="text-ink truncate">{{ $post->title }}</span>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <article class="lg:col-span-9 bg-white p-6 md:p-8 border border-borderGray rounded-custom shadow-sm space-y-6" data-aos="fade-right">
                    <div>
                        <span class="inline-block bg-brand-tint border border-brand-red/25 px-2.5 py-0.5 rounded-full text-[10px] font-bold text-brand-red uppercase tracking-wider mb-3">{{ $post->category?->name ?? 'Education Insights' }}</span>
                        <h1 class="font-heading font-bold text-2xl md:text-3xl lg:text-4xl text-ink tracking-tight leading-tight">{{ $post->title }}</h1>

                        <div class="flex flex-wrap items-center gap-3 mt-4 pt-4 border-t border-borderGray/65 text-xs text-mutedGray">
                            <div class="flex items-center space-x-2">
                                <span class="w-6 h-6 rounded-full bg-brand-tint text-brand-red flex items-center justify-center font-bold">{{ \Illuminate\Support\Str::substr($post->author_name ?: $post->author ?: 'A', 0, 1) }}</span>
                                <span class="font-bold text-ink">{{ $post->author_name ?: $post->author ?: 'Admin' }}</span>
                            </div>
                            <span>&middot;</span>
                            <span>{{ optional($post->published_at)->format('F d, Y') ?: $post->created_at->format('F d, Y') }}</span>
                            <span>&middot;</span>
                            <span class="font-mono text-[10px] uppercase font-bold">{{ max(1, ceil(str_word_count(strip_tags($content)) / 220)) }} min read</span>
                        </div>
                    </div>

                    <div class="h-64 md:h-96 bg-altBg overflow-hidden rounded-lg">
                        <img src="{{ $image }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
                    </div>

                    @if ($post->quote)
                        <blockquote class="border-l-4 border-brand-red pl-4 text-lg font-heading font-semibold italic text-ink">
                            {{ $post->quote }}
                        </blockquote>
                    @endif

                    <div class="prose max-w-none text-charcoal leading-relaxed space-y-4 text-sm md:text-base border-b border-borderGray pb-6">
                        {!! $content !!}
                    </div>

                    @if ($post->keywords)
                        <div class="flex flex-wrap gap-2 pt-2">
                            @foreach (array_filter(array_map('trim', explode(',', $post->keywords))) as $keyword)
                                <span class="bg-altBg border border-borderGray rounded-full px-3 py-1 text-[10px] font-bold text-charcoal">{{ $keyword }}</span>
                            @endforeach
                        </div>
                    @endif

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-8 border-t border-borderGray">
                        <div class="p-4 border border-borderGray rounded-lg bg-altBg/30 flex items-start space-x-3">
                            <i data-lucide="arrow-left" class="w-5 h-5 text-brand-red flex-shrink-0 mt-0.5"></i>
                            <div>
                                <div class="text-[9px] uppercase font-bold text-mutedGray">Previous Post</div>
                                <a href="{{ route('frontend.blog.index') }}" class="text-xs font-bold text-ink hover:text-brand-red mt-1 block">Back to insights list</a>
                            </div>
                        </div>
                        @if ($recentPosts->isNotEmpty())
                            <div class="p-4 border border-borderGray rounded-lg bg-altBg/30 flex items-start justify-between space-x-3 text-right">
                                <div>
                                    <div class="text-[9px] uppercase font-bold text-mutedGray">Next Post</div>
                                    <a href="{{ route('frontend.blog.show', $recentPosts->first()->slug) }}" class="text-xs font-bold text-ink hover:text-brand-red mt-1 block truncate w-48">{{ $recentPosts->first()->title }}</a>
                                </div>
                                <i data-lucide="arrow-right" class="w-5 h-5 text-brand-red flex-shrink-0 mt-0.5"></i>
                            </div>
                        @endif
                    </div>
                </article>

                <aside class="lg:col-span-3 lg:sticky lg:top-24 space-y-6" data-aos="fade-left">
                    <div class="bg-white p-6 border border-borderGray rounded-custom shadow-sm space-y-4">
                        <h3 class="font-heading font-bold text-sm text-ink uppercase tracking-wider border-b border-borderGray pb-2">Recent Insights</h3>
                        <div class="space-y-4">
                            @forelse ($recentPosts as $recent)
                                @php
                                    $recentImagePath = $recent->image ?: $recent->featured_image_path;
                                    $recentImage = $recentImagePath
                                        ? (\Illuminate\Support\Str::startsWith($recentImagePath, ['http://', 'https://']) ? $recentImagePath : asset($recentImagePath))
                                        : 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=120&h=120&fit=crop&q=80';
                                @endphp
                                <div class="flex gap-3 items-start">
                                    <img src="{{ $recentImage }}" alt="{{ $recent->title }}" class="w-14 h-14 rounded-lg object-cover flex-shrink-0 bg-altBg">
                                    <div>
                                        <h4 class="font-heading font-bold text-xs text-ink line-clamp-2 hover:text-brand-red transition">
                                            <a href="{{ route('frontend.blog.show', $recent->slug) }}">{{ $recent->title }}</a>
                                        </h4>
                                        <span class="text-[10px] text-mutedGray font-medium">{{ optional($recent->published_at)->format('M d, Y') ?: $recent->created_at->format('M d, Y') }}</span>
                                    </div>
                                </div>
                            @empty
                                <p class="text-xs text-charcoal">No other posts published yet.</p>
                            @endforelse
                        </div>
                    </div>

                    <div class="bg-white p-6 border border-borderGray rounded-custom shadow-sm space-y-4">
                        <h3 class="font-heading font-bold text-sm text-ink uppercase tracking-wider border-b border-borderGray pb-2">Marketplace Links</h3>
                        <ul class="space-y-2 text-xs font-semibold">
                            <li><a href="{{ route('frontend.programs.index') }}" class="text-charcoal hover:text-brand-red block py-1">Explore Online Degrees &rarr;</a></li>
                            <li><a href="{{ route('frontend.universities.index') }}" class="text-charcoal hover:text-brand-red block py-1">Partner Universities &rarr;</a></li>
                            <li><a href="{{ route('frontend.news.index') }}" class="text-charcoal hover:text-brand-red block py-1">Admissions News &rarr;</a></li>
                        </ul>
                    </div>
                </aside>
            </div>
        </div>
    </main>
@endsection
