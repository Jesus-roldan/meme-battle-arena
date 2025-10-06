<x-app-layout>
  <div class="container mx-auto py-12 px-4">
    <h1 class="text-4xl font-extrabold text-center mb-10 text-gray-800">Meme Battle Arena</h1>

    <form method="GET" action="{{ route('battles.index') }}" class="mb-10 flex flex-col md:flex-row gap-4 items-center justify-center">
      <input type="text" name="search" value="{{ request('search') }}" placeholder="Rechercher une bataille…" class="w-full md:flex-1 border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
      <select name="status" class="w-full md:w-48 border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
        <option value="">Tous</option>
        <option value="open" {{ request('status')=='open' ? 'selected' : '' }}>Ouvertes</option>
        <option value="closed" {{ request('status')=='closed' ? 'selected' : '' }}>Fermées</option>
      </select>
      <button class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition">Filtrer</button>
    </form>

    {{-- Botón Nueva Batalla solo si está autenticado --}}
    @auth
      <div class="mb-8 text-center">
        <a href="{{ route('battles.create') }}" class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition font-semibold">
          ➕ Nouvelle bataille
        </a>
      </div>
    @endauth

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
      @foreach($battles as $battle)
        <div class="bg-white rounded-2xl shadow-lg p-6 hover:shadow-2xl transition transform hover:-translate-y-1 relative">
          <h2 class="text-2xl font-bold text-gray-800 mb-2">{{ $battle->title }}</h2>
          <p class="text-sm text-gray-500 mb-1">Limite: <span class="font-medium">{{ $battle->deadline->format('d/m/Y H:i') }}</span></p>
          <p class="text-sm text-gray-500 mb-4">Memes: <span class="font-medium">{{ $battle->memes_count }}</span></p>
          <a href="{{ route('battles.show', $battle) }}" class="block text-center bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700 transition font-semibold">Voir la bataille</a>

          {{-- Botones Editar / Eliminar solo para el autor --}}
          @can('update', $battle)
            <a href="{{ route('battles.edit', $battle) }}" class="absolute top-4 right-20 text-yellow-500 font-semibold">✏️</a>
          @endcan
          @can('delete', $battle)
            <form action="{{ route('battles.destroy', $battle) }}" method="POST" class="absolute top-4 right-4 inline">
              @csrf
              @method('DELETE')
              <button type="submit" class="text-red-500 font-semibold">🗑️</button>
            </form>
          @endcan
        </div>
      @endforeach
    </div>

    <div class="mt-12 flex justify-center">
      {{ $battles->withQueryString()->links() }}
    </div>
  </div>
</x-app-layout>




