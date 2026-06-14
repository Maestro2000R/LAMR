<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mini-CRM</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 text-gray-900">
<div class="container mx-auto p-4">
    <header class="mb-6">
        <nav class="flex gap-4 items-center justify-between">
            <div class="flex gap-4">
                <a href="{{ route('agents.index') }}" class="text-blue-600">Agents</a>
                <a href="{{ route('sites.index') }}" class="text-blue-600">Sites</a>
                <a href="{{ route('assignments.index') }}" class="text-blue-600">Affectations</a>
            </div>

            <div>
                @if (Route::has('login'))
                    @auth
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button class="text-red-600">Déconnexion</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 mr-2">Connexion</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="text-gray-700">Inscription</a>
                        @endif
                    @endauth
                @endif
            </div>
        </nav>
    </header>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">{{ session('success') }}</div>
    @endif

    @yield('content')
</div>
</body>
</html>
