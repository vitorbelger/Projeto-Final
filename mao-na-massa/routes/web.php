<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckRole; // Importa o middleware CheckRole

// Rota para a página inicial
Route::get('/', function () {
    return view('welcome');
});

// Rotas de Dashboard
Route::middleware(['auth', 'verified'])->group(function () {
    // Rota para a dashboard do cliente
    Route::get('/dashboard', function () {
        return view('dashboard'); // Crie uma view específica para o cliente
    })->middleware(CheckRole::class . ':cliente')->name('dashboard');

    // Rota para a dashboard do trabalhador
    Route::get('/worker-dashboard', function () {
        return view('worker-dashboard'); // Crie uma view específica para o trabalhador
    })->middleware(CheckRole::class . ':trabalhador')->name('worker.dashboard');
});

// Grupo de rotas para perfil
Route::middleware(['auth', 'verified'])->group(function () {
    // Perfil do cliente
    Route::get('/profile/user', [ProfileController::class, 'userProfile'])->middleware(CheckRole::class . ':cliente')->name('profile.user.edit');
    Route::patch('/profile/user', [ProfileController::class, 'update'])->middleware(CheckRole::class . ':cliente')->name('profile.user.update');
    Route::delete('/profile/user', [ProfileController::class, 'destroy'])->middleware(CheckRole::class . ':cliente')->name('profile.user.destroy');

    // Perfil do trabalhador
    Route::get('/profile/worker', [ProfileController::class, 'workerProfile'])->middleware(CheckRole::class . ':trabalhador')->name('profile.worker.worker-edit');
    Route::patch('/profile/worker', [ProfileController::class, 'update'])->middleware(CheckRole::class . ':trabalhador')->name('profile.worker.update');
    Route::delete('/profile/worker', [ProfileController::class, 'destroy'])->middleware(CheckRole::class . ':trabalhador')->name('profile.worker.destroy');
});

// Inclui as rotas de autenticação
require __DIR__.'/auth.php';
