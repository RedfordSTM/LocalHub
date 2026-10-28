@extends('layouts.app')

@section('title', 'Publications')

@section('content')
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-slate-900">Publications</h1>
            <p class="mt-1 text-sm text-slate-500">
                Parcourez les publications ou utilisez la recherche.
            </p>
        </div>
        <div class="flex items-center gap-3">
            <form method="post" action="{{ route('locale.update') }}" class="flex items-center gap-2">
                @csrf
                <label for="locale" class="sr-only">Langue</label>
                <select id="locale" name="locale"
                        class="rounded-md border border-slate-300 px-2 py-1 text-sm shadow-sm focus:border-slate-500 focus:outline-none focus:ring-1 focus:ring-slate-500">
                    <option value="fr" @selected(app()->getLocale() === 'fr')>Français</option>
                    <option value="en" @selected(app()->getLocale() === 'en')>English</option>
                </select>
                <button type="submit"
                        class="rounded-md border border-slate-300 px-3 py-1 text-sm font-medium text-slate-700 hover:bg-slate-100">
                    Appliquer
                </button>
            </form>
            <a href="{{ route('publications.create') }}"
               class="inline-flex items-center rounded-md bg-slate-900 px-4 py-2 text-sm font-medium text-white hover:bg-slate-700">
                + Nouvelle publication
            </a>
        </div>
    </div>

    <section class="mb-8 rounded-lg border border-slate-200 bg-white p-4 shadow-sm">
        <label for="search" class="mb-2 block text-sm font-medium text-slate-700">
            {{ __('interface.search') }}
        </label>
        <input id="search" type="search" autocomplete="off"
               placeholder="Titre, description, ville..."
               class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm shadow-sm focus:border-slate-500 focus:outline-none focus:ring-1 focus:ring-slate-500"
               data-search-url="{{ route('recherche.publications') }}"
               data-searching="{{ __('interface.searching') }}"
               data-empty="{{ __('interface.no_results') }}"
               data-count="{{ __('interface.results') }}"
               data-error="{{ __('interface.search_error') }}">
        <p id="search-status" role="status" aria-live="polite"
           class="mt-2 text-sm text-slate-500"></p>
        <ul id="search-results" class="mt-3 divide-y divide-slate-100"></ul>
    </section>

    <section class="space-y-4">
        @forelse ($publications as $publication)
            <article class="rounded-lg border border-slate-200 bg-white p-5 shadow-sm transition hover:shadow-md">
                <h2 class="text-lg font-semibold text-slate-900">
                    <a href="{{ route('publications.show', $publication) }}" class="hover:underline">
                        {{ $publication->titre }}
                    </a>
                </h2>
                <p class="mt-1 text-sm text-slate-500">
                    Par {{ $publication->utilisateur->nom }}
                </p>
                <p class="mt-3 text-sm text-slate-700">
                    {{ \Illuminate\Support\Str::limit($publication->description, 200) }}
                </p>
            </article>
        @empty
            <p class="rounded-lg border border-dashed border-slate-300 bg-white p-6 text-center text-sm text-slate-500">
                Aucune publication.
            </p>
        @endforelse
    </section>

    @if ($publications->lastPage() > 1)
        <nav class="mt-8 flex items-center justify-between text-sm" aria-label="Pagination">
            <div class="text-slate-500">
                {{ __('interface.page_of', ['current' => $publications->currentPage(), 'last' => $publications->lastPage()]) }}
            </div>
            <div class="flex gap-2">
                @if ($publications->onFirstPage())
                    <span class="rounded-md border border-slate-200 px-3 py-1 text-slate-400">&laquo;</span>
                @else
                    <a href="{{ $publications->previousPageUrl() }}"
                       class="rounded-md border border-slate-300 px-3 py-1 text-slate-700 hover:bg-slate-100">&laquo;</a>
                @endif

                @if ($publications->hasMorePages())
                    <a href="{{ $publications->nextPageUrl() }}"
                       class="rounded-md border border-slate-300 px-3 py-1 text-slate-700 hover:bg-slate-100">&raquo;</a>
                @else
                    <span class="rounded-md border border-slate-200 px-3 py-1 text-slate-400">&raquo;</span>
                @endif
            </div>
        </nav>
    @endif
@endsection

