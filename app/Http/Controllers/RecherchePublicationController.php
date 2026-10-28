<?php

namespace App\Http\Controllers;

use App\Models\Publication;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RecherchePublicationController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): JsonResponse
    {
        $data = $request->validate([
            'q' => ['required', 'string', 'min:2', 'max:50'],
        ]);

        $publications = Publication::query()
            ->whereNotNull('date_creation')
            ->where('titre', 'like', '%'.$data['q'].'%')
            ->orderBy('titre')
            ->limit(8)
            ->get(['id_publication', 'titre']);

        return response()->json([
            'data' => $publications->map(fn (Publication $publication) => [
                'id' => $publication->id_publication,
                'label' => $publication->titre,
                'url' => route('publications.show', $publication),
            ]),
        ]);
    }
}
