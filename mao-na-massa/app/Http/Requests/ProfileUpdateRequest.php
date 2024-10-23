<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $this->user()->id],
            'cpf' => ['required', 'string', 'size:11', 'unique:users,cpf,' . $this->user()->id], // Validação do CPF
            'telefone' => ['nullable', 'string', 'max:15'], // Validação do telefone
            'endereco' => ['nullable', 'string', 'max:255'], // Validação do endereço
        ];
    }
}
