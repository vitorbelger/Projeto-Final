<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();

        if ($user->role === 'cliente') {
            return view('profile.user.edit', compact('user'));
        } elseif ($user->role === 'trabalhador') {
            return view('profile.worker.worker-edit', compact('user'));
        }

        return abort(403, 'Acesso não autorizado');
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        // Verificar se a senha fornecida está correta
        if (!Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'password' => ['A senha fornecida está incorreta.'],
            ]);
        }

        // Diferenciar os campos permitidos conforme a role
        if ($user->role === 'cliente') {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
                'telefone' => 'nullable|string|max:15',
                'endereco' => 'nullable|string|max:255',
            ]);
        } elseif ($user->role === 'trabalhador') {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
                'telefone' => 'nullable|string|max:15',
                'endereco' => 'nullable|string|max:255',
                'profissao' => 'required_if:role,trabalhador|nullable|string|max:255',
                'curriculo' => 'nullable|string|max:1000',
            ]);
        }

        // Preencher o modelo do usuário com os dados validados
        $user->fill($validatedData);

        // Se o e-mail foi alterado, invalidar a verificação de e-mail
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        // Redirecionamento específico para cada role
        if ($user->role === 'cliente') {
            return Redirect::route('profile.user.edit')->with('status', 'profile-updated');
        } elseif ($user->role === 'trabalhador') {
            return Redirect::route('profile.worker.worker-edit')->with('status', 'profile-updated');
        }
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
