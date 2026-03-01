<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Aluno;


Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

require __DIR__ . '/settings.php';

// Route::prefix('aluno')->name('aluno.')->group(function () {

    // // listar
    // Route::get('/listar', [Aluno::class, 'listar'])->name('listar');

    // // Salvar cadastro
    // Route::post('/cadastrar', [Aluno::class, 'cadastrar'])->name('cadastrar');

    // // Atualizar
    // Route::put('/{id}', [Aluno::class, 'atualizar'])->name('atualizar');

    // // Apagar
    // Route::delete('/{id}', [Aluno::class, 'apagar'])->name('apagar');
// });
