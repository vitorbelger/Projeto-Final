<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Models\User;
use App\Models\Solicitacao;

class Avaliacao extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'avaliacoes'; // Nome correto da tabela

    protected $fillable = ['solicitacao_id', 'avaliador_id', 'avaliado_id', 'nota', 'comentario'];

    // Relacionamento com a solicitação
    public function solicitacao()
    {
        return $this->belongsTo(Solicitacao::class);
    }

    // Relacionamento com o usuário que avaliou
    public function avaliador()
    {
        return $this->belongsTo(User::class, 'avaliador_id');
    }

    // Relacionamento com o usuário avaliado
    public function avaliado()
    {
        return $this->belongsTo(User::class, 'avaliado_id');
    }
}

