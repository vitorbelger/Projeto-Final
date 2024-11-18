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

        return view('profile.edit', [
            'user' => $request->user(),
        ]);
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
            'profissao' => 'required|string|max:255',
            'curriculo' => 'nullable|string|max:1000',
        ]);
    }

    // Atualizar informações básicas do usuário
    $user->fill($validatedData);
    if ($user->isDirty('email')) {
        $user->email_verified_at = null;
    }
    $user->save();

    // Atualizar informações do trabalhador (se aplicável)
    if ($user->role === 'trabalhador') {
        $worker = $user->worker; // Obter o modelo relacionado
        $worker->update([
            'profissao' => $request->input('profissao'),
            'curriculo' => $request->input('curriculo'),
        ]);
    }

    return redirect()->route('profile.edit')->with('status', 'profile-updated');
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
