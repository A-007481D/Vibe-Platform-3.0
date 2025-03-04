<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Modifier le post
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="content" class="block text-sm font-medium text-gray-700">Contenu du post</label>
                        <textarea id="content" name="content" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            {{ old('content', $post->content) }}
                        </textarea>
                    </div>

                    <div class="mb-4">
                        <label for="image" class="block text-sm font-medium text-gray-700">Image (facultatif)</label>
                        <input type="file" id="image" name="image" class="mt-1 block w-full">
                    </div>

                    @if ($post->image_url)
                        <div class="mb-4">
                            <p>Image actuelle :</p>
                            <img src="{{ asset('storage/' . $post->image_url) }}" alt="Image du post" class="h-40 rounded">
                        </div>
                    @endif

                    <div class="flex items-center justify-end">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Mettre à jour
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
