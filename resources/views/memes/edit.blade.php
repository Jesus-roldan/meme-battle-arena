<x-app-layout>
  <div class="container mx-auto py-12 px-4">
    <h1 class="text-3xl font-bold mb-6">Modifier le Meme</h1>

    <form action="{{ route('memes.update', $meme) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
      @csrf
      @method('PUT')

      <div>
        <label for="image" class="block text-sm font-semibold mb-2">Nouvelle image</label>
        <input type="file" name="image" id="image" class="border border-gray-300 rounded-lg px-3 py-2">
      </div>

      <div>
        <label for="caption" class="block text-sm font-semibold mb-2">Légende</label>
        <input type="text" name="caption" id="caption" value="{{ $meme->caption }}" class="border border-gray-300 rounded-lg px-3 py-2 w-full">
      </div>

      <button type="submit" class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition">✅ Mettre à jour</button>
    </form>
  </div>
</x-app-layout>
