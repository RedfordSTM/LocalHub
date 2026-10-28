<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Publication;
use App\Models\User;
use App\Http\Requests\EnregistrerPublicationRequest;
use Illuminate\Support\Facades\Storage;
use Throwable;

class PublicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $publications = Publication::query()
            ->with('utilisateur:id_utilisateur,nom')
            ->whereNotNull('date_creation')
            ->latest('date_creation')
            ->paginate(10);

        return view('publications.index', compact('publications'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('publications.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EnregistrerPublicationRequest $request): RedirectResponse
    {
        $user = User::query()->firstOrFail();

        $data = $request->safe()->except('image');
        $path = $request->file('image')?->store('publications', 'public');

        try {
            $publication = Publication::create([
                ...$data,
                ...($path ? ['image_path' => $path] : []),
                'id_utilisateur' => $user->id_utilisateur,
                'date_creation' => now(),
            ]);
        } catch (Throwable $exception) {
            if ($path) {
                Storage::disk('public')->delete($path);
            }
            throw $exception;
        }

        return redirect()->route('publications.show', $publication)
            ->with('status', 'publication créé.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Publication $publication): View
    {
        abort_if($publication->date_creation === null, 404);

        return view('publications.show', [
            'publication' => $publication->load('utilisateur', 'category'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Publication $publication): View
    {
        return view('publications.edit', compact('publication'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EnregistrerPublicationRequest $request, Publication $publication): RedirectResponse
    {
        $data = $request->safe()->except('image');
        $newPath = $request->file('image')?->store('publications', 'public');
        $oldPath = $publication->image_path;

        try {
            $publication->update([
                ...$data,
                ...($newPath ? ['image_path' => $newPath] : []),
            ]);
        } catch (Throwable $exception) {
            if ($newPath) {
                Storage::disk('public')->delete($newPath);
            } 
            throw $exception;
        }
        
        if ($newPath && $oldPath) {
            Storage::disk('public')->delete($oldPath);
        }

        return redirect()->route('publications.show', $publication)
            ->with('status', 'publication modifié.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Publication $publication): RedirectResponse
    {
        $publication->delete();

        return redirect()->route('publications.index')
            ->with('status', 'publication supprimé.');
    }
}
