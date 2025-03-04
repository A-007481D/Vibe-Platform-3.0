<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Détails de l'ami
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mb-6">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Informations de l'ami</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="flex items-center space-x-4">
                            <img src="{{ $friend->profile_photo_url }}" alt="{{ $friend->name }}"
                                class="h-20 w-20 rounded-full">
                            <div>
                                <h4 class="text-xl font-bold">{{ $friend->name }} {{ $friend->last_name }}</h4>
                                <p class="text-gray-500">{{ $friend->email }}</p>
                                <p class="text-gray-500">Pseudo : {{ $friend->pseudo ?? 'Non défini' }}</p>
                            </div>
                        </div>

                        <div>
                            <h4 class="text-lg font-semibold text-gray-800">Bio</h4>
                            <p class="text-gray-600">{{ $friend->bio ?? 'Aucune bio disponible' }}</p>
                        </div>
                    </div>

                    <div class="mt-6">
                        <h4 class="text-lg font-semibold text-gray-800">Date d'amitié</h4>
                        <p class="text-gray-500">{{ $friendship->created_at->format('d/m/Y H:i') }}</p>
                    </div>

                    <div class="mt-6">
                        <a href="{{ route('friends.list') }}" class="text-blue-500 hover:text-blue-700">Retour à la
                            liste des amis</a>
                    </div>
                </div>
            </div>

            <!-- Section des publications de l'ami -->
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Publications de {{ $friend->name }}</h3>

                    @if($posts->count() > 0)
                    @foreach($posts as $post)
                    <div
                        class="mb-6 bg-white rounded-xl shadow-sm overflow-hidden transition duration-300 hover:shadow-md">
                        <div class="p-6">
                            <div class="w-1/2 mx-auto ">
                                <div class="flex justify-start space-x-3 mb-4">
                                    <img src="{{ $post->user->profile_photo_url }}" alt="{{ $post->user->name }}"
                                        class="h-12 w-12 rounded-full border-2 border-gray-100">
                                    <div>
                                        <h4 class="font-bold text-gray-900">
                                            {{ $post->user->name . ' ' . $post->user->last_name }}</h4>
                                        <p class="text-sm text-gray-500">{{ $post->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>

                                <div class="mt-2">
                                    <p class="text-gray-800 leading-relaxed">{{ $post->content }}</p>
                                </div>
                            </div>
                            @if($post->image_path)
                            <div class="mt-4 rounded-lg overflow-hidden">
                                <img src="{{ asset('storage/' . $post->image_path) }}"
                                    class="max-w-md mx-auto object-cover rounded" alt="Image du post">
                            </div>
                            @endif

                            <div
                                class="mt-6 pt-4 w-1/2 mx-auto border-t border-gray-100 flex items-center justify-between">
                                <div class="flex space-x-4 text-sm">
                                    <button type="button" 
                                        class="flex items-center like-button text-gray-500 hover:text-blue-600 transition {{ $post->isLikedBy(Auth::id()) ? 'text-blue-600' : '' }}"
                                        data-post-id="{{ $post->id }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" 
                                            id="like-icon-{{ $post->id }}"
                                            class="h-5 w-5 mr-1" 
                                            fill="{{ $post->isLikedBy(Auth::id()) ? 'currentColor' : 'none' }}" 
                                            viewBox="0 0 24 24" 
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                                        </svg>
                                        J'aime <span id="likes-count-{{ $post->id }}" class="ml-1">({{ $post->likes()->count() }})</span>
                                    </button>
                                    <button class="flex items-center text-gray-500 hover:text-blue-600 transition comment-toggle" data-post-id="{{ $post->id }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                        </svg>
                                        Commenter <span class="ml-1">({{ $post->comments()->count() }})</span>
                                    </button>
                                </div>
                            </div>

                            <!-- Section de commentaires (initialement cachée) -->
                            <div class="comments-container mt-4 w-1/2 mx-auto hidden" id="comments-{{ $post->id }}">
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <!-- Formulaire de commentaire -->
                                    <form action="{{ route('comments.store', $post->id) }}" method="POST" class="mb-4">
                                        @csrf
                                        <div class="flex items-start space-x-2">
                                            <img src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" class="h-8 w-8 rounded-full">
                                            <div class="flex-1">
                                                <textarea name="content" rows="2" placeholder="Écrire un commentaire..." class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:outline-none focus:border-blue-400"></textarea>
                                                <button type="submit" class="mt-2 px-3 py-1 text-xs bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                                    Commenter
                                                </button>
                                            </div>
                                        </div>
                                    </form>

                                    <!-- Liste des commentaires -->
                                    <div class="space-y-3">
                                        @foreach($post->comments()->with('user')->latest()->get() as $comment)
                                        <div class="flex items-start space-x-2 p-2 bg-white rounded-lg">
                                            <img src="{{ $comment->user->profile_photo_url }}" alt="{{ $comment->user->name }}" class="h-8 w-8 rounded-full">
                                            <div class="flex-1">
                                                <div class="flex justify-between items-start">
                                                    <div>
                                                        <h5 class="text-sm font-semibold">{{ $comment->user->name }} {{ $comment->user->last_name }}</h5>
                                                        <p class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</p>
                                                    </div>
                                                    @if(Auth::id() === $comment->user_id)
                                                    <form action="{{ route('comments.destroy', $comment->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-xs text-red-500 hover:text-red-700">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                    @endif
                                                </div>
                                                <p class="text-sm text-gray-700 mt-1">{{ $comment->content }}</p>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach

                    <div class="mt-4">
                        {{ $posts->links() }}
                    </div>
                    @else
                    <div class="p-4 text-center text-gray-500 bg-gray-50 rounded-lg">
                        <p>{{ $friend->name }} n'a pas encore publié de contenu.</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const commentButtons = document.querySelectorAll('.comment-toggle');
            
            commentButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const postId = this.getAttribute('data-post-id');
                    const commentsContainer = document.getElementById(`comments-${postId}`);
                    
                    if (commentsContainer.classList.contains('hidden')) {
                        commentsContainer.classList.remove('hidden');
                    } else {
                        commentsContainer.classList.add('hidden');
                    }
                });
            });
        });
    
        document.addEventListener('DOMContentLoaded', function() {
            // Sélectionne tous les boutons de like
            const likeButtons = document.querySelectorAll('.like-button');
            
            likeButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    const postId = this.getAttribute('data-post-id');
                    const likeCountElement = document.getElementById(`likes-count-${postId}`);
                    const likeIconElement = document.getElementById(`like-icon-${postId}`);
                    
                    // Requête AJAX
                    fetch(`/posts/${postId}/like`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        },
                        credentials: 'same-origin'
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Mise à jour du compteur
                            likeCountElement.textContent = data.likesCount;
                            
                            // Mise à jour de l'apparence du bouton
                            if (data.isLiked) {
                                this.classList.add('text-blue-600');
                                this.classList.remove('text-gray-500');
                                likeIconElement.setAttribute('fill', 'currentColor');
                            } else {
                                this.classList.remove('text-blue-600');
                                this.classList.add('text-gray-500');
                                likeIconElement.setAttribute('fill', 'none');
                            }
                        }
                    })
                    .catch(error => console.error('Erreur:', error));
                });
            });
        });
    </script>
</x-app-layout>