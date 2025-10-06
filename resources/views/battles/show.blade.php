<x-app-layout>
  <div class="container mx-auto py-12 px-4">
    <h1 class="text-4xl font-extrabold mb-6 text-gray-800">{{ $battle->title }}</h1>
    <p class="text-gray-600 mb-4">{{ $battle->description }}</p>
    <p class="text-gray-500 mb-8">Fecha límite: {{ $battle->deadline->format('d/m/Y H:i') }}</p>

    {{-- Botones Editar / Eliminar de la batalla --}}
    <div class="mb-6 flex gap-4">
      @can('update', $battle)
        <a href="{{ route('battles.edit', $battle) }}" class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600">✏️ Editar</a>
      @endcan
      @can('delete', $battle)
        <form action="{{ route('battles.destroy', $battle) }}" method="POST">
          @csrf
          @method('DELETE')
          <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600">🗑️ Eliminar</button>
        </form>
      @endcan
    </div>

    {{-- Lista de memes --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
      @foreach($battle->memes as $meme)
        <div class="bg-white rounded-2xl shadow p-4 relative">
          <img src="{{ asset('storage/' . $meme->image_path) }}" alt="Meme" class="w-full h-48 object-cover rounded-lg mb-2">
          <p class="text-sm text-gray-500 mb-2">Subido por: {{ $meme->user->name }}</p>

          {{-- Botones Editar / Eliminar solo para el autor del meme --}}
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

    {{-- Formulario para subir nuevo meme si la batalla sigue abierta --}}
    @if(auth()->check() && $battle->deadline >= now())
      <div class="mt-8 max-w-md">
        <form action="{{ route('memes.store', $battle) }}" method="POST" enctype="multipart/form-data" class="flex gap-4">
          @csrf
          <input type="file" name="image" required class="border border-gray-300 rounded-lg px-3 py-2">
          <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">📤 Subir Meme</button>
        </form>
      </div>
    @endif

  </div>
</x-app-layout>



