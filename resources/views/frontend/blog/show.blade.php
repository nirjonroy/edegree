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
    $image = $imagePath ? \App\Support\FrontendMedia::image($imagePath) : null;
    $content = $post->long_description ?: $post->content;
@endphp

@section('content')
    <!-- Added overflow-hidden on main container to trap AOS animation offsets -->
    <main class="flex-grow bg-altBg py-8 md:py-12 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex mb-6 text-xs font-semibold uppercase tracking-wider text-mutedGray space-x-2 overflow-x-auto whitespace-nowrap" data-aos="fade-up">
                <a href="{{ route('frontend.home') }}" class="hover:text-brand-red flex-shrink-0">Home</a>
                <span>/</span>
                <a href="{{ route('frontend.blog.index') }}" class="hover:text-brand-red flex-shrink-0">Blog</a>
                <span>/</span>
                <span class="text-ink truncate min-w-0">{{ $post->title }}</span>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <!-- Added min-w-0 to grid children to prevent flex/grid item overflow -->
                <article class="lg:col-span-9 bg-white p-4 sm:p-6 md:p-8 border border-borderGray rounded-custom shadow-sm space-y-6 min-w-0" data-aos="fade-right">
                    <div>
                        <span class="inline-block bg-brand-tint border border-brand-red/25 px-2.5 py-0.5 rounded-full text-[10px] font-bold text-brand-red uppercase tracking-wider mb-3">{{ $post->category?->name ?? 'Education Insights' }}</span>
                        <h1 class="font-heading font-bold text-2xl md:text-3xl lg:text-4xl text-ink tracking-tight leading-tight break-words">{{ $post->title }}</h1>

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

                    @if ($image)
                        <div class="h-56 sm:h-64 md:h-96 bg-altBg overflow-hidden rounded-lg">
                            <img src="{{ $image }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
                        </div>
                    @endif

                    @if ($post->quote)
                        <blockquote class="border-l-4 border-brand-red pl-4 text-base sm:text-lg font-heading font-semibold italic text-ink break-words">
                            {{ $post->quote }}
                        </blockquote>
                    @endif

                    <!-- Trapped dynamic prose with overflow container -->
                    <div class="prose max-w-none text-charcoal leading-relaxed space-y-4 text-sm md:text-base overflow-x-auto break-words">
                        {!! $content !!}
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-8 border-t border-borderGray">
                        <div class="p-4 border border-borderGray rounded-lg bg-altBg/30 flex items-start space-x-3">
                            <i data-lucide="arrow-left" class="w-5 h-5 text-brand-red flex-shrink-0 mt-0.5"></i>
                            <div class="min-w-0">
                                <div class="text-[9px] uppercase font-bold text-mutedGray">Previous Post</div>
                                @if ($previousPost)
                                    <a href="{{ route('frontend.blog.show', $previousPost->slug) }}" class="text-xs font-bold text-ink hover:text-brand-red mt-1 block truncate w-full">{{ $previousPost->title }}</a>
                                @else
                                    <a href="{{ route('frontend.blog.index') }}" class="text-xs font-bold text-ink hover:text-brand-red mt-1 block">Back to insights list</a>
                                @endif
                            </div>
                        </div>
                        <div class="p-4 border border-borderGray rounded-lg bg-altBg/30 flex items-start justify-between space-x-3 text-right">
                            <div class="min-w-0 flex-1">
                                <div class="text-[9px] uppercase font-bold text-mutedGray">Next Post</div>
                                @if ($nextPost)
                                    <a href="{{ route('frontend.blog.show', $nextPost->slug) }}" class="text-xs font-bold text-ink hover:text-brand-red mt-1 block truncate w-full">{{ $nextPost->title }}</a>
                                @else
                                    <a href="{{ route('frontend.blog.index') }}" class="text-xs font-bold text-ink hover:text-brand-red mt-1 block">Back to insights list</a>
                                @endif
                            </div>
                            <i data-lucide="arrow-right" class="w-5 h-5 text-brand-red flex-shrink-0 mt-0.5"></i>
                        </div>
                    </div>
                </article>

                <aside class="lg:col-span-3 lg:sticky lg:top-24 space-y-6 min-w-0" data-aos="fade-left">
                    <div class="bg-white p-6 border border-borderGray rounded-custom shadow-sm space-y-4">
                        <h3 class="font-heading font-bold text-sm text-ink uppercase tracking-wider border-b border-borderGray pb-2">Recent Insights</h3>
                        <div class="space-y-4">
                            @forelse ($recentPosts as $recent)
                                @php
                                    $recentImagePath = $recent->image ?: $recent->featured_image_path;
                                    $recentImage = $recentImagePath ? \App\Support\FrontendMedia::image($recentImagePath) : null;
                                @endphp
                                <div class="flex gap-3 items-start min-w-0">
                                    @if ($recentImage)
                                        <img src="{{ $recentImage }}" alt="{{ $recent->title }}" class="w-14 h-14 rounded-lg object-cover flex-shrink-0 bg-altBg">
                                    @endif
                                    <div class="min-w-0 flex-1">
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
