<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function create()
    {
            return view('admin.auth.login');
    }

    public function store(Request $request )
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
    if(!Auth::attempt($credentials , $request->boolean('remember'))){
        return back()
            ->WithErrors(['email' => 'indentifiants invalides ou accès non autorisé.'])
            ->onlyInput('email');

    }
    $user = Auth::user();

    if (! $user->hasRole('admin')) {
        Auth::logout();

        return back()
            ->withErrors(['email' => 'Identifiants invalides ou accès non autorisé.'])
            ->onlyInput('email');
    }

    $request->session()->regenerate();

    $user->last_login_at = now();
    $user->save();

    return redirect()->intended(route('admin.users.index'));
    }

    public function destroy(Request $request):
    {
        Auth::logout();

        $request->session()

    }
}
