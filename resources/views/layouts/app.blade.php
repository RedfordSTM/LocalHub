<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'LocalHub'))</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 text-slate-800 antialiased">
    <header class="border-b border-slate-200 bg-white">
        <div class="mx-auto flex max-w-5xl items-center justify-between px-4 py-3">
            <a href="{{ url('/') }}" class="text-lg font-semibold text-slate-900">
                {{ config('app.name', 'LocalHub') }}
            </a>
            <nav class="flex items-center gap-3 text-sm">
                <a href="{{ route('publications.index') }}"
                   class="rounded-md px-3 py-1.5 text-slate-600 hover:bg-slate-100 hover:text-slate-900">
                    Publications
                </a>
                <a href="{{ route('publications.create') }}"
                   class="rounded-md bg-slate-900 px-3 py-1.5 font-medium text-white hover:bg-slate-700">
                    Nouvelle publication
                </a>
            </nav>
        </div>
    </header>

    <main class="mx-auto max-w-5xl px-4 py-8">
        @if (session('status'))
            <div class="mb-6 rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                {{ session('status') }}
            </div>
        @endif

        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>
