<x-app-layout>
  <div class="container mx-auto py-12 px-4">

    {{-- Titre principal --}}
    <h1 class="text-3xl font-extrabold text-center mb-10 text-gray-800">
      ⚔️ Créer une nouvelle bataille
    </h1>

    {{-- Messages d’erreur --}}
    @if ($errors->any())
      <div class="bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded-lg mb-6">
        <ul class="list-disc list-inside">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    {{-- Formulaire de création --}}
    <div class="max-w-2xl mx-auto bg-white rounded-2xl shadow-lg p-8">
      <form method="POST" action="{{ route('battles.store') }}" class="space-y-6">
        @csrf

        {{-- Titre --}}
        <div>
          <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">
            Titre de la bataille *
          </label>
          <input type="text" name="title" id="title" value="{{ old('title') }}"
                 class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                 placeholder="Ex : Memes de chats" required>
        </div>

        {{-- Description --}}
        <div>
          <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
            Description
          </label>
          <textarea name="description" id="description" rows="4"
                    class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Décris brièvement ta bataille...">{{ old('description') }}</textarea>
        </div>

        {{-- Date limite --}}
        <div>
          <label for="deadline" class="block text-sm font-semibold text-gray-700 mb-2">
            Date limite *
          </label>
          <input type="datetime-local" name="deadline" id="deadline"
                 value="{{ old('deadline', now()->addDays(3)->format('Y-m-d\TH:i')) }}"
                 class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                 required>
        </div>

        {{-- Boutons --}}
        <div class="flex justify-between items-center pt-4">
          <a href="{{ route('battles.index') }}"
             class="bg-gray-200 text-gray-700 px-5 py-3 rounded-lg hover:bg-gray-300 transition font-semibold">
            ⬅️ Retour
          </a>
          <button type="submit"
                  class="bg-green-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-green-700 transition transform hover:-translate-y-0.5 shadow-md">
            ✅ Créer la bataille
          </button>
        </div>

      </form>
    </div>
  </div>
</x-app-layout>

