<?php

use App\Http\Controllers\AlunoDisciplinaWebController;
use App\Http\Controllers\AlunoWebController;
use App\Http\Controllers\DisciplinaWebController;
use App\Http\Controllers\ProfessorWebController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Página inicial
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('alunos.index')
        : redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| Pós-login (Fortify redireciona para "home" = /dashboard em config/fortify.php)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->get('/dashboard', function () {
    return redirect()->route('alunos.index');
})->name('dashboard');

/*
|--------------------------------------------------------------------------
| Área escolar (Blade + Bootstrap) — exige usuário logado
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
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

    Route::prefix('disciplinas')->name('disciplinas.')->group(function () {
        Route::get('/', [DisciplinaWebController::class, 'index'])->name('index');
        Route::get('/create', [DisciplinaWebController::class, 'create'])->name('create');
        Route::post('/', [DisciplinaWebController::class, 'store'])->name('store');
        Route::get('/{id}', [DisciplinaWebController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [DisciplinaWebController::class, 'edit'])->name('edit');
        Route::put('/{id}', [DisciplinaWebController::class, 'update'])->name('update');
        Route::delete('/{id}', [DisciplinaWebController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('alunos-disciplinas')->name('alunos-disciplinas.')->group(function () {
        Route::get('/', [AlunoDisciplinaWebController::class, 'index'])->name('index');
        Route::get('/create', [AlunoDisciplinaWebController::class, 'create'])->name('create');
        Route::post('/', [AlunoDisciplinaWebController::class, 'store'])->name('store');
        Route::get('/{id}', [AlunoDisciplinaWebController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [AlunoDisciplinaWebController::class, 'edit'])->name('edit');
        Route::put('/{id}', [AlunoDisciplinaWebController::class, 'update'])->name('update');
        Route::delete('/{id}', [AlunoDisciplinaWebController::class, 'destroy'])->name('destroy');
    });
});
