<x-app-layout>
  <div class="container mx-auto py-8">
    <h1 class="text-3xl font-bold mb-6">Meme Battle Arena</h1>

    <form method="GET" action="{{ route('battles.index') }}" class="mb-6 flex gap-2">
      <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar batalla..." class="border rounded px-3 py-2 flex-1">
      <select name="status" class="border rounded px-3 py-2">
        <option value="">Todos</option>
        <option value="open" {{ request('status')=='open' ? 'selected' : '' }}>Abiertas</option>
        <option value="closed" {{ request('status')=='closed' ? 'selected' : '' }}>Cerradas</option>
      </select>
      <button class="bg-blue-600 text-white px-4 py-2 rounded">Filtrar</button>
    </form>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      @foreach($battles as $battle)
        <div class="bg-white rounded shadow p-4">
          <h2 class="text-xl font-semibold">{{ $battle->title }}</h2>
          <p class="text-sm text-gray-600">Límite: {{ $battle->deadline->format('d/m/Y H:i') }}</p>
          <p class="text-sm text-gray-600">Memes: {{ $battle->memes_count }}</p>
          <a href="{{ route('battles.show', $battle) }}" class="text-indigo-600 mt-2 inline-block">Ver Batalla</a>
        </div>
      @endforeach
    </div>

    <div class="mt-6">
      {{ $battles->withQueryString()->links() }}
    </div>
  </div>
</x-app-layout>
