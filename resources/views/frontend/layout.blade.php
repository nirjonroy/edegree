<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ $siteinfo?->text_direction ?: 'ltr' }}">
@include('frontend.partials.head')
<body class="font-body text-charcoal bg-white min-h-screen flex flex-col" data-theme="{{ $siteinfo?->default_theme ?: 'light' }}" x-data>
    {!! $siteinfo?->body_scripts !!}

    @include('frontend.partials.header')
    @include('frontend.partials.search-overlay')

    <main class="flex-grow">
        @yield('content')
    </main>

    @include('frontend.partials.footer')

    @isset($frontendData)
        <script>
            window.eDegreeDbData = @json($frontendData);
        </script>
    @endisset
    <script src="{{ asset('frontend/assets/js/main.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (document.querySelector('.partner-swiper')) {
                new Swiper('.partner-swiper', {
                    slidesPerView: 2,
                    spaceBetween: 20,
                    loop: true,
                    autoplay: { delay: 2500, disableOnInteraction: false },
                    breakpoints: {
                        640: { slidesPerView: 3, spaceBetween: 20 },
                        768: { slidesPerView: 4, spaceBetween: 30 },
                        1024: { slidesPerView: 5, spaceBetween: 40 }
                    }
                });
            }

            if (document.querySelector('.testimonial-swiper')) {
                new Swiper('.testimonial-swiper', {
                    slidesPerView: 1,
                    spaceBetween: 30,
                    loop: true,
                    pagination: { el: '.swiper-pagination', clickable: true },
                    autoplay: { delay: 5000, disableOnInteraction: false }
                });
            }

            if (typeof AOS !== 'undefined') {
                AOS.init({ duration: 800, once: true });
            }
        });
    </script>
    @stack('scripts')
    {!! $siteinfo?->footer_scripts !!}
</body>
</html>
