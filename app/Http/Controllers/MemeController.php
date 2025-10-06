<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Battle;
use App\Models\Meme;
use Illuminate\Support\Facades\Storage;

class MemeController extends Controller
{
    public function edit(Meme $meme)
    {
        // Solo el autor puede editar
        if (auth()->id() !== $meme->user_id) abort(403);

        return view('memes.edit', compact('meme'));
    }

    public function update(Request $request, Meme $meme)
    {
        // Solo el autor puede actualizar
        if (auth()->id() !== $meme->user_id) abort(403);

        $validated = $request->validate([
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096', // 4MB
            'caption' => 'nullable|string|max:255',
        ]);

        // Si suben nueva imagen, borramos la anterior
        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($meme->image_path);
            $path = $request->file('image')->store('memes', 'public');
            $meme->image_path = $path;
        }

        $meme->caption = $validated['caption'] ?? $meme->caption;
        $meme->save();

        return redirect()->route('battles.show', $meme->battle)->with('success', 'Meme actualizado.');
    }


    public function store(Request $request, Battle $battle)
    {
        // No permitir uploads en batallas cerradas
        if ($battle->deadline->isPast()) {
            return back()->with('error','Esta batalla ya ha finalizado.');
        }

        $validated = $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:4096', // 4MB
            'caption' => 'nullable|string|max:255',
        ]);

        // Guardar archivo en storage/app/public/memes
        $path = $request->file('image')->store('memes', 'public');

        $meme = $battle->memes()->create([
            'user_id' => $request->user()->id,
            'image_path' => $path,
            'caption' => $validated['caption'] ?? null,
            'approved' => true,
            'votes_count' => 0,
        ]);

        return redirect()->route('battles.show', $battle)->with('success','Meme subido.');
    }

    public function destroy(Meme $meme)
    {
        // Solo autor puede eliminar
        if (auth()->id() !== $meme->user_id) abort(403);

        // Borrar archivo físico
        Storage::disk('public')->delete($meme->image_path);

        $meme->delete();

        return back()->with('success','Meme eliminado.');
    }
}

