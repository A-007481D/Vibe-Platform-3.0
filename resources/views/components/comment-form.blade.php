<div class="mt-4 border-t pt-4">
    <h4 class="font-medium text-gray-800 mb-3">Ajouter un commentaire</h4>
    <form action="{{ route('comments.store', $post->id) }}" method="POST" class="space-y-3">
        @csrf
        <div>
            <textarea name="content" rows="2" 
                class="w-full px-3 py-2 text-gray-700 border rounded-lg focus:outline-none focus:border-blue-500"
                placeholder="Écrivez votre commentaire..."></textarea>
        </div>
        <div class="flex justify-end">
            <button type="submit" 
                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200">
                Commenter
            </button>
        </div>
    </form>
</div>