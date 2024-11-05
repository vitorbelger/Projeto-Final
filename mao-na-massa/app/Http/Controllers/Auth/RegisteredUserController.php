<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Worker;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\Rule;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'cpf' => ['required', 'string', 'size:11', 'unique:' . User::class],
            'telefone' => ['required', 'string', 'max:15'],
            'endereco' => ['required', 'string', 'max:255'],
            'role' => ['required', Rule::in(['cliente', 'trabalhador'])],
            'profissao' => 'required_if:role,trabalhador|nullable|string|max:255',
            'curriculo' => 'nullable|string|max:1000', // Ajuste para limitar o tamanho do campo se necessário
        ]);

        // Cria o usuário no banco
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'cpf' => $request->cpf,
            'telefone' => $request->telefone,
            'endereco' => $request->endereco,
            'role' => $request->role, // Armazena o role no banco
        ]);

        // Verifica se o role é 'trabalhador' antes de criar o Worker
        if ($request->role === 'trabalhador') {
            Worker::create([
                'user_id' => $user->id,
                'profissao' => $request->profissao,
                'curriculo' => $request->curriculo,
            ]);
        }

        event(new Registered($user));
        Auth::login($user);
        if ($user->role === 'cliente') {
            return redirect()->route('dashboard');
        } elseif ($user->role === 'trabalhador') {
            return redirect()->route('worker-dashboard');
        }

        return redirect()->route('dashboard'); // ou qualquer outra rota padrão
    }
};
