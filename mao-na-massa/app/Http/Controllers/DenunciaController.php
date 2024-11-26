<?php

namespace App\Http\Controllers;

use App\Models\Denuncia;
use App\Models\Solicitacao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DenunciaController extends Controller
{
    public function create(Solicitacao $solicitacao)
    {
        // Verificar se a solicitação é finalizada
        if ($solicitacao->status !== Solicitacao::STATUS_FINALIZADO) {
            abort(403, 'Você só pode avaliar solicitações finalizadas.');
        }

        return view('denuncias.create', compact('solicitacao'));
    }

    public function store(Request $request, Solicitacao $solicitacao)
    {
        // Carregar os relacionamentos necessários
        $solicitacao->load('worker.user', 'cliente');

        // Verificar se o denunciante já fez uma denúncia para esta solicitação
        $denunciaExistente = $solicitacao->denuncia()
            ->where('denunciante_id', Auth::id())
            ->exists();


        if ($denunciaExistente) {
            return redirect()->back()->with('error', 'Você já fez uma denúncia para esta solicitação.');
        }

        // Validar o comentário
        $request->validate([
            'comentario' => 'required|string',
        ]);

        // Determinar o denunciado
        $denunciadoId = Auth::id() === $solicitacao->user_id
            ? $solicitacao->worker->user_id
            : $solicitacao->user_id;

        // Criar a denúncia
        Denuncia::create([
            'solicitacao_id' => $solicitacao->id,
            'denunciante_id' => Auth::id(),
            'denunciado_id' => $denunciadoId,
            'comentario' => $request->comentario,
        ]);

        // Redirecionar com mensagem de sucesso
        return redirect()->route(Auth::user()->role === 'cliente' ? 'dashboard' : 'worker-dashboard')
            ->with('success', 'Denúncia registrada com sucesso.');
    }



    /**
     * Exibe as solicitações finalizadas para o cliente denunciar trabalhadores.
     */
    public function cliente()
    {
        // Obter solicitações finalizadas pelo cliente autenticado
        $solicitacoes = Solicitacao::where('user_id', Auth::id())
            ->where('status', Solicitacao::STATUS_FINALIZADO)
            ->get();

        return view('denuncias.cliente', compact('solicitacoes'));
    }

    /**
     * Exibe as solicitações finalizadas para o trabalhador denunciar clientes.
     */
    public function trabalhador()
    {
        // Obter solicitações finalizadas pelo trabalhador autenticado
        $solicitacoes = Solicitacao::whereHas('worker', function ($query) {
            $query->where('user_id', Auth::id());
        })
            ->where('status', Solicitacao::STATUS_FINALIZADO)
            ->get();

        return view('denuncias.trabalhador', compact('solicitacoes'));
    }
}
