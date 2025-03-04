<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Rechercher des utilisateurs') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <!-- Formulaire de recherche -->
                <form action="{{ route('search.perform') }}" method="POST" class="mb-6">
                    @csrf
                    <div class="flex gap-4">
                        <input type="text" name="query" value="{{ old('query', $query ?? '') }}"
                            placeholder="Rechercher par nom ou email..."
                            class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            required>
                        <button type="submit"
                            class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            Rechercher
                        </button>
                    </div>
                </form>

                <!-- Messages d'erreur/succès -->
                @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                    {{ session('error') }}
                </div>
                @endif

                <!-- Résultats de recherche -->
                @if(isset($users) && $users->count() > 0)
                <div class="space-y-4">
                    @foreach($users as $user)
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}"
                                    class="h-10 w-10 rounded-full">
                            </div>
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">{{ $user->name }}</h3>
                                <p class="text-sm text-gray-500">{{ $user->email }}</p>
                            </div>
                        </div>
                        <div>
                            <!-- Simple affichage des informations sans lien vers le profil -->
                            <span
                                class="inline-flex items-center px-4 py-2 bg-gray-100 border border-gray-200 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest">
                                Utilisateur
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
                @elseif(isset($users))
                <div class="text-center py-4 text-gray-500">
                    Aucun utilisateur trouvé pour cette recherche.
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>