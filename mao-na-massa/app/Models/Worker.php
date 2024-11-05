<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Notifications\Notifiable;

class Worker extends Model
{
    use HasFactory, Notifiable;

    /**
     * Os atributos que são atribuíveis em massa.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'profissao',
        'curriculo',
    ];

    /**
     * Relacionamento com o modelo User.
     *
     * Cada Worker pertence a um User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
