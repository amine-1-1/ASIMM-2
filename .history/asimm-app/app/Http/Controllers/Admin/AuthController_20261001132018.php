<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
 /** @var \App\Models\User $user */

class AuthController extends Controller
{
    // Montre le formulaire de connexion administrateur
    public function create()
    {
        return view('admin.auth.login');
    }

    // Connecte un administrateur
    public function store(Request $request)
    {
        // Vérifie que l'email et le mot de passe sont bien remplis
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Essaie de connecter l'utilisateur avec ces identifiants
        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            // Si l'email ou le mot de passe est faux, retourne au formulaire avec une erreur
            return back()
                ->withErrors(['email' => 'Identifiants invalides ou accès non autorisé.'])
                ->onlyInput('email');
        }

        // Récupère l'utilisateur qui vient de se connecter
        $user = Auth::user();

        // Vérifie que l'utilisateur a bien le rôle admin
        if (! $user->hasRole('admin')) {
            // Si ce n'est pas un admin, on le déconnecte immédiatement
            Auth::logout();

            // Même message qu'un mauvais mot de passe, pour ne pas révéler qui est admin
            return back()
                ->withErrors(['email' => 'Identifiants invalides ou accès non autorisé.'])
                ->onlyInput('email');
        }

        // Régénère la session pour éviter le vol de session
        $request->session()->regenerate();

        // Enregistre la date de dernière connexion
        $user->last_login_at = now();
        $user->save();

        // Redirige vers la page admin demandée, ou la liste des utilisateurs par défaut
        return redirect()->intended(route('admin.users.index'));
    }

    // Déconnecte l'administrateur
    public function destroy(Request $request)
    {
        // Déconnecte l'utilisateur
        Auth::logout();

        // Vide la session et régénère le jeton de sécurité
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Retourne au formulaire de connexion admin
        return redirect()->route('admin.login');
    }
}
