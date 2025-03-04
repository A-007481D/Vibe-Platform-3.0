<div class="mb-6 bg-white rounded-xl shadow-sm overflow-hidden transition duration-300 hover:shadow-md">
    <div class="p-6">
        <div class="w-1/2 mx-auto">
            <div class="flex justify-start space-x-3">
                <img src="{{ $post->user->profile_photo_url }}"
                    alt="{{ $post->user->name }}" class="h-12 w-12 rounded-full border-2 border-gray-100">
                <div>
                    <h3 class="font-bold text-gray-900">
                        {{ $post->user->name . ' ' . $post->user->last_name }}</h3>
                    <p class="text-sm text-gray-500">{{ $post->created_at->diffForHumans() }}</p>
                </div>
            </div>

            <div class="mt-4 flex justify-start">
                <p class="text-gray-800 leading-relaxed">{{ $post->content }}</p>
            </div>
        </div>

        @if($post->image_path)
        <div class="mt-4 rounded-lg overflow-hidden">
            <img src="{{ asset('storage/' . $post->image_path) }}"
                class="w-1/2 max-w-md mx-auto object-cover rounded" alt="Image du post">
        </div>
        @endif

        <div class="mt-6 pt-4 w-1/2 mx-auto border-t border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div class="flex space-x-4 text-sm">
                    <button 
                        class="like-button flex items-center {{ $post->isLikedByUser() ? 'text-blue-600' : 'text-gray-500' }} hover:text-blue-600 transition"
                        data-post-id="{{ $post->id }}"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                        </svg>
                        <span class="like-text">{{ $post->isLikedByUser() ? 'Je n\'aime plus' : 'J\'aime' }}</span>
                        <span class="like-count ml-1">({{ $post->likesCount() }})</span>
                    </button>
                    <button class="comment-toggle flex items-center text-gray-500 hover:text-blue-600 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                        </svg>
                        Commenter ({{ $post->comments->count() }})
                    </button>
                </div>

                <div class="flex space-x-2">
                    @can('update', $post)
                    <a href="{{ route('posts.edit', $post) }}"
                        class="text-sm text-blue-600 hover:text-blue-800 transition flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Modifier
                    </a>
                    @endcan

                    @can('delete', $post)
                    <form action="{{ route('posts.destroy', $post) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="text-sm text-red-600 hover:text-red-800 transition flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Supprimer
                        </button>
                    </form>
                    @endcan
                </div>
            </div>
            
            <!-- Section commentaires - initialement cachée -->
            <div class="comments-section hidden mt-4 pt-3 border-t border-gray-100">
                <h4 class="text-sm font-medium text-gray-700 mb-2">Commentaires</h4>
                
                <div class="comments-list space-y-3 mb-4 max-h-60 overflow-y-auto">
                    @foreach($post->comments as $comment)
                    <div class="comment bg-gray-50 p-3 rounded-lg">
                        <div class="flex items-start space-x-2">
                            <img src="{{ $comment->user->profile_photo_url }}" 
                                alt="{{ $comment->user->name }}" 
                                class="h-8 w-8 rounded-full mt-1">
                            <div class="flex-1">
                                <div class="flex justify-between items-start">
                                    <h5 class="text-sm font-medium text-gray-800">{{ $comment->user->name }}</h5>
                                    @if(Auth::id() === $comment->user_id || Auth::id() === $post->user_id)
                                    <form action="{{ route('comments.destroy', $comment) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-xs text-red-500 hover:text-red-700">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                                <p class="text-sm text-gray-600">{{ $comment->content }}</p>
                                <p class="text-xs text-gray-400 mt-1">{{ $comment->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <form action="{{ route('comments.store', $post) }}" method="POST" class="comment-form mt-2">
                    @csrf
                    <div class="flex space-x-2">
                        <img src="{{ Auth::user()->profile_photo_url }}" 
                            alt="{{ Auth::user()->name }}" 
                            class="h-8 w-8 rounded-full">
                        <div class="flex-1">
                            <textarea name="content" rows="1" 
                                class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-blue-500" 
                                placeholder="Écrivez un commentaire..."></textarea>
                        </div>
                        <button type="submit" 
                            class="px-3 py-1 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition">
                            Envoyer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>