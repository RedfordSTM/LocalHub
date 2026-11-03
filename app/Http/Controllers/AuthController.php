<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'courriel' => ['required', 'email'],
            'mot_de_passe' => ['required', 'string'],
        ]);

        if (! Auth::attempt([
            'courriel' => $credentials['courriel'],
            'password' => $credentials['mot_de_passe'],
        ])) {
            return back()
                ->withErrors(['courriel' => 'Identifiants invalides.'])
                ->onlyInput('courriel');
        }

        $request->session()->regenerate();

        return redirect()->intended(route('publications.index'));
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('publications.index');
    }
}
