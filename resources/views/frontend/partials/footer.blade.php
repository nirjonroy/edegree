<footer class="bg-brand-dark text-brand-tint/70 border-t border-white/10 pt-16 pb-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-8 mb-12">
            <div>
                <a href="{{ route('frontend.home') }}" class="flex items-center mb-4">
                    <img src="{{ ! empty($siteinfo?->logo) ? asset($siteinfo->logo) : asset('frontend/assets/img/edegree-plus-white-logo.png') }}" alt="eDegree+" class="h-10 w-auto">
                </a>
                <p class="text-xs text-brand-tint/50 leading-relaxed mb-4">
                    {{ $siteinfo?->footer_contact_note ?: 'Connecting professionals with premium, accredited online university degree programs worldwide.' }}
                </p>
                <div class="flex space-x-3">
                    <a href="#" class="text-brand-tint/50 hover:text-white transition"><i data-lucide="linkedin" class="w-4 h-4"></i></a>
                    <a href="#" class="text-brand-tint/50 hover:text-white transition"><i data-lucide="twitter" class="w-4 h-4"></i></a>
                    <a href="#" class="text-brand-tint/50 hover:text-white transition"><i data-lucide="instagram" class="w-4 h-4"></i></a>
                    <a href="#" class="text-brand-tint/50 hover:text-white transition"><i data-lucide="youtube" class="w-4 h-4"></i></a>
                </div>
            </div>

            <div>
                <h4 class="font-heading font-bold text-white text-xs uppercase tracking-wider mb-4">Programs</h4>
                <ul class="space-y-2 text-xs">
                    @forelse (($programCategories ?? collect())->take(5) as $category)
                        <li><a href="{{ route('frontend.programs.index', ['degree' => $category->name]) }}" class="hover:text-white transition">{{ $category->name }}</a></li>
                    @empty
                        <li><a href="{{ route('frontend.programs.index', ['degree' => 'MBA']) }}" class="hover:text-white transition">MBA Programs</a></li>
                        <li><a href="{{ route('frontend.programs.index', ['degree' => 'DBA']) }}" class="hover:text-white transition">DBA Doctorates</a></li>
                        <li><a href="{{ route('frontend.programs.index') }}" class="hover:text-white transition font-semibold text-brand-red">View All Programs</a></li>
                    @endforelse
                </ul>
            </div>

            <div>
                <h4 class="font-heading font-bold text-white text-xs uppercase tracking-wider mb-4">Universities</h4>
                <ul class="space-y-2 text-xs">
                    @forelse (($universities ?? collect())->take(4) as $university)
                        <li><a href="{{ route('frontend.universities.show', $university->slug) }}" class="hover:text-white transition">{{ $university->name }}</a></li>
                    @empty
                        <li><a href="{{ route('frontend.universities.index') }}" class="hover:text-white transition">Partner Universities</a></li>
                    @endforelse
                    <li><a href="{{ route('frontend.universities.index') }}" class="hover:text-white transition font-semibold text-brand-red">View All Partners &rarr;</a></li>
                </ul>
            </div>

            <div>
                <h4 class="font-heading font-bold text-white text-xs uppercase tracking-wider mb-4">Resources</h4>
                <ul class="space-y-2 text-xs">
                    <li><a href="{{ route('frontend.blog.index') }}" class="hover:text-white transition">Insights Blog</a></li>
                    <li><a href="{{ url('/frontend/news.html') }}" class="hover:text-white transition">Admissions News</a></li>
                    <li><a href="{{ url('/frontend/about.html#faq') }}" class="hover:text-white transition">Common FAQs</a></li>
                </ul>
            </div>

            <div>
                <h4 class="font-heading font-bold text-white text-xs uppercase tracking-wider mb-4">Company</h4>
                <ul class="space-y-2 text-xs">
                    <li><a href="{{ url('/frontend/about.html') }}" class="hover:text-white transition">About Us</a></li>
                    <li><a href="{{ url('/frontend/privacy-policy.html') }}" class="hover:text-white transition">Privacy Policy</a></li>
                    <li><a href="{{ url('/frontend/terms.html') }}" class="hover:text-white transition">Terms of Service</a></li>
                    <li><a href="{{ url('/frontend/sitemap.html') }}" class="hover:text-white transition">Sitemap</a></li>
                    <li><a href="{{ url('/frontend/contact.html') }}" class="hover:text-white transition">Contact Us</a></li>
                </ul>
            </div>
        </div>

        <div class="border-t border-white/10 pt-8 mt-8 flex flex-col md:flex-row justify-between items-center text-xs">
            <p class="mb-4 md:mb-0">&copy; {{ date('Y') }} eDegree+. All rights reserved.</p>
            <div class="flex space-x-4">
                <a href="{{ url('/frontend/privacy-policy.html') }}" class="hover:text-white transition">Privacy</a>
                <a href="{{ url('/frontend/terms.html') }}" class="hover:text-white transition">Terms</a>
                <a href="{{ url('/frontend/sitemap.html') }}" class="hover:text-white transition">Sitemap</a>
            </div>
        </div>
        <div class="mt-6 text-center text-[10px] text-brand-tint/30 leading-relaxed border-t border-white/5 pt-6">
            eDegree+ is an information and discovery platform. Program details, tuition structure, admissions eligibility, and accreditation standards are determined solely by the respective partner universities.
        </div>
    </div>
</footer>
