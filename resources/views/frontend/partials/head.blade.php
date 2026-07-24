<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'eDegree+ | Accredited Online University Degree Programs')</title>
    <meta name="description" content="@yield('meta_description', 'Advance your career with internationally accredited online university degrees. Discover online MBA, DBA, Master and Bachelor programs from top global institutions.')">
    <link rel="icon" type="image/png" href="{{ ! empty($siteinfo?->favicon) ? asset($siteinfo->favicon) : asset('frontend/assets/img/favicon.png') }}">
    <link rel="canonical" href="{{ url()->current() }}">

    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', 'eDegree+')">
    <meta property="og:description" content="@yield('meta_description', 'Discover accredited online university programs with eDegree+.')">
    <meta property="og:image" content="{{ asset('frontend/assets/img/edegree-plus-logo.png') }}">
    <meta name="twitter:card" content="summary_large_image">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Sora:wght@500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/style.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/lucide@0.321.0/dist/umd/lucide.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            red: '#E13334',
                            darkRed: '#B8262A',
                            tint: '#FDECEC',
                            dark: '#141414',
                            successGreen: '#1F8A55',
                            warningGold: '#F5A623'
                        },
                        ink: '#161616',
                        charcoal: '#4B4B4B',
                        mutedGray: '#7A7A7A',
                        borderGray: '#E7E7E7',
                        altBg: '#F8F7F7'
                    },
                    fontFamily: {
                        heading: ['Sora', 'sans-serif'],
                        body: ['Inter', 'sans-serif']
                    },
                    borderRadius: {
                        custom: '12px'
                    }
                }
            }
        }
    </script>
    @stack('styles')
</head>
