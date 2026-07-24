@php
    $subscribeSection = $subscribeSection ?? null;
@endphp

<section class="py-16 bg-brand-dark text-white relative" x-data="subscribeSection()">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
            <div class="lg:col-span-7">
                <h2 class="font-heading font-bold text-2xl md:text-3xl text-white mb-2">{{ $subscribeSection?->title ?? 'Stay Ahead in Your Career' }}</h2>
                <p class="text-sm text-brand-tint/70">{{ $subscribeSection?->subtitle ?? 'Subscribe to receive program alerts, scholarship updates, and university admissions deadlines.' }}</p>
            </div>
            <div class="lg:col-span-5">
                <form @submit.prevent="subscribe()" class="flex flex-col sm:flex-row gap-3">
                    <input type="email" placeholder="{{ $subscribeSection?->input_placeholder ?? 'Enter your work email' }}" x-model="email" class="flex-grow px-4 py-3 bg-white/10 border border-white/20 rounded-lg text-white placeholder-brand-tint/50 focus:ring-2 focus:ring-brand-red focus:border-transparent focus:outline-none text-sm transition-all duration-150">
                    <button type="submit" class="bg-brand-red hover:bg-brand-darkRed text-white font-bold px-6 py-3 rounded-lg text-sm shadow transition-colors duration-150 whitespace-nowrap">{{ $subscribeSection?->button_text ?? 'Subscribe Alerts' }}</button>
                </form>
                <p class="mt-2 text-[10px] text-brand-tint/50 flex items-center">
                    <i data-lucide="shield-check" class="w-3 h-3 mr-1"></i>
                    <span>{{ $subscribeSection?->privacy_note ?? 'No spam. Unsubscribe at any time.' }}</span>
                </p>
            </div>
        </div>
    </div>
</section>
