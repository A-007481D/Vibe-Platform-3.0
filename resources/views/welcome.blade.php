<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vibe - Connectez-vous avec le monde</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gradient-to-br from-indigo-100 to-white">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-12 w-auto">
                </div>

                <div class="flex items-center space-x-4">
                    @auth
                    <!-- Utilisateur connecté -->
                    <span class="text-gray-600">
                        Bienvenue, <span class="font-semibold">{{ Auth::user()->pseudo }}</span>
                    </span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition duration-300"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                            Déconnexion
                        </button>
                    </form>
                    @else
                    <!-- Utilisateur non connecté -->
                    <a href="{{ route('login') }}" class="text-gray-600 hover:text-indigo-600">Connexion</a>
                    <a href="{{ route('register') }}"
                        class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition duration-300">Inscription</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="relative bg-white overflow-hidden">
        <div class="max-w-7xl mx-auto">
            <div class="relative z-10 pb-8 bg-white sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32">
                <main class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28">
                    <div class="sm:text-center lg:text-left">
                        <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 sm:text-5xl md:text-6xl">
                            <span class="block">Bienvenue sur</span>
                            <span class="block text-indigo-600">Vibe</span>
                        </h1>
                        <p
                            class="mt-3 text-base text-gray-500 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                            Rejoignez notre communauté vibrante et connectez-vous avec des personnes partageant vos
                            intérêts.
                        </p>
                        <br>
                        @auth
                        <a href="/dashboard"
                            class="text-gray-600 bg-green-400 hover:text-indigo-600 px-4 py-2 mt-2 rounded-lg transition duration-300">
                            Accéder au site
                        </a>
                        @endauth
                        @guest
                        <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start">
                            <div class="rounded-md shadow">
                                <a href="{{ route('register') }}"
                                    class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 md:py-4 md:text-lg md:px-10">
                                    Commencer
                                </a>
                            </div>
                        </div>
                        @endguest
                    </div>
                </main>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="py-12 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                    Fonctionnalités principales
                </h2>
            </div>
            <div class="mt-10">
                <div class="grid grid-cols-1 gap-10 sm:grid-cols-2 lg:grid-cols-3">
                    <!-- Feature 1 -->
                    <div class="flex flex-col items-center p-6 bg-gray-50 rounded-lg">
                        <div class="p-3 bg-indigo-100 rounded-full">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">Sécurité avancée</h3>
                        <p class="mt-2 text-base text-gray-500 text-center">
                            Authentification robuste et protection des données personnelles garantie.
                        </p>
                    </div>

                    <!-- Feature 2 -->
                    <div class="flex flex-col items-center p-6 bg-gray-50 rounded-lg">
                        <div class="p-3 bg-indigo-100 rounded-full">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">Profil personnalisable</h3>
                        <p class="mt-2 text-base text-gray-500 text-center">
                            Exprimez-vous avec un profil unique et personnalisé.
                        </p>
                    </div>

                    <!-- Feature 3 -->
                    <div class="flex flex-col items-center p-6 bg-gray-50 rounded-lg">
                        <div class="p-3 bg-indigo-100 rounded-full">
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <h3 class="mt-4 text-lg font-medium text-gray-900">Recherche intuitive</h3>
                        <p class="mt-2 text-base text-gray-500 text-center">
                            Trouvez facilement d'autres membres grâce à notre système de recherche performant.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-50">
        <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <p class="text-base text-gray-400">&copy; 2024 Vibe. Tous droits réservés.</p>
            </div>
        </div>
    </footer>
</body>

</html>