@extends('frontend.layout')

@section('title', 'Insights Blog | eDegree+')
@section('meta_description', 'Acquire guidance on online degree value, admissions eligibility, and career choices.')
@section('seos')
    @include('frontend.partials.seos', ['seoModel' => $blogPage ?? null, 'seo' => [
        'title' => 'Insights Blog | eDegree+',
        'description' => 'Acquire guidance on online degree value, admissions eligibility, and career choices.',
        'url' => route('frontend.blog.index'),
    ]])
@endsection

@section('content')
    <main class="flex-grow bg-altBg py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-10 text-left" data-aos="fade-up">
                <nav class="flex mb-3 text-xs font-semibold uppercase tracking-wider text-mutedGray space-x-2">
                    <a href="{{ route('frontend.home') }}" class="hover:text-brand-red">Home</a>
                    <span>/</span>
                    <span class="text-ink">Blog</span>
                </nav>
                <h1 class="font-heading font-bold text-3xl md:text-4xl text-ink tracking-tight">Insights Blog</h1>
                <p class="text-charcoal mt-1 text-sm md:text-base">Acquire guidance on online degree value, admissions eligibility, and career choices.</p>
            </div>

            <div class="flex flex-wrap gap-2 mb-8" data-aos="fade-up">
                <a href="{{ route('frontend.blog.index') }}" class="px-4 py-2 rounded-full text-xs font-semibold tracking-wider transition-colors duration-150 border {{ $selectedCategory ? 'bg-white border-borderGray text-charcoal hover:border-brand-red hover:text-brand-red' : 'bg-brand-red border-brand-red text-white' }}">
                    All Guides
                </a>
                @foreach ($categories as $category)
                    <a href="{{ route('frontend.blog.index', ['category' => $category->slug]) }}" class="px-4 py-2 rounded-full text-xs font-semibold tracking-wider transition-colors duration-150 border {{ $selectedCategory === $category->slug ? 'bg-brand-red border-brand-red text-white' : 'bg-white border-borderGray text-charcoal hover:border-brand-red hover:text-brand-red' }}">
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse ($posts as $post)
                    <article class="bg-white border border-borderGray rounded-custom overflow-hidden shadow-sm hover:shadow-md transition flex flex-col min-h-[270px]" data-aos="fade-up">
                        <div class="p-6 flex-grow">
                            <span class="text-[10px] uppercase font-bold text-brand-red tracking-wider">{{ $post->category?->name ?? 'Education Insights' }}</span>
                            <h2 class="font-heading font-bold text-lg text-ink leading-snug mt-3 hover:text-brand-red transition">
                                <a href="{{ route('frontend.blog.show', $post->slug) }}">{{ $post->title }}</a>
                            </h2>
                            <p class="text-sm text-charcoal leading-relaxed mt-4 line-clamp-4">
                                {{ $post->excerpt ?: \Illuminate\Support\Str::limit(strip_tags($post->long_description ?: $post->content), 160) }}
                            </p>
                        </div>
                        <div class="px-6 py-4 bg-altBg/50 border-t border-borderGray/40 flex items-center justify-between text-xs">
                            <div class="flex items-center space-x-2">
                                <span class="w-6 h-6 rounded-full bg-brand-tint text-brand-red flex items-center justify-center font-bold">
                                    {{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($post->author_name ?: $post->author ?: 'e', 0, 1)) }}
                                </span>
                                <span class="font-bold text-ink">{{ $post->author_name ?: $post->author ?: 'eDegree Plus' }}</span>
                            </div>
                            <span class="text-mutedGray">{{ optional($post->published_at)->format('M d, Y') ?: $post->created_at->format('M d, Y') }}</span>
                        </div>
                    </article>
                @empty
                    <div class="lg:col-span-3 md:col-span-2 bg-white border border-borderGray rounded-custom p-8 text-center">
                        <h2 class="font-heading font-bold text-xl text-ink">No blog posts found</h2>
                        <p class="text-sm text-charcoal mt-2">Publish posts from the admin panel to show them here.</p>
                    </div>
                @endforelse
            </div>

            @if ($posts->hasPages())
                @include('frontend.partials.load-more-pagination', [
                    'paginator' => $posts,
                    'label' => 'Load More Articles',
                ])
            @endif
        </div>
    </main>

    <section class="py-16 bg-brand-dark text-white relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                <div class="lg:col-span-7">
                    <h2 class="font-heading font-bold text-2xl md:text-3xl text-white mb-2">Stay Ahead in Your Career</h2>
                    <p class="text-sm text-brand-tint/70">Subscribe to receive program alerts, scholarship updates, and university admissions deadlines.</p>
                </div>
                <div class="lg:col-span-5">
                    <form class="flex flex-col sm:flex-row gap-3">
                        <input type="email" placeholder="Enter your work email" class="flex-grow px-4 py-3 bg-white/10 border border-white/20 rounded-lg text-white placeholder-brand-tint/50 focus:ring-2 focus:ring-brand-red focus:border-transparent focus:outline-none text-sm transition-all duration-150">
                        <button type="button" class="bg-brand-red hover:bg-brand-darkRed text-white font-bold px-6 py-3 rounded-lg text-sm shadow transition-colors duration-150 whitespace-nowrap">
                            Subscribe Alerts
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
