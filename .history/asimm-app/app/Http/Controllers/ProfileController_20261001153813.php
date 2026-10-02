<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    // Montre le formulaire de profil de l'utilisateur connecté
    public function edit(Request $request)
    {
        // Récupère l'utilisateur connecté
        $user = $request->user();

        // Passe l'utilisateur à la vue
        return view('profile.edit', compact('user'));
    }

    // Met à jour le prénom, le nom et l'email de l'utilisateur connecté
    public function update(Request $request)
    {
        // Récupère l'utilisateur connecté
        $user = $request->user();

        // Vérifie les informations envoyées par le formulaire
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            // L'email doit être unique, sauf pour l'utilisateur lui-même
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255',
                Rule::unique('users', 'email')->ignore($user->id)],
        ]);

        // Met à jour les informations de l'utilisateur
        $user->first_name = $validated['first_name'];
        $user->last_name = $validated['last_name'];
        // Nom complet construit à partir du prénom et du nom
        $user->name = $validated['first_name'] . ' ' . $validated['last_name'];
        $user->email = $validated['email'];

        // Enregistre les modifications dans la base de données
        $user->save();

        // Revient au profil avec un message de confirmation
        return redirect()->route('profile.edit')->with('status', 'profile-updated');
    }

    // Supprime le compte de l'utilisateur connecté
    public function destroy(Request $request)
    {
        // Demande le mot de passe actuel pour confirmer la suppression
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        // Récupère l'utilisateur connecté
        $user = $request->user();

        // Déconnecte l'utilisateur
        Auth::logout();

        // Supprime son compte de la base de données
        $user->delete();

        // Vide la session et régénère le jeton de sécurité
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirige vers la page d'accueil
        return redirect('');
    }
}
