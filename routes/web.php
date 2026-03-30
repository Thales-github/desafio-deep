<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlunoWebController;
use App\Http\Controllers\ProfessorWebController;

// Rota inicial - redireciona para lista de alunos
Route::get('/', function () {
    return redirect()->route('alunos.index');
});

// Rotas de Alunos - usando os nomes dos seus arquivos
Route::prefix('alunos')->name('alunos.')->group(function () {
    Route::get('/', [AlunoWebController::class, 'index'])->name('index');
    Route::get('/create', [AlunoWebController::class, 'create'])->name('create');
    Route::post('/', [AlunoWebController::class, 'store'])->name('store');
    Route::get('/{id}', [AlunoWebController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [AlunoWebController::class, 'edit'])->name('edit');
    Route::put('/{id}', [AlunoWebController::class, 'update'])->name('update');
    Route::delete('/{id}', [AlunoWebController::class, 'destroy'])->name('destroy');
});

Route::prefix('professores')->name('professores.')->group(function () {
    Route::get('/', [ProfessorWebController::class, 'index'])->name('index');
    Route::get('/create', [ProfessorWebController::class, 'create'])->name('create');
    Route::post('/', [ProfessorWebController::class, 'store'])->name('store');
    Route::get('/{id}', [ProfessorWebController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [ProfessorWebController::class, 'edit'])->name('edit');
    Route::put('/{id}', [ProfessorWebController::class, 'update'])->name('update');
    Route::delete('/{id}', [ProfessorWebController::class, 'destroy'])->name('destroy');
});
