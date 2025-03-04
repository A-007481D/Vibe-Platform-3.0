<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Ajouter un ami
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Rechercher un utilisateur</h3>
                
                <form action="{{ route('friends.search') }}" method="GET" class="flex items-center space-x-4">
                    <input 
                        type="text" 
                        name="query" 
                        placeholder="Rechercher un utilisateur" 
                        required
                        class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    >
                    <button 
                        type="submit" 
                        class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700"
                    >
                        Rechercher
                    </button>
                </form>
            </div>

            @if(isset($users))
            <div class="mt-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Résultats de la recherche</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($users as $user)
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <div class="flex items-center space-x-4">
                            <img 
                                src="{{ $user->profile_photo_url }}" 
                                alt="{{ $user->name }}" 
                                class="w-12 h-12 rounded-full"
                            >
                            <div>
                                <h4 class="text-md font-semibold text-gray-800">{{ $user->name }}</h4>
                                <p class="text-sm text-gray-500">{{ $user->email }}</p>
                            </div>
                        </div>
                        
                        <div class="mt-4">
                            @if(!$user->isFriend())
                                <form 
                                    action="{{ route('friends.request', $user->id) }}" 
                                    method="POST" 
                                    class="inline"
                                >
                                    @csrf
                                    <button 
                                        type="submit" 
                                        class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700"
                                    >
                                        Ajouter comme ami
                                    </button>
                                </form>
                            @else
                                <span class="inline-block px-4 py-2 bg-gray-200 text-gray-600 rounded-lg">
                                    Demande envoyée
                                </span>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>