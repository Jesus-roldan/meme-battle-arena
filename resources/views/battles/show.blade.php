<x-app-layout>
  <div class="container mx-auto py-8">
    <h1 class="text-3xl font-bold mb-4">{{ $battle->title }}</h1>
    <p class="text-gray-700 mb-4">{{ $battle->description }}</p>
    <p class="text-sm text-gray-500 mb-6">Límite: {{ $battle->deadline->format('d/m/Y H:i') }}</p>

    @auth
      @if($battle->deadline->isFuture())
        <div class="mb-6">
          <form action="{{ route('memes.store', $battle) }}" method="POST" enctype="multipart/form-data" class="flex gap-2 items-center">
            @csrf
            <input type="file" name="image" required class="border rounded px-2 py-1">
            <input type="text" name="caption" placeholder="Pie (opcional)" class="border rounded px-2 py-1">
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Subir Meme</button>
          </form>
        </div>
      @else
        <div class="mb-6 text-red-600">Esta batalla ya ha finalizado. No se pueden subir memes.</div>
      @endif
    @else
      <div class="mb-6">
        <a href="{{ route('login') }}" class="text-indigo-600">Inicia sesión</a> para subir y votar memes.
      </div>
    @endauth

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      @foreach($memes as $meme)
        <div class="bg-white rounded shadow p-3">
          <img src="{{ asset('storage/'.$meme->image_path) }}" alt="Meme" class="w-full h-48 object-cover rounded">
          <p class="mt-2">{{ $meme->caption }}</p>
          <p class="text-sm text-gray-600 mt-1">Subido por: {{ $meme->user->name }}</p>
          <p class="font-semibold mt-2">Votos: {{ $meme->votes_count }}</p>

          @auth
            @if($battle->deadline->isFuture())
              @if(!$userVote)
                <form action="{{ route('memes.vote', $meme) }}" method="POST" class="mt-2">
                  @csrf
                  <button class="bg-blue-600 text-white px-3 py-1 rounded">Votar</button>
                </form>
              @else
                @if($userVote->meme_id == $meme->id)
                  <span class="inline-block mt-2 px-3 py-1 bg-green-100 text-green-800 rounded">Tu voto</span>
                @else
                  <span class="inline-block mt-2 px-3 py-1 bg-gray-100 text-gray-800 rounded">Ya votaste</span>
                @endif
              @endif
            @endif
          @endauth

        </div>
      @endforeach
    </div>

  </div>
</x-app-layout>

