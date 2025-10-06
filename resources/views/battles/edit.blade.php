<x-app-layout>
  <div class="container mx-auto py-12 px-4">
    <h1 class="text-3xl font-bold mb-6">Modifier la bataille</h1>

    <form action="{{ route('battles.update', $battle) }}" method="POST" class="space-y-4">
      @csrf
      @method('PUT')

      <div>
        <label for="title" class="block text-sm font-semibold mb-2">Titre</label>
        <input type="text" name="title" id="title" value="{{ $battle->title }}" class="border border-gray-300 rounded-lg px-3 py-2 w-full">
      </div>

      <div>
        <label for="description" class="block text-sm font-semibold mb-2">Description</label>
        <textarea name="description" id="description" class="border border-gray-300 rounded-lg px-3 py-2 w-full">{{ $battle->description }}</textarea>
      </div>

      <div>
        <label for="deadline" class="block text-sm font-semibold mb-2">Date limite</label>
        <input type="datetime-local" name="deadline" id="deadline" value="{{ $battle->deadline->format('Y-m-d\TH:i') }}" class="border border-gray-300 rounded-lg px-3 py-2 w-full">
      </div>

      <button type="submit" class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition">✅ Mettre à jour</button>
    </form>
  </div>
</x-app-layout>
