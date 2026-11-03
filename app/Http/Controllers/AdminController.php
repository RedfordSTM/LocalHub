<?php

namespace App\Http\Controllers;

use App\Models\Publication;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function index(): View
    {
        $stats = [
            'users' => User::count(),
            'publications' => Publication::count(),
            'reservations' => Reservation::count(),
            'images' => Publication::whereNotNull('image_path')->count(),
        ];

        $publicationsParMois = Publication::query()
            ->selectRaw("DATE_FORMAT(date_creation, '%Y-%m') as mois, COUNT(*) as total")
            ->whereNotNull('date_creation')
            ->where('date_creation', '>=', now()->subMonths(11)->startOfMonth())
            ->groupBy('mois')
            ->orderBy('mois')
            ->pluck('total', 'mois');

        $labels = [];
        $values = [];
        for ($i = 11; $i >= 0; $i--) {
            $mois = now()->subMonths($i)->format('Y-m');
            $labels[] = now()->subMonths($i)->translatedFormat('M Y');
            $values[] = (int) ($publicationsParMois[$mois] ?? 0);
        }

        $derniersUtilisateurs = User::query()
            ->orderByDesc('id_utilisateur')
            ->limit(10)
            ->get();

        $dernieresPublications = Publication::query()
            ->with('utilisateur:id_utilisateur,nom')
            ->latest('date_creation')
            ->limit(10)
            ->get();

        $images = Publication::query()
            ->whereNotNull('image_path')
            ->latest('date_creation')
            ->limit(50)
            ->get(['id_publication', 'titre', 'image_path', 'date_creation']);

        return view('admin.show', [
            'stats' => $stats,
            'chartLabels' => $labels,
            'chartValues' => $values,
            'derniersUtilisateurs' => $derniersUtilisateurs,
            'dernieresPublications' => $dernieresPublications,
            'images' => $images,
        ]);
    }

    public function destroyImage(Publication $publication): RedirectResponse
    {
        if ($publication->image_path) {
            Storage::disk('public')->delete($publication->image_path);
            $publication->update(['image_path' => null]);
        }

        return back()->with('status', 'Image supprimée.');
    }
}
