@php
    $inputClass = 'w-full rounded-md border border-slate-300 px-3 py-2 text-sm shadow-sm focus:border-slate-500 focus:outline-none focus:ring-1 focus:ring-slate-500';
    $labelClass = 'mb-1 block text-sm font-medium text-slate-700';
    $errorClass = 'mt-1 text-sm text-rose-600';
@endphp

<div class="space-y-5">
    <div>
        <label for="titre" class="{{ $labelClass }}">Titre</label>
        <input id="titre" name="titre" value="{{ old('titre', $publication?->titre) }}" class="{{ $inputClass }}">
        @error('titre') <p class="{{ $errorClass }}">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="description" class="{{ $labelClass }}">Contenu</label>
        <textarea id="description" name="description" rows="6" class="{{ $inputClass }}">{{ old('description', $publication?->description) }}</textarea>
        @error('description') <p class="{{ $errorClass }}">{{ $message }}</p> @enderror
    </div>

    <div class="grid gap-5 sm:grid-cols-2">
        <div>
            <label for="type" class="{{ $labelClass }}">Type</label>
            <input id="type" name="type" value="{{ old('type', $publication?->type) }}" class="{{ $inputClass }}">
            @error('type') <p class="{{ $errorClass }}">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="prix" class="{{ $labelClass }}">Prix</label>
            <input id="prix" name="prix" type="number" step="0.01" value="{{ old('prix', $publication?->prix) }}" class="{{ $inputClass }}">
            @error('prix') <p class="{{ $errorClass }}">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="ville" class="{{ $labelClass }}">Ville</label>
            <input id="ville" name="ville" value="{{ old('ville', $publication?->ville) }}" class="{{ $inputClass }}">
            @error('ville') <p class="{{ $errorClass }}">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="id_categorie" class="{{ $labelClass }}">Catégorie</label>
            <input id="id_categorie" name="id_categorie" type="number" value="{{ old('id_categorie', $publication?->id_categorie) }}" class="{{ $inputClass }}">
            @error('id_categorie') <p class="{{ $errorClass }}">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="statut" class="{{ $labelClass }}">Statut</label>
            <input id="statut" name="statut" value="{{ old('statut', $publication?->statut ?? 'active') }}" class="{{ $inputClass }}">
            @error('statut') <p class="{{ $errorClass }}">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="image" class="{{ $labelClass }}">Image</label>
            <input id="image" name="image" type="file"
                   accept="image/jpeg,image/png,image/webp"
                   class="block w-full text-sm text-slate-700 file:mr-3 file:rounded-md file:border-0 file:bg-slate-900 file:px-3 file:py-2 file:text-sm file:font-medium file:text-white hover:file:bg-slate-700">
            @error('image') <p class="{{ $errorClass }}">{{ $message }}</p> @enderror
        </div>
    </div>

    <div class="flex items-center gap-3 pt-2">
        <button type="submit"
                class="rounded-md bg-slate-900 px-4 py-2 text-sm font-medium text-white hover:bg-slate-700">
            Enregistrer
        </button>
        <a href="{{ route('publications.index') }}"
           class="text-sm text-slate-600 hover:text-slate-900 hover:underline">
            Annuler
        </a>
    </div>
</div>

