<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WorkerController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckRole;
use App\Models\Worker;
use App\Models\Solicitacao;
use Illuminate\Support\Facades\Auth;

// Página inicial
Route::get('/', function () {
    return view('welcome');
});

// Rotas protegidas por autenticação e verificação de email
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard do Cliente
    Route::middleware(CheckRole::class . ':cliente')->group(function () {
        Route::get('/dashboard', function () {
            $workers = Worker::with('user')->get();
            return view('dashboard', compact('workers'));
        })->name('dashboard');

        // Exibir trabalhador e solicitar serviço
        Route::get('/workers/{worker}', [WorkerController::class, 'show'])->name('workers.show');
        Route::post('/workers/{worker}/solicitar', [WorkerController::class, 'solicitarServico'])->name('workers.solicitar');
    });

    // Dashboard do Trabalhador
    Route::get('/worker-dashboard', function () {
        $worker = Auth::user()->worker; // Obter o trabalhador autenticado

        // Verifica se o usuário é realmente um trabalhador
        if (!$worker) {
            abort(403, 'Ação não autorizada.');
        }

        // Carrega as solicitações relacionadas ao trabalhador
        $solicitacoes = Solicitacao::where('worker_id', $worker->id)->get();

        return view('worker-dashboard', compact('solicitacoes'));
    })->middleware(CheckRole::class . ':trabalhador')->name('worker-dashboard');


    // Concluir solicitação
    Route::patch('/solicitacoes/{solicitacao}/atualizar', [WorkerController::class, 'atualizarSolicitacao'])
    ->middleware(['auth', 'verified'])
    ->name('solicitacoes.atualizar');

    Route::patch('/solicitacoes/{solicitacao}/finalizar', [WorkerController::class, 'finalizarSolicitacao'])
    ->middleware(['auth', 'verified', CheckRole::class . ':trabalhador'])
    ->name('solicitacoes.finalizar');



    //tela de registro para as solicitações
    Route::get('/solicitacoes', [WorkerController::class, 'registerSolicitacoes'])->name('solicitacoes.show');



    // Rotas de Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Inclui as rotas de autenticação
require __DIR__ . '/auth.php';
