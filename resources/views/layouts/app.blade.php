<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kaon Ta! Davao – Ancog's Food Guide</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-screen flex-col bg-stone-50 text-stone-800 antialiased">
    <header class="bg-orange-600 text-white shadow">
        <div class="mx-auto flex max-w-6xl flex-col gap-3 px-4 py-4 md:flex-row md:items-center md:justify-between">
            <a href="{{ route('home') }}" class="text-xl font-bold tracking-tight">Kaon Ta! Davao – Ancog's Food Guide</a>
            @include('partials.nav')
        </div>
    </header>

    <main class="mx-auto w-full max-w-6xl flex-1 px-4 py-8">
        @include('partials.flash')
        @yield('content')
    </main>

    <footer class="border-t border-stone-200 py-6 text-center text-sm text-stone-500">
        Carinderias &amp; eateries of Davao City
    </footer>
</body>
</html>
