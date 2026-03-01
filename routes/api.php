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

    // Detalhar
    Route::get('/detalhar/{id}', [Alunos::class, 'detalhar'])
        ->whereNumber('id')
        ->name('detalhar');

    // Cadastrar
    Route::post('/cadastrar', [Alunos::class, 'cadastrar'])->name('cadastrar');

    // Atualizar
    Route::put('/atualizar/{id}', [Alunos::class, 'atualizar'])
        ->whereNumber('id')
        ->name('atualizar');

    // Apagar
    Route::delete('/apagar/{id}', [Alunos::class, 'apagar'])
        ->whereNumber('id')
        ->name('apagar');
});
