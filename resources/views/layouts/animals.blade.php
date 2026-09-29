<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', 'Animales') | {{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @stack('styles')
    </head>
    <body class="min-h-screen bg-slate-900 font-sans text-slate-100 antialiased">
        <div class="flex min-h-screen flex-col">
            <header class="border-b border-slate-800 bg-slate-900/95 backdrop-blur">
                <div class="mx-auto flex w-full max-w-7xl items-center justify-between px-4 py-4 sm:px-6 lg:px-8">
                    <a href="{{ url('/') }}" class="text-lg font-semibold tracking-tight text-white transition hover:text-sky-300">
                        {{ config('app.name', 'Registro') }}
                    </a>

                    @yield('header-actions')
                </div>
            </header>

            @hasSection('page-header')
                <section class="border-b border-slate-800 bg-slate-900">
                    <div class="mx-auto w-full max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
                        @yield('page-header')
                    </div>
                </section>
            @endif

            <main class="flex-1">
                <div class="mx-auto w-full max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
                    @php
                        $rawTimeout = session('timeout') ?? session('timer') ?? session('temporizador') ?? session('tiempo') ?? 3000;
                        $timeoutMs = (is_numeric($rawTimeout) && $rawTimeout < 100) ? (int)$rawTimeout * 1000 : (int)$rawTimeout;
                    @endphp

                    @if (session('success'))
                        <div class="flash-alert mb-6 flex items-center justify-between rounded-lg border border-emerald-500/40 bg-emerald-500/10 p-4 text-emerald-200 shadow-sm transition-all duration-500" data-timeout="{{ $timeoutMs }}" role="alert">
                            <div class="flex items-center gap-3">
                                <svg class="h-5 w-5 shrink-0 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="text-sm font-medium">{{ session('success') }}</span>
                            </div>
                            <button type="button" onclick="this.closest('.flash-alert').remove()" class="ml-4 text-lg font-bold text-emerald-400 hover:text-emerald-200" title="Cerrar">&times;</button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="flash-alert mb-6 flex items-center justify-between rounded-lg border border-rose-500/40 bg-rose-500/10 p-4 text-rose-200 shadow-sm transition-all duration-500" data-timeout="{{ $timeoutMs }}" role="alert">
                            <div class="flex items-center gap-3">
                                <svg class="h-5 w-5 shrink-0 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="text-sm font-medium">{{ session('error') }}</span>
                            </div>
                            <button type="button" onclick="this.closest('.flash-alert').remove()" class="ml-4 text-lg font-bold text-rose-400 hover:text-rose-200" title="Cerrar">&times;</button>
                        </div>
                    @endif

                    @if (session('warning'))
                        <div class="flash-alert mb-6 flex items-center justify-between rounded-lg border border-amber-500/40 bg-amber-500/10 p-4 text-amber-200 shadow-sm transition-all duration-500" data-timeout="{{ $timeoutMs }}" role="alert">
                            <div class="flex items-center gap-3">
                                <svg class="h-5 w-5 shrink-0 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                                <span class="text-sm font-medium">{{ session('warning')}}</span>
                            </div>
                            <button type="button" onclick="this.closest('.flash-alert').remove()" class="ml-4 text-lg font-bold text-amber-400 hover:text-amber-200" title="Cerrar">&times;</button>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </main>

            <footer class="border-t border-slate-800 bg-slate-950">
                <div class="mx-auto flex w-full max-w-7xl flex-col gap-2 px-4 py-6 text-sm text-slate-400 sm:flex-row sm:items-center sm:justify-between sm:px-6 lg:px-8">
                    @yield('footer', 'Registro de animales')
                    <span>{{ now()->year }} &copy; {{ config('app.name', 'Laravel') }}</span>
                </div>
            </footer>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const alerts = document.querySelectorAll('.flash-alert');
                alerts.forEach(alert => {
                    const timeout = parseInt(alert.dataset.timeout, 10) || 3000;
                    setTimeout(() => {
                        alert.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                        alert.style.opacity = '0';
                        alert.style.transform = 'translateY(-10px)';
                        setTimeout(() => alert.remove(), 500);
                    }, timeout);
                });
            });
        </script>

        @stack('scripts')
    </body>
</html>