<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BiblioTech - @yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex flex-col bg-slate-100 text-slate-900 antialiased">
    <header class="sticky top-0 z-50 px-4 pt-4">
    <nav class="relative max-w-6xl mx-auto">
        <div class="flex h-14 items-center justify-between rounded-full border border-slate-200 bg-white pl-6 pr-2 shadow-sm">
            <a href="{{ route('dashboard') }}" class="text-lg font-semibold text-slate-900">BiblioTech</a>

            @auth
                @php
                    $liens = [
                        ['route' => 'dashboard',       'pattern' => 'dashboard',   'label' => 'Tableau de bord'],
                        ['route' => 'livres.index',    'pattern' => 'livres.*',    'label' => 'Livres'],
                        ['route' => 'adherents.index', 'pattern' => 'adherents.*', 'label' => 'Adhérents'],
                        ['route' => 'emprunts.index',  'pattern' => 'emprunts.*',  'label' => 'Emprunts'],
                    ];
                @endphp

                <div class="hidden md:flex items-center gap-1">
                    @foreach ($liens as $lien)
                        <a href="{{ route($lien['route']) }}"
                           class="rounded-full px-4 py-2 text-sm font-medium transition-colors {{ request()->routeIs($lien['pattern']) ? 'bg-slate-900 text-white' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                            {{ $lien['label'] }}
                        </a>
                    @endforeach

                    <form action="{{ route('logout') }}" method="POST" class="ml-1">
                        @csrf
                        <button type="submit" class="rounded-full border border-slate-200 px-4 py-2 text-sm font-medium text-slate-700 transition-colors hover:bg-slate-100">
                            Déconnecter
                        </button>
                    </form>
                </div>

                <button type="button" id="menu-toggle" class="md:hidden rounded-full p-2.5 text-slate-700 hover:bg-slate-100" aria-label="Menu">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            @endauth
        </div>

        @auth
            <div id="menu-mobile" class="hidden md:hidden absolute inset-x-0 top-16 rounded-2xl border border-slate-200 bg-white p-2 shadow-md space-y-1">
                @foreach ($liens as $lien)
                    <a href="{{ route($lien['route']) }}"
                       class="block rounded-xl px-4 py-2.5 text-sm font-medium {{ request()->routeIs($lien['pattern']) ? 'bg-slate-900 text-white' : 'text-slate-600 hover:bg-slate-100' }}">
                        {{ $lien['label'] }}
                    </a>
                @endforeach
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="block w-full rounded-xl px-4 py-2.5 text-left text-sm font-medium text-slate-600 hover:bg-slate-100">
                        Déconnecter
                    </button>
                </form>
            </div>
        @endauth
    </nav>
</header>

    <main class="flex-1 w-full max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        @if (session('success'))
            <div class="mb-4 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">{{ session('error') }}</div>
        @endif

        @yield('corps')
    </main>

    <footer class="border-t border-slate-200 bg-white">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-4 text-sm text-slate-500">BiblioTech - Bibliothèque</div>
    </footer>
</body>
</html>
