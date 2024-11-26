<?php

namespace App\Http\Controllers;

use App\Models\Avaliacao;
use App\Models\Solicitacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AvaliacaoController extends Controller
{
    // Listar as avaliações recebidas pelo usuário logado
    public function index()
    {
        // Buscar avaliações recebidas pelo usuário autenticado
        $avaliacoes = Avaliacao::where('avaliado_id', Auth::id())
            ->where('avaliador_id', '!=', Auth::id()) // Excluir avaliações feitas por si mesmo
            ->get();

        // Verificar se há avaliações para calcular a média
        $media = $avaliacoes->isEmpty() ? 0 : $avaliacoes->avg('nota');

        return view('avaliacoes.index', compact('avaliacoes', 'media'));
    }


    // Exibir a tela de avaliação
    public function create(Solicitacao $solicitacao)
    {
        // Verificar se a solicitação é finalizada
        if ($solicitacao->status !== Solicitacao::STATUS_FINALIZADO) {
            abort(403, 'Você só pode avaliar solicitações finalizadas.');
        }

        // Carregar as avaliações associadas
        $solicitacao->load('avaliacao');

        return view('avaliacoes.create', compact('solicitacao'));
    }


    // Salvar a avaliação
    public function store(Request $request, Solicitacao $solicitacao)
    {
        // Verifica se o avaliador já avaliou esta solicitação
        $avaliacaoExistente = Avaliacao::where('solicitacao_id', $solicitacao->id)
            ->where('avaliador_id', Auth::id())
            ->exists();

        if ($avaliacaoExistente) {
            return redirect()->route('avaliacoes.index')
                ->with('error', 'Você já avaliou esta solicitação.');
        }

        // Validação dos dados
        $request->validate([
            'nota' => 'required|integer|min:0|max:5',
            'comentario' => 'nullable|string|max:255',
        ]);

        // Identifica os IDs do avaliador e do avaliado
        $avaliadorId = Auth::id();
        $avaliadoId = $solicitacao->worker && $solicitacao->worker->user->id === $avaliadorId
            ? $solicitacao->cliente->id
            : $solicitacao->worker->user->id;

        // Criação da avaliação
        Avaliacao::create([
            'solicitacao_id' => $solicitacao->id,
            'avaliador_id' => $avaliadorId,
            'avaliado_id' => $avaliadoId,
            'nota' => $request->nota,
            'comentario' => $request->comentario,
        ]);

        return redirect()->route('avaliacoes.index')
            ->with('success', 'Avaliação realizada com sucesso!');
    }



    // Listar solicitações finalizadas que um cliente pode avaliar
    public function cliente()
    {
        $solicitacoes = Solicitacao::where('user_id', Auth::id())
            ->where('status', Solicitacao::STATUS_FINALIZADO)
            ->get();

        return view('avaliacoes.cliente', compact('solicitacoes'));
    }

    // Listar solicitações finalizadas que um trabalhador pode avaliar
    public function trabalhador()
    {
        $solicitacoes = Solicitacao::whereHas('worker', function ($query) {
            $query->where('user_id', Auth::id());
        })->where('status', Solicitacao::STATUS_FINALIZADO)
            ->get();

        return view('avaliacoes.trabalhador', compact('solicitacoes'));
    }
}
