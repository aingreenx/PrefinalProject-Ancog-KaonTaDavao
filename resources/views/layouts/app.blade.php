<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#1e3b2c">
    <title>Kaon Ta! Davao – Ancog's Food Guide</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Big+Shoulders+Display:wght@700;800;900&family=Permanent+Marker&family=Public+Sans:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-screen flex-col bg-paper font-sans text-ink antialiased">
    <a href="#main" class="sr-only focus:not-sr-only focus:absolute focus:left-4 focus:top-4 focus:z-50 focus:rounded focus:bg-luyang focus:px-3 focus:py-2 focus:font-semibold">Skip to content</a>

    <header class="bg-board text-chalk">
        <div class="mx-auto flex max-w-6xl flex-col gap-4 px-4 pb-5 pt-5 md:flex-row md:items-end md:justify-between">
            <a href="{{ route('home') }}" class="font-display text-3xl font-black leading-none tracking-tight text-luyang hover:text-[#f0b434] sm:text-4xl">Kaon Ta! Davao – Ancog's Food Guide</a>
            @include('partials.nav')
        </div>
    </header>
    <div class="awning" aria-hidden="true"></div>

    <main id="main" class="mx-auto w-full max-w-6xl flex-1 px-4 pb-16 pt-8">
        @include('partials.flash')
        @yield('content')
    </main>

    <footer class="border-t border-line">
        <div class="mx-auto flex max-w-6xl flex-col gap-1 px-4 py-6 text-sm text-ink-soft sm:flex-row sm:justify-between">
            <p>Carinderias and eateries of Davao City, listed by district.</p>
            <p>Kaon ta! — Let's eat!</p>
        </div>
    </footer>
</body>
</html>
