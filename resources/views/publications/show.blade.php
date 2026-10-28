@extends('layouts.app')

@section('title', $publication->titre)

@section('content')
    <article class="rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-slate-900">{{ $publication->titre }}</h1>
                <p class="mt-1 text-sm text-slate-500">Par {{ $publication->utilisateur->nom }}</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('publications.edit', $publication) }}"
                   class="rounded-md border border-slate-300 px-3 py-1.5 text-sm text-slate-700 hover:bg-slate-100">
                    Modifier
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
            </div>
        </div>

        @if ($publication->image_path)
            <img src="{{ Storage::disk('public')->url($publication->image_path) }}"
                 alt="{{ $publication->titre }}"
                 class="mt-6 max-h-96 w-full rounded-md object-cover">
        @endif

        <p class="mt-6 whitespace-pre-line text-sm text-slate-700">{{ $publication->description }}</p>
    </article>

    <div class="mt-6">
        <a href="{{ route('publications.index') }}" class="text-sm text-slate-600 hover:text-slate-900 hover:underline">
            &larr; Retour aux publications
        </a>
    </div>
@endsection
