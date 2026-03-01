<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Alunos;
use App\Http\Controllers\Disciplinas;
use App\Http\Controllers\Professores;

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

Route::prefix('professores')->name('professores.')->group(function () {

    // listar
    Route::get('/listar', [Professores::class, 'listar'])->name('listar');

    // Detalhar
    Route::get('/detalhar/{id}', [Professores::class, 'detalhar'])
        ->whereNumber('id')
        ->name('detalhar');

    // Cadastrar
    Route::post('/cadastrar', [Professores::class, 'cadastrar'])->name('cadastrar');

    // Atualizar
    Route::put('/atualizar/{id}', [Professores::class, 'atualizar'])
        ->whereNumber('id')
        ->name('atualizar');

    // Apagar
    Route::delete('/apagar/{id}', [Professores::class, 'apagar'])
        ->whereNumber('id')
        ->name('apagar');
});

Route::prefix('disciplinas')->name('disciplinas.')->group(function () {

    // listar
    Route::get('/listar', [Disciplinas::class, 'listar'])->name('listar');

    // Detalhar
    Route::get('/detalhar/{id}', [Disciplinas::class, 'detalhar'])
        ->whereNumber('id')
        ->name('detalhar');

    // Cadastrar
    Route::post('/cadastrar', [Disciplinas::class, 'cadastrar'])->name('cadastrar');

    // Atualizar
    Route::put('/atualizar/{id}', [Disciplinas::class, 'atualizar'])
        ->whereNumber('id')
        ->name('atualizar');

    // Apagar
    Route::delete('/apagar/{id}', [Disciplinas::class, 'apagar'])
        ->whereNumber('id')
        ->name('apagar');
});