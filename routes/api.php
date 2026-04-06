<?php

use App\Http\Controllers\Alunos;
use App\Http\Controllers\AlunosDisciplinas;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Disciplinas;
use App\Http\Controllers\Professores;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

require __DIR__.'/settings.php';

Route::prefix('auth')->name('api.auth.')->group(function (): void {
    Route::post('/register', [AuthController::class, 'register'])
        ->middleware('throttle:5,1')
        ->name('register');
    Route::post('/login', [AuthController::class, 'login'])
        ->middleware('throttle:5,1')
        ->name('login');
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])
        ->middleware('throttle:5,1')
        ->name('forgot-password');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])
        ->middleware('throttle:5,1')
        ->name('reset-password');

    Route::middleware('auth:sanctum')->group(function (): void {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('/user', [AuthController::class, 'user'])->name('user');
    });
});

Route::middleware(['auth:sanctum'])->group(function (): void {
    Route::view('dashboard', 'dashboard')->name('dashboard');

    Route::prefix('alunos')->name('alunos.')->group(function (): void {
        Route::get('/listar', [Alunos::class, 'listar'])->name('listar');
        Route::get('/detalhar/{id}', [Alunos::class, 'detalhar'])
            ->whereNumber('id')
            ->name('detalhar');
        Route::post('/cadastrar', [Alunos::class, 'cadastrar'])->name('cadastrar');
        Route::put('/atualizar/{id}', [Alunos::class, 'atualizar'])
            ->whereNumber('id')
            ->name('atualizar');
        Route::delete('/apagar/{id}', [Alunos::class, 'apagar'])
            ->whereNumber('id')
            ->name('apagar');
    });

    Route::prefix('professores')->name('professores.')->group(function (): void {
        Route::get('/listar', [Professores::class, 'listar'])->name('listar');
        Route::get('/detalhar/{id}', [Professores::class, 'detalhar'])
            ->whereNumber('id')
            ->name('detalhar');
        Route::post('/cadastrar', [Professores::class, 'cadastrar'])->name('cadastrar');
        Route::put('/atualizar/{id}', [Professores::class, 'atualizar'])
            ->whereNumber('id')
            ->name('atualizar');
        Route::delete('/apagar/{id}', [Professores::class, 'apagar'])
            ->whereNumber('id')
            ->name('apagar');
    });

    Route::prefix('disciplinas')->name('disciplinas.')->group(function (): void {
        Route::get('/listar', [Disciplinas::class, 'listar'])->name('listar');
        Route::get('/detalhar/{id}', [Disciplinas::class, 'detalhar'])
            ->whereNumber('id')
            ->name('detalhar');
        Route::post('/cadastrar', [Disciplinas::class, 'cadastrar'])->name('cadastrar');
        Route::put('/atualizar/{id}', [Disciplinas::class, 'atualizar'])
            ->whereNumber('id')
            ->name('atualizar');
        Route::delete('/apagar/{id}', [Disciplinas::class, 'apagar'])
            ->whereNumber('id')
            ->name('apagar');
    });

    Route::prefix('alunos-disciplinas')->name('alunos-disciplinas.')->group(function (): void {
        Route::get('/listar', [AlunosDisciplinas::class, 'listar'])->name('alunos-disciplinas.listar');
        Route::post('/cadastrar', [AlunosDisciplinas::class, 'cadastrar'])->name('alunos-disciplinas.cadastrar');
        Route::get('/detalhar/{id}', [AlunosDisciplinas::class, 'detalhar'])
            ->whereNumber('id')
            ->name('alunos-disciplinas.detalhar');
        Route::put('/atualizar/{id}', [AlunosDisciplinas::class, 'atualizar'])
            ->whereNumber('id')
            ->name('alunos-disciplinas.atualizar');
        Route::delete('/apagar/{id}', [AlunosDisciplinas::class, 'apagar'])
            ->whereNumber('id')
            ->name('alunos-disciplinas.apagar');
    });
});
