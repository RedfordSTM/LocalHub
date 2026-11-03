@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-semibold text-slate-900">Mon compte : {{ $user->nom }} {{ $user->prenom }}</h1>

    @if (session('status'))
        <p class="mt-4 rounded-md bg-emerald-50 p-3 text-sm text-emerald-700">{{ session('status') }}</p>
    @endif

    <section class="mt-6 space-y-4">
        @forelse ($publications as $publication)
            <article class="flex items-center justify-between rounded-lg border border-slate-200 bg-white p-4 shadow-sm">
                <a href="{{ route('publications.show', $publication) }}" class="text-slate-900 hover:underline">
                    {{ $publication->titre }}
                </a>
                <form method="post" action="{{ route('publications.destroy', $publication) }}"
                      onsubmit="return confirm('Supprimer cette publication ?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="rounded-md bg-rose-600 px-3 py-1.5 text-sm font-medium text-white hover:bg-rose-500">
                        Supprimer
                    </button>
                </form>
            </article>
        @empty
            <p class="rounded-lg border border-dashed border-slate-300 bg-white p-6 text-center text-sm text-slate-500">
                Aucune publication.
            </p>
        @endforelse
    </section>

    <section class="mt-10 rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
        <h2 class="text-lg font-semibold text-slate-900">Changer le mot de passe</h2>

        <form method="post" action="{{ route('account.password.update') }}" class="mt-4 space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label for="current_password" class="block text-sm font-medium text-slate-700">Mot de passe actuel</label>
                <input type="password" name="current_password" id="current_password" required
                       class="mt-1 block w-full rounded-md border border-slate-300 px-3 py-2 text-sm shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">
                @error('current_password')
                    <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-slate-700">Nouveau mot de passe</label>
                <input type="password" name="password" id="password" required
                       class="mt-1 block w-full rounded-md border border-slate-300 px-3 py-2 text-sm shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">
                @error('password')
                    <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-slate-700">Confirmer le nouveau mot de passe</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required
                       class="mt-1 block w-full rounded-md border border-slate-300 px-3 py-2 text-sm shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">
            </div>

            <button type="submit"
                    class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-500">
                Mettre à jour le mot de passe
            </button>
        </form>
    </section>

    <section class="mt-6 rounded-lg border border-rose-200 bg-rose-50 p-6">
        <h2 class="text-lg font-semibold text-rose-800">Supprimer mon compte</h2>
        <p class="mt-1 text-sm text-rose-700">Cette action est définitive et supprimera toutes vos données.</p>

        <form method="post" action="{{ route('account.destroy') }}" class="mt-4 space-y-4"
              onsubmit="return confirm('Supprimer définitivement votre compte ?');">
            @csrf
            @method('DELETE')

            <div>
                <label for="delete_password" class="block text-sm font-medium text-rose-800">Mot de passe</label>
                <input type="password" name="password" id="delete_password" required
                       class="mt-1 block w-full rounded-md border border-rose-300 px-3 py-2 text-sm shadow-sm focus:border-rose-500 focus:outline-none focus:ring-1 focus:ring-rose-500">
                @error('password')
                    <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                    class="rounded-md bg-rose-600 px-4 py-2 text-sm font-medium text-white hover:bg-rose-500">
                Supprimer mon compte
            </button>
        </form>
    </section>
@endsection
