<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Demandes d'amis en attente
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Vos demandes en attente</h3>
                
                @if($pendingRequests->isEmpty())
                    <p class="text-gray-500">Aucune demande d'ami en attente.</p>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($pendingRequests as $request)
                        <div class="bg-white p-6 rounded-lg shadow-md">
                            <div class="flex items-center space-x-4">
                                <img 
                                    src="{{ $request->user->profile_photo_url }}" 
                                    alt="{{ $request->user->name }}" 
                                    class="w-12 h-12 rounded-full"
                                >
                                <div>
                                    <h4 class="text-md font-semibold text-gray-800">{{ $request->user->name }}</h4>
                                    <p class="text-sm text-gray-500">{{ $request->user->email }}</p>
                                </div>
                            </div>
                            
                            <div class="mt-4 flex space-x-2">
                                <form action="{{ route('friends.accept', $request->id) }}" method="POST">
                                    @csrf
                                    <button 
                                        type="submit" 
                                        class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700"
                                    >
                                        Accepter
                                    </button>
                                </form>
                                
                                <form action="{{ route('friends.reject', $request->id) }}" method="POST">
                                    @csrf
                                    <button 
                                        type="submit" 
                                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700"
                                    >
                                        Rejeter
                                    </button>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>