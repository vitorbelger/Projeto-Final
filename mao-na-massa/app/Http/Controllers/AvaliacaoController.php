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
        $avaliacoes = Avaliacao::where('avaliado_id', Auth::id())->get();

        return view('avaliacoes.index', compact('avaliacoes'));
    }

    // Exibir a tela de avaliação
    public function create(Solicitacao $solicitacao)
    {
        // Verificar se a solicitação é finalizada
        if ($solicitacao->status !== Solicitacao::STATUS_FINALIZADO) {
            abort(403, 'Você só pode avaliar solicitações finalizadas.');
        }

        return view('avaliacoes.create', compact('solicitacao'));
    }

    // Salvar a avaliação
    public function store(Request $request, Solicitacao $solicitacao)
    {
        // Validar os dados da avaliação
        $request->validate([
            'nota' => 'required|integer|min:0|max:5',
            'comentario' => 'nullable|string|max:255',
        ]);

        // Verificar se a solicitação é finalizada
        if ($solicitacao->status !== Solicitacao::STATUS_FINALIZADO) {
            abort(403, 'Você só pode avaliar solicitações finalizadas.');
        }

        // Criar a avaliação
        $avaliacao = new Avaliacao();
        $avaliacao->solicitacao_id = $solicitacao->id;
        $avaliacao->avaliador_id = Auth::id(); // Quem está avaliando

        // Definir o avaliado com base na relação da solicitação
        if (Auth::id() === $solicitacao->user_id) {
            // Se o avaliador for o cliente, o avaliado é o trabalhador
            $avaliacao->avaliado_id = $solicitacao->worker->user_id;
        } elseif (Auth::id() === $solicitacao->worker->user_id) {
            // Se o avaliador for o trabalhador, o avaliado é o cliente
            $avaliacao->avaliado_id = $solicitacao->cliente->id;
        } else {
            abort(403, 'Você não tem permissão para avaliar esta solicitação.');
        }

        // Atribuir os dados da avaliação
        $avaliacao->nota = $request->input('nota');
        $avaliacao->comentario = $request->input('comentario');
        $avaliacao->save();

        return redirect()
            ->route('avaliacoes.index')
            ->with('success', 'Avaliação enviada com sucesso!');
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
