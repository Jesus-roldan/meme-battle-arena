<x-app-layout>
  <div class="container mx-auto py-12 px-4">
    {{-- Bouton pour revenir à la liste des battles --}}
    <a href="{{ route('battles.index') }}" class="inline-block mb-6 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">⬅️ Retour aux battles</a>

    {{-- Titre du battle --}}
    <h1 class="text-4xl font-extrabold mb-4 text-gray-800">{{ $battle->title }}</h1>
    <p class="text-gray-600 mb-2">{{ $battle->description }}</p>
    <p class="text-gray-500 mb-8">Date limite : {{ $battle->deadline->format('d/m/Y H:i') }}</p>

    {{-- Boutons d’action: Modifier / Supprimer / Mettre à jour --}}
    <div class="mb-8 flex flex-wrap gap-4">
      @can('update', $battle)
        <a href="{{ route('battles.edit', $battle) }}" class="flex-1 md:flex-none bg-yellow-500 text-white px-6 py-3 rounded-lg hover:bg-yellow-600 transition text-center font-semibold">
          ✏️ Modifier le battle
        </a>
      @endcan

      @can('delete', $battle)
        <form action="{{ route('battles.destroy', $battle) }}" method="POST" class="flex-1 md:flex-none">
          @csrf
          @method('DELETE')
          <button type="submit" class="w-full bg-red-500 text-white px-6 py-3 rounded-lg hover:bg-red-600 transition font-semibold">
            🗑️ Supprimer le battle
          </button>
        </form>
      @endcan

      {{-- Bouton Mettre à jour --}}
      <form action="{{ route('battles.update', $battle) }}" method="POST" class="flex-1 md:flex-none">
        @csrf
        @method('PUT')
        <button type="submit" class="w-full bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition font-semibold">
          ✅ Mettre à jour
        </button>
      </form>
    </div>

    {{-- Liste des memes --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
      @foreach($battle->memes as $meme)
        <div class="bg-white rounded-2xl shadow p-4 relative">
          <img src="{{ asset('storage/' . $meme->image_path) }}" alt="Meme" class="w-full h-48 object-cover rounded-lg mb-2">
          @if($meme->caption)
            <p class="text-sm text-gray-500 mb-2">💬 {{ $meme->caption }}</p>
          @endif
          <p class="text-sm text-gray-500 mb-2">Posté par : {{ $meme->user->name }}</p>
        <div class="flex items-center justify-between mt-auto">
        <span class="text-gray-700 font-semibold">{{ $meme->votes_count }} 👍</span>

        @auth
          @if(!$meme->votes->contains('user_id', auth()->id()))
            <form action="{{ route('memes.vote', $meme) }}" method="POST">
              @csrf
              <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded-lg hover:bg-blue-700 transition text-sm">Voter</button>
            </form>
          @else
            <span class="text-gray-400 text-sm font-medium">Déjà voté</span>
          @endif
        @endauth
      </div>
          {{-- Boutons modifier/supprimer meme uniquement pour l’auteur --}}
          @can('update', $meme)
            <a href="{{ route('memes.edit', $meme) }}" class="absolute top-2 right-10 text-yellow-500 font-semibold">✏️</a>
          @endcan
          @can('delete', $meme)
            <form action="{{ route('memes.destroy', $meme) }}" method="POST" class="absolute top-2 right-2">
              @csrf
              @method('DELETE')
              <button type="submit" class="text-red-500 font-semibold">🗑️</button>
            </form>
          @endcan
        </div>
      @endforeach
    </div>

    {{-- Formulaire pour ajouter un nouveau meme si le battle est ouvert --}}
  @auth
    @if($battle->deadline >= now())
        <div class="mt-8 w-full max-w-4xl mx-auto bg-white shadow-lg rounded-2xl p-6 flex flex-col md:flex-row gap-4 items-center">
            <form action="{{ route('memes.store', $battle) }}" method="POST" enctype="multipart/form-data" class="w-full flex flex-col md:flex-row gap-4 items-center">
                @csrf
                {{-- Input de archivo más grande --}}
                <input type="file" name="image" required
                       class="border border-gray-300 rounded-xl px-4 py-4 flex-1 text-gray-700 text-lg">
                {{-- Input de caption más grande --}}
                <input type="text" name="caption" placeholder="Ajouter une légende (optionnel)"
                       class="border border-gray-300 rounded-xl px-4 py-4 flex-1 text-gray-700 text-lg">
                {{-- Botón más grande --}}
                <button type="submit"
                        class="bg-green-600 text-white px-8 py-4 rounded-xl hover:bg-green-700 transition font-semibold text-lg">
                    📤 Envoyer le meme
                </button>
            </form>
        </div>
    @else
        <p class="mt-6 text-red-500 font-semibold text-center text-lg">⏰ Ce battle est terminé, vous ne pouvez plus envoyer de memes.</p>
    @endif
@endauth
  </div>
</x-app-layout>






