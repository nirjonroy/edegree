@extends('frontend.layout')

@section('title', 'Admissions News Index | eDegree+')
@section('meta_description', 'Read the latest admissions circulars, online education policy updates, and university expansion news.')

@section('content')
    <section class="bg-altBg py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex mb-3 text-xs font-semibold uppercase tracking-wider text-mutedGray space-x-2" data-aos="fade-up">
                <a href="{{ route('frontend.home') }}" class="hover:text-brand-red">Home</a>
                <span>/</span>
                <span class="text-ink">News</span>
            </nav>

            <h1 class="font-heading font-bold text-3xl md:text-4xl text-ink tracking-tight mb-8" data-aos="fade-up">Admissions News</h1>

            <div class="space-y-6">
                @forelse ($newsPage as $item)
                    <article class="bg-white p-6 border border-borderGray rounded-custom shadow-sm hover:shadow transition flex flex-col md:flex-row justify-between items-start md:items-center gap-4" data-aos="fade-up">
                        <div class="space-y-2">
                            <div class="flex items-center space-x-2 text-[10px] uppercase font-bold">
                                <span class="text-brand-red tracking-wider">{{ $item->category ?: 'Admissions News' }}</span>
                                <span class="text-mutedGray">&middot;</span>
                                <span class="text-mutedGray font-mono">{{ optional($item->published_at)->format('F d, Y') ?: $item->created_at->format('F d, Y') }}</span>
                            </div>
                            <h2 class="font-heading font-bold text-base text-ink leading-snug hover:text-brand-red transition">
                                <a href="{{ route('frontend.news.show', $item->slug) }}">{{ $item->title }}</a>
                            </h2>
                            <p class="text-xs text-charcoal leading-relaxed line-clamp-2">{{ $item->short_description ?: \Illuminate\Support\Str::limit(strip_tags($item->description), 160) }}</p>
                        </div>
                        <a href="{{ route('frontend.news.show', $item->slug) }}" class="text-brand-red text-xs font-bold hover:text-brand-darkRed inline-flex items-center flex-shrink-0">
                            <span>Read Circular</span>
                            <i data-lucide="arrow-right" class="w-3.5 h-3.5 ml-1"></i>
                        </a>
                    </article>
                @empty
                    <div class="bg-white border border-borderGray rounded-custom p-8 text-center">
                        <h2 class="font-heading font-bold text-xl text-ink">No news published yet</h2>
                        <p class="text-sm text-charcoal mt-2">Publish news from the admin panel to show it here.</p>
                    </div>
                @endforelse
            </div>

            @if ($newsPage->hasPages())
                <div class="mt-10">{{ $newsPage->links() }}</div>
            @endif
        </div>
    </section>

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
                        <button type="button" class="bg-brand-red hover:bg-brand-darkRed text-white font-bold px-6 py-3 rounded-lg text-sm shadow transition-colors duration-150 whitespace-nowrap">Subscribe Alerts</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
