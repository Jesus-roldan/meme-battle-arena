<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BattleController;
use App\Http\Controllers\MemeController;
use App\Http\Controllers\VoteController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/', [BattleController::class, 'index'])->name('battles.index');

Route::middleware('auth')->group(function () {
    // Rutas resource para battlles (excluimos index)
    Route::resource('battles', BattleController::class)->except(['index']);

    // Ruta pública para la lista de batallas
    Route::get('/battles', [BattleController::class, 'index'])->name('battles.index');

    // Subir meme a una batalla
    Route::post('battles/{battle}/memes', [MemeController::class, 'store'])->name('memes.store');

     // Rutas para editar, actualizar y eliminar memes
    Route::get('memes/{meme}/edit', [MemeController::class, 'edit'])->name('memes.edit');
    Route::put('memes/{meme}', [MemeController::class, 'update'])->name('memes.update');
    Route::delete('memes/{meme}', [MemeController::class, 'destroy'])->name('memes.destroy');

    // Votar un meme
    Route::post('memes/{meme}/vote', [VoteController::class, 'store'])->name('memes.vote');

    // Opcional: retirar voto
    Route::delete('memes/{meme}/vote', [VoteController::class, 'destroy'])->name('memes.vote.destroy');
});

require __DIR__.'/auth.php';
