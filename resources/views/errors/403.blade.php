@extends('layouts.app')

@section('content')
    <h1>Accès refusé</h1>
    <p>Vous n'avez pas la permission d'effectuer cette action.</p>
    <a href="{{ route('home') }}">Retour à l'accueil</a>
@endsection
@extends('layouts.app')

@section('title', 'Accès refusé')

@section('content')
    <div class="mx-auto max-w-lg rounded-lg border border-slate-200 bg-white p-8 text-center shadow-sm">
        <p class="text-5xl font-bold text-rose-600">403</p>
        <h1 class="mt-4 text-xl font-semibold text-slate-900">Accès refusé</h1>
        <p class="mt-2 text-sm text-slate-600">
            Vous n'avez pas la permission d'accéder à cette page.
        </p>
        <a href="{{ route('publications.index') }}"
           class="mt-6 inline-block rounded-md bg-slate-900 px-4 py-2 text-sm font-medium text-white hover:bg-slate-700">
            Retour aux publications
        </a>
    </div>
@endsection
