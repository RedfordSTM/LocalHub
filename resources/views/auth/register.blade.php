@extends('layouts.app')

@section('title', 'Inscription')

@section('content')
    <div class="auth-wrapper">
        <div class="auth-card">
            <header class="auth-header">
                <h1>Créer un compte</h1>
                <p class="auth-subtitle">Rejoignez la communauté et partagez vos outils.</p>
            </header>

            <form method="post" action="{{ route('register.store') }}" novalidate>
                @csrf

                <div class="form-group">
                    <label for="nom">Nom</label>
                    <input id="nom" name="nom" type="text"
                           value="{{ old('nom') }}"
                           autocomplete="family-name" required>
                    @error('nom') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                <div class="form-group">
                    <label for="prenom">Prénom</label>
                    <input id="prenom" name="prenom" type="text"
                           value="{{ old('prenom') }}"
                           autocomplete="given-name" required>
                    @error('prenom') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                <div class="form-group">
                    <label for="courriel">Adresse courriel</label>
                    <input id="courriel" name="courriel" type="email"
                           value="{{ old('courriel') }}"
                           autocomplete="email" required>
                    @error('courriel') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                <div class="form-group">
                    <label for="ville">Ville</label>
                    <select id="ville" name="ville" required>
                        <option value="" disabled @selected(old('ville') === null)>Choisir une ville…</option>
                        @foreach (\App\Support\Villes::QUEBEC as $ville)
                            <option value="{{ $ville }}" @selected(old('ville') === $ville)>{{ $ville }}</option>
                        @endforeach
                    </select>
                    @error('ville') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                <div class="form-group">
                    <label for="mot_de_passe">Mot de passe</label>
                    <input id="mot_de_passe" name="mot_de_passe" type="password"
                           autocomplete="new-password" required>
                    @error('mot_de_passe') <p class="form-error">{{ $message }}</p> @enderror
                </div>

                <div class="form-group">
                    <label for="mot_de_passe_confirmation">Confirmation du mot de passe</label>
                    <input id="mot_de_passe_confirmation" name="mot_de_passe_confirmation" type="password"
                           autocomplete="new-password" required>
                </div>

                <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>
@error('g-recaptcha-response') <p>{{ $message }}</p> @enderror


                <button type="submit" class="btn-primary">Créer le compte</button>
            </form>

            <p class="auth-footer">
                Déjà un compte ? <a href="{{ route('login') }}">Se connecter</a>
            </p>
        </div>
    </div>
@endsection
