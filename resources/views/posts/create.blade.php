<x-app-layout>
    <x-slot name="header">
        Créer un post
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <textarea name="content" class="w-full p-2 border rounded" placeholder="Que voulez-vous partager ?"></textarea>

                <input type="file" name="image" class="mt-4">

                <button type="submit" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded">Publier</button>
            </form>
        </div>
    </div>
</x-app-layout>
