@extends('layouts.app')

@section('title', 'Administration')

@section('content')
    <h1 class="text-2xl font-semibold text-slate-900">Tableau de bord</h1>
    <p class="mt-1 text-sm text-slate-500">Vue d'ensemble de la plateforme.</p>

    <section class="mt-6 grid grid-cols-2 gap-4 md:grid-cols-4">
        @foreach ([
            ['label' => 'Utilisateurs', 'value' => $stats['users'], 'color' => 'indigo'],
            ['label' => 'Publications', 'value' => $stats['publications'], 'color' => 'emerald'],
            ['label' => 'Réservations', 'value' => $stats['reservations'], 'color' => 'sky'],
            ['label' => 'Images', 'value' => $stats['images'], 'color' => 'amber'],
        ] as $card)
            <div class="rounded-lg border border-slate-200 bg-white p-4 shadow-sm">
                <p class="text-xs uppercase tracking-wide text-slate-500">{{ $card['label'] }}</p>
                <p class="mt-2 text-3xl font-semibold text-{{ $card['color'] }}-600">{{ $card['value'] }}</p>
            </div>
        @endforeach
    </section>

    <section class="mt-8 rounded-lg border border-slate-200 bg-white p-4 shadow-sm">
        <h2 class="text-lg font-semibold text-slate-900">Publications par mois</h2>
        <div class="mt-4 h-72">
            <canvas id="publicationsChart"
                    data-labels='@json($chartLabels)'
                    data-values='@json($chartValues)'></canvas>
        </div>
    </section>

    <div class="mt-8 grid gap-6 lg:grid-cols-2">
        <section class="rounded-lg border border-slate-200 bg-white p-4 shadow-sm">
            <h2 class="text-lg font-semibold text-slate-900">Derniers utilisateurs</h2>
            <ul class="mt-3 divide-y divide-slate-100 text-sm">
                @forelse ($derniersUtilisateurs as $u)
                    <li class="flex items-center justify-between py-2">
                        <span class="text-slate-800">{{ $u->prenom }} {{ $u->nom }}</span>
                        <span class="text-slate-500">{{ $u->courriel }}</span>
                    </li>
                @empty
                    <li class="py-2 text-slate-500">Aucun utilisateur.</li>
                @endforelse
            </ul>
        </section>

        <section class="rounded-lg border border-slate-200 bg-white p-4 shadow-sm">
            <h2 class="text-lg font-semibold text-slate-900">Dernières publications</h2>
            <ul class="mt-3 divide-y divide-slate-100 text-sm">
                @forelse ($dernieresPublications as $p)
                    <li class="flex items-center justify-between py-2">
                        <a href="{{ route('publications.show', $p) }}" class="truncate text-slate-800 hover:underline">
                            {{ \Illuminate\Support\Str::limit($p->titre, 50) }}
                        </a>
                        <span class="ml-3 shrink-0 text-slate-500">{{ $p->utilisateur?->nom }}</span>
                    </li>
                @empty
                    <li class="py-2 text-slate-500">Aucune publication.</li>
                @endforelse
            </ul>
        </section>
    </div>

    <section class="mt-8 rounded-lg border border-slate-200 bg-white p-4 shadow-sm">
        <h2 class="text-lg font-semibold text-slate-900">Images</h2>
        @if ($images->isEmpty())
            <p class="mt-3 text-sm text-slate-500">Aucune image.</p>
        @else
            <div class="mt-4 grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-4">
                @foreach ($images as $image)
                    <div class="overflow-hidden rounded-md border border-slate-200">
                        <img src="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($image->image_path) }}"
                             alt="{{ $image->titre }}"
                             class="h-32 w-full object-cover">
                        <div class="flex items-center justify-between gap-2 p-2 text-xs">
                            <span class="truncate text-slate-600">{{ \Illuminate\Support\Str::limit($image->titre, 20) }}</span>
                            <form method="post" action="{{ route('admin.images.destroy', $image) }}"
                                  onsubmit="return confirm('Supprimer cette image ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-rose-600 hover:underline">Suppr.</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </section>
@endsection

@push('scripts')
    @vite('resources/js/admin.js')
@endpush
