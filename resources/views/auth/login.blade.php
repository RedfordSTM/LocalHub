@extends('layouts.app')

@section('title', 'Connexion')

@section('content')
    <div class="auth-wrapper">
        <div class="auth-card">
            <header class="auth-header">
                <h1>Connexion</h1>
                <p class="auth-subtitle">Accédez à votre compte pour gérer vos publications.</p>
            </header>

            <form method="post" action="{{ route('login.store') }}" novalidate>
                @csrf

                <div class="form-group">
                    <label for="courriel">Adresse courriel</label>
                    <input id="courriel" name="courriel" type="email"
                           value="{{ old('courriel') }}"
                           autocomplete="email" required>
                    @error('courriel') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                <div class="form-group">
                    <label for="mot_de_passe">Mot de passe</label>
                    <input id="mot_de_passe" name="mot_de_passe" type="password"
                           autocomplete="current-password" required>
                    @error('mot_de_passe') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                <button type="submit" class="btn-primary">Se connecter</button>
            </form>

            <p class="auth-footer">
                Pas encore de compte ? <a href="{{ route('register') }}">S'inscrire</a>
            </p>
        </div>
    </div>
@endsection
