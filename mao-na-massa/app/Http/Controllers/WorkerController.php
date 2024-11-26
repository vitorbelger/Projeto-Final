<?php

namespace App\Http\Controllers;

use App\Models\Worker;
use App\Models\Solicitacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkerController extends Controller
{
    // Exibe a lista de trabalhadores (para o cliente visualizar)
    public function index(Request $request)
    {
        $search = $request->input('search');

        // Busca os trabalhadores com as avaliações recebidas
        $workers = Worker::whereHas('user', function ($query) use ($search) {
            $query->where('name', 'like', "%{$search}%");
        })
            ->orWhere('profissao', 'like', "%{$search}%")
            ->with(['user' => function ($query) {
                $query->with('avaliacoesRecebidas');
            }])
            ->get();

        // Adicionar a média das avaliações para cada trabalhador
        $workers->each(function ($worker) {
            $worker->media = $worker->user->avaliacoesRecebidas->avg('nota') ?? 0;
        });

        return view('dashboard', compact('workers'));
    }


    // Exibe os detalhes de um trabalhador específico
    public function show(Worker $worker)
    {
        return view('workers.show', compact('worker'));
    }

    // Cria uma solicitação de serviço (para o cliente solicitar)
    public function solicitarServico(Request $request, Worker $worker)
    {
        $request->validate([
            'data_inicio' => [
                'required',
                'date',
                'after_or_equal:today', // Verifica se a data de início não está no passado
            ],
            'data_conclusao' => [
                'required',
                'date',
                'after_or_equal:data_inicio', // Verifica se a data de conclusão é após ou igual à data de início
            ],
            'descricao' => 'required|string',
        ]);

        Solicitacao::create([
            'user_id' => Auth::id(), // Obtém o ID do usuário autenticado
            'worker_id' => $worker->id,
            'data_inicio' => $request->data_inicio,
            'data_conclusao' => $request->data_conclusao,
            'descricao' => $request->descricao,
            'status' => 'pendente',
        ]);

        return redirect()->route('dashboard')->with('success', 'Solicitação enviada com sucesso!');
    }


    // Exibe os detalhes de uma solicitação para o trabalhador
    public function showSolicitacao(Solicitacao $solicitacao)
    {

        return view('solicitacoes.show', compact('solicitacao'));
    }

    // Atualiza o status de uma solicitação (aceitar ou rejeitar)
    public function atualizarSolicitacao(Request $request, Solicitacao $solicitacao)
    {
        // Recuperar o trabalhador autenticado
        $worker = Auth::user()->worker;

        // Verificar se o trabalhador autenticado é o responsável pela solicitação
        if (!$worker || $solicitacao->worker_id !== $worker->id) {
            abort(403, 'Ação não autorizada.');
        }

        // Validação do status
        $request->validate([
            'status' => 'required|in:aceita,rejeitada',
        ]);

        // Atualizar o status da solicitação
        $solicitacao->update([
            'status' => $request->status,
        ]);

        return redirect()->route('worker-dashboard')->with('success', 'Solicitação atualizada com sucesso!');
    }

    // Método para carregar o dashboard com a média do cliente
    public function dashboard()
    {
        $worker = Auth::user()->worker;

        $solicitacoes = Solicitacao::where('worker_id', $worker->id)
            ->with(['cliente' => function ($query) {
                $query->with('avaliacoesRecebidas');
            }])
            ->get();

        return view('worker-dashboard', compact('solicitacoes'));
    }

    //Tela de Registro das Solicitações
    public function registerSolicitacoes()
    {
        $user = Auth::user();

        if (!$user) {
            abort(403, 'Usuário não autenticado.');
        }

        // Carregar as solicitações para o cliente e trabalhador
        $solicitacoes = [];

        if ($user->role === 'cliente') {
            $solicitacoes = Solicitacao::where('user_id', $user->id)->get();
        } elseif ($user->role === 'trabalhador') {
            // Exibir solicitações aceitas e rejeitadas no registro
            $solicitacoes = Solicitacao::where('worker_id', $user->worker->id)
                ->whereIn('status', ['aceita', 'rejeitada'])
                ->get();
        }

        return view('solicitacao-register', compact('solicitacoes'));
    }

    public function finalizarSolicitacao(Solicitacao $solicitacao)
    {
        // Verificar se o status atual é "aceita"
        if ($solicitacao->status !== 'aceita') {
            abort(403, 'Ação não autorizada.');
        }

        // Atualizar o status para "finalizado" e salvar a data de finalização
        $solicitacao->update([
            'status' => 'finalizado',
            'data_finalizacao' => now(),
        ]);

        return redirect()->route('solicitacoes.show')->with('success', 'Solicitação finalizada com sucesso!');
    }
}
