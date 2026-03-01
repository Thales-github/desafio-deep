<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Alunos;


Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

require __DIR__ . '/settings.php';

Route::prefix('alunos')->name('alunos.')->group(function () {

    // listar
    Route::get('/listar', [Alunos::class, 'listar'])->name('listar');

    // Salvar cadastro
    Route::post('/cadastrar', [Alunos::class, 'cadastrar'])->name('cadastrar');

    // Atualizar
    Route::put('/{id}', [Alunos::class, 'atualizar'])->name('atualizar');

    // Apagar
    Route::delete('/{id}', [Alunos::class, 'apagar'])->name('apagar');
});
