<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Models\User;
use App\Models\Solicitacao;

class Denuncia extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'solicitacao_id',
        'denunciante_id',
        'denunciado_id',
        'comentario',
    ];

    public function solicitacao()
    {
        return $this->belongsTo(Solicitacao::class);
    }

    public function denunciante()
    {
        return $this->belongsTo(User::class, 'denunciante_id');
    }

    public function denunciado()
    {
        return $this->belongsTo(User::class, 'denunciado_id');
    }
}
