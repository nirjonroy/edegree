@extends('frontend.layout')

@section('title', ($contactPage?->meta_title ?: (($contactPage?->page_title ?: 'Contact eDegree+').' | eDegree+')))
@section('meta_description', $contactPage?->meta_description ?: 'Contact eDegree+ for student counseling support, university listing requests, and advertising inquiries.')
@section('seos')
    @include('frontend.partials.seos', ['seoModel' => $contactPage, 'seo' => [
        'title' => $contactPage?->page_title ?: 'Contact eDegree+',
        'description' => $contactPage?->subtitle ?: 'Contact eDegree+ for student counseling support, university listing requests, and advertising inquiries.',
        'url' => route('frontend.contact'),
    ]])
@endsection

@section('content')
    <main class="flex-grow bg-altBg py-12" x-data="{ name: '', email: '', subject: '', message: '', success: false }">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex mb-6 text-xs font-semibold uppercase tracking-wider text-mutedGray space-x-2">
                <a href="{{ route('frontend.home') }}" class="hover:text-brand-red">Home</a>
                <span>/</span>
                <span class="text-ink">Contact Us</span>
            </nav>

            <div class="mb-10 text-center">
                <h1 class="font-heading font-bold text-3xl md:text-4xl text-ink mb-3">{{ $contactPage?->page_title ?: 'Contact eDegree+' }}</h1>
                <p class="text-charcoal text-sm max-w-2xl mx-auto">{{ $contactPage?->subtitle ?: 'Get in touch with our team for student counseling support, university listing requests, or advertising inquiries.' }}</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-12 gap-8">
                <div class="md:col-span-5 space-y-6">
                    <div class="bg-white border border-borderGray p-6 rounded-custom shadow-sm space-y-4">
                        <h3 class="font-heading font-bold text-lg text-ink mb-2">{{ $contactPage?->details_title ?: 'Connect Directly' }}</h3>

                        <div class="flex items-start space-x-3 text-sm">
                            <i data-lucide="mail" class="w-5 h-5 text-brand-red flex-shrink-0 mt-0.5"></i>
                            <div>
                                <strong class="block text-ink font-semibold text-xs uppercase tracking-wider">{{ $contactPage?->email_label ?: 'Email Inquiry' }}</strong>
                                <a href="mailto:{{ $contactPage?->email ?: 'support@edegreeplus.com' }}" class="text-brand-red hover:underline text-xs">{{ $contactPage?->email ?: 'support@edegreeplus.com' }}</a>
                            </div>
                        </div>

                        <div class="flex items-start space-x-3 text-sm border-t border-borderGray/50 pt-4">
                            <i data-lucide="phone" class="w-5 h-5 text-brand-red flex-shrink-0 mt-0.5"></i>
                            <div>
                                <strong class="block text-ink font-semibold text-xs uppercase tracking-wider">{{ $contactPage?->phone_label ?: 'Support Hotlines' }}</strong>
                                <span class="text-charcoal text-xs block">{{ $contactPage?->phone_1 ?: '+1 (800) 555-DEGREE' }}</span>
                                <span class="text-charcoal text-xs block">{{ $contactPage?->phone_2 ?: '+44 (0) 20 7946 0958' }}</span>
                            </div>
                        </div>

                        <div class="flex items-start space-x-3 text-sm border-t border-borderGray/50 pt-4">
                            <i data-lucide="map-pin" class="w-5 h-5 text-brand-red flex-shrink-0 mt-0.5"></i>
                            <div>
                                <strong class="block text-ink font-semibold text-xs uppercase tracking-wider">{{ $contactPage?->office_label ?: 'Corporate Offices' }}</strong>
                                <span class="text-charcoal text-xs block">{{ $contactPage?->office_1 ?: '100 Pine Street, San Francisco, CA 94111' }}</span>
                                <span class="text-charcoal text-xs block">{{ $contactPage?->office_2 ?: '168 Clifton St, London EC2A 4DP, UK' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="md:col-span-7">
                    <div class="bg-white border border-borderGray p-6 md:p-8 rounded-custom shadow-sm">
                        <h3 class="font-heading font-bold text-lg text-ink mb-4">{{ $contactPage?->form_title ?: 'Send a Message' }}</h3>
                        <form @submit.prevent="success = true" class="space-y-4">
                            <div>
                                <label class="block text-xs font-bold text-charcoal mb-1">Your Name</label>
                                <input type="text" required placeholder="{{ $contactPage?->name_placeholder ?: 'John Doe' }}" x-model="name" class="w-full p-2.5 bg-altBg border border-borderGray rounded-lg text-sm text-ink focus:ring-2 focus:ring-brand-red focus:outline-none">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-charcoal mb-1">Email Address</label>
                                <input type="email" required placeholder="{{ $contactPage?->email_placeholder ?: 'john.doe@company.com' }}" x-model="email" class="w-full p-2.5 bg-altBg border border-borderGray rounded-lg text-sm text-ink focus:ring-2 focus:ring-brand-red focus:outline-none">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-charcoal mb-1">Subject</label>
                                <input type="text" required placeholder="{{ $contactPage?->subject_placeholder ?: 'Listing assistance / Student support' }}" x-model="subject" class="w-full p-2.5 bg-altBg border border-borderGray rounded-lg text-sm text-ink focus:ring-2 focus:ring-brand-red focus:outline-none">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-charcoal mb-1">Message</label>
                                <textarea rows="4" required placeholder="{{ $contactPage?->message_placeholder ?: 'Describe your question in detail...' }}" x-model="message" class="w-full p-2.5 bg-altBg border border-borderGray rounded-lg text-sm text-ink focus:ring-2 focus:ring-brand-red focus:outline-none"></textarea>
                            </div>
                            <button type="submit" class="w-full bg-brand-red hover:bg-brand-darkRed text-white py-3 rounded-lg font-bold shadow text-sm transition-colors duration-150">
                                {{ $contactPage?->button_text ?: 'Submit Message' }}
                            </button>
                        </form>
                        <div class="mt-4 p-4 bg-brand-tint border border-brand-red/25 rounded-lg text-center" x-show="success" style="display: none;">
                            <h4 class="text-xs font-bold text-brand-red mb-1">{{ $contactPage?->success_title ?: 'Message Sent Successfully!' }}</h4>
                            <p class="text-[10px] text-charcoal">{{ $contactPage?->success_message ?: 'We have received your message and support teams will reply within 24 hours.' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
