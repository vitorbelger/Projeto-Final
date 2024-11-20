<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Worker;
use App\Models\User;
use App\Models\Avaliacao;
use Illuminate\Notifications\Notifiable;

class Solicitacao extends Model
{
    use HasFactory, Notifiable;

    protected $table = 'solicitacoes'; // Nome correto da tabela

    // Define os campos permitidos para atribuição em massa
    protected $fillable = [
        'user_id',
        'worker_id',
        'descricao',
        'data_inicio',
        'data_conclusao',
        'data_finalizacao',
        'status',
    ];

    // Define os casts para conversão automática de dados
    protected $casts = [
        'data_inicio' => 'date',
        'data_conclusao' => 'date',
        'data_finalizacao' => 'date'
    ];

    // Define os valores de status como constantes
    const STATUS_PENDENTE = 'pendente';
    const STATUS_ACEITA = 'aceita';
    const STATUS_REJEITADA = 'rejeitada';
    const STATUS_FINALIZADO = 'finalizado';

    // Relacionamento com o cliente (usuário que solicita o serviço)
    public function cliente()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relacionamento com o trabalhador (usuário que realiza o serviço)
    public function worker()
    {
        return $this->belongsTo(Worker::class);
    }

    //Relacionamento com Avaliação
    public function avaliacao()
    {
        return $this->hasOne(Avaliacao::class);
    }

    //Relacionamento com Denuncia
    //Relacionamento com Avaliação
    public function denuncia()
    {
        return $this->hasOne(Denuncia::class);
    }


    // Scope para filtrar solicitações pendentes
    public function scopePendentes($query)
    {
        return $query->where('status', self::STATUS_PENDENTE);
    }

    // Scope para filtrar solicitações aceitas
    public function scopeAceitas($query)
    {
        return $query->where('status', self::STATUS_ACEITA);
    }

    // Scope para filtrar solicitações rejeitadas
    public function scopeRejeitadas($query)
    {
        return $query->where('status', self::STATUS_REJEITADA);
    }

    // Scope para filtrar solicitações finalizadas
    public function scopeFinalizadas($query)
    {
        return $query->where('status', self::STATUS_FINALIZADO);
    }
}
