@php
    $siteinfo = \App\Models\Siteinfo::latest()->first();
    $brandName = $siteinfo?->sidebar_lg_header ?: 'eDegree+';
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Login | {{ $brandName }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: Figtree, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }
        .login-shell {
            min-height: 100vh;
            background:
                linear-gradient(90deg, rgba(15, 23, 42, 0.86), rgba(15, 23, 42, 0.62)),
                url('{{ asset('adminlte/assets/img/photo1.png') }}') center/cover no-repeat;
        }
    </style>
</head>
<body class="antialiased text-slate-900">
    <main class="login-shell flex items-center justify-center px-4 py-10">
        <div class="w-full max-w-6xl overflow-hidden rounded-[2rem] bg-white shadow-2xl ring-1 ring-white/20 md:grid md:grid-cols-[1.05fr_0.95fr]">
            <section class="relative hidden min-h-[620px] bg-slate-950 p-12 text-white md:flex md:flex-col md:justify-between">
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_20%_20%,rgba(239,68,68,0.34),transparent_30%),linear-gradient(135deg,rgba(15,23,42,0.35),rgba(15,23,42,0.9))]"></div>
                <div class="relative">
                    <a href="/" class="inline-flex items-center gap-3">
                        @if ($siteinfo?->logo)
                            <img src="/{{ $siteinfo->logo }}" alt="{{ $brandName }}" class="h-12 w-auto rounded bg-white px-2 py-1">
                        @else
                            <span class="inline-flex h-11 w-11 items-center justify-center rounded-full bg-white text-xl font-black text-red-600">e</span>
                            <span class="text-2xl font-extrabold">{{ $brandName }}</span>
                        @endif
                    </a>
                </div>

                <div class="relative max-w-xl">
                    <span class="inline-flex rounded-full border border-red-300/40 bg-red-500/20 px-4 py-2 text-sm font-semibold text-red-50">Admin Portal</span>
                    <h1 class="mt-6 text-5xl font-extrabold leading-tight tracking-tight">Manage your eDegree platform with clarity.</h1>
                    <p class="mt-5 text-lg leading-8 text-slate-200">Control programs, universities, content, users, permissions, analytics, and site settings from one dashboard.</p>
                </div>

                <div class="relative grid grid-cols-3 gap-4 text-sm text-slate-200">
                    <div class="rounded-2xl border border-white/10 bg-white/10 p-4">
                        <div class="text-2xl font-bold text-white">24/7</div>
                        <div>Access</div>
                    </div>
                    <div class="rounded-2xl border border-white/10 bg-white/10 p-4">
                        <div class="text-2xl font-bold text-white">RBAC</div>
                        <div>Protected</div>
                    </div>
                    <div class="rounded-2xl border border-white/10 bg-white/10 p-4">
                        <div class="text-2xl font-bold text-white">Live</div>
                        <div>Tracking</div>
                    </div>
                </div>
            </section>

            <section class="px-6 py-10 sm:px-12 md:px-14 md:py-16">
                <div class="mx-auto max-w-md">
                    <div class="mb-10 text-center md:hidden">
                        <a href="/" class="inline-flex items-center justify-center gap-3">
                            @if ($siteinfo?->logo)
                                <img src="/{{ $siteinfo->logo }}" alt="{{ $brandName }}" class="h-12 w-auto">
                            @else
                                <span class="inline-flex h-11 w-11 items-center justify-center rounded-full bg-red-600 text-xl font-black text-white">e</span>
                                <span class="text-2xl font-extrabold">{{ $brandName }}</span>
                            @endif
                        </a>
                    </div>

                    <div>
                        <p class="text-sm font-semibold uppercase tracking-[0.2em] text-red-600">Welcome Back</p>
                        <h2 class="mt-3 text-3xl font-extrabold tracking-tight text-slate-950">Admin Login</h2>
                        <p class="mt-2 text-sm text-slate-500">Sign in with your administrator account to continue.</p>
                    </div>

                    <x-auth-session-status class="mt-6" :status="session('status')" />

                    <form method="POST" action="{{ url('/admin/login') }}" class="mt-8 space-y-5">
                        @csrf

                        <div>
                            <label for="email" class="mb-2 block text-sm font-semibold text-slate-700">Email Address</label>
                            <input id="email" type="email" name="email" value="{{ old('email', 'admin24@gmail.com') }}" required autofocus autocomplete="username" class="block w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 text-base shadow-sm transition focus:border-red-500 focus:bg-white focus:ring-red-500">
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <div>
                            <div class="mb-2 flex items-center justify-between">
                                <label for="password" class="block text-sm font-semibold text-slate-700">Password</label>
                            </div>
                            <input id="password" type="password" name="password" required autocomplete="current-password" class="block w-full rounded-xl border-slate-200 bg-slate-50 px-4 py-3 text-base shadow-sm transition focus:border-red-500 focus:bg-white focus:ring-red-500">
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <label for="remember_me" class="flex items-center gap-3 text-sm text-slate-600">
                            <input id="remember_me" type="checkbox" class="rounded border-slate-300 text-red-600 shadow-sm focus:ring-red-500" name="remember">
                            <span>Keep me signed in</span>
                        </label>

                        <button type="submit" class="inline-flex w-full items-center justify-center rounded-xl bg-red-600 px-5 py-3 text-sm font-bold uppercase tracking-wide text-white shadow-lg shadow-red-600/25 transition hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-200">
                            Log In
                        </button>
                    </form>

                    <p class="mt-8 text-center text-xs text-slate-400">Protected admin access for {{ $brandName }}.</p>
                </div>
            </section>
        </div>
    </main>
</body>
</html>
