<div class="mt-4 space-y-4">
    <h4 class="font-medium text-gray-800">Commentaires ({{ $post->comments->count() }})</h4>
    @forelse($post->comments as $comment)
        <div class="bg-gray-50 p-3 rounded-lg">
            <div class="flex items-start space-x-3">
                <img src="{{ $comment->user->profile_photo_url }}" alt="{{ $comment->user->name }}" 
                    class="h-8 w-8 rounded-full">
                <div class="flex-1">
                    <div class="flex justify-between items-start">
                        <div>
                            <h5 class="font-medium text-gray-900">{{ $comment->user->name }} {{ $comment->user->last_name }}</h5>
                            <p class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</p>
                        </div>
                        @if(Auth::id() == $comment->user_id)
                            <form action="{{ route('comments.destroy', $comment->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 text-xs">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" 
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        @endif
                    </div>
                    <p class="mt-1 text-gray-700">{{ $comment->content }}</p>
                </div>
            </div>
        </div>
    @empty
        <p class="text-gray-500 text-sm">Aucun commentaire pour l'instant.</p>
    @endforelse
</div>