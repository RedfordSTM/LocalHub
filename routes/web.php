<?php

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicationController;
use App\Http\Controllers\RecherchePublicationController;

Route::redirect('/', '/publications');

Route::resource('publications', PublicationController::class);

Route::get('/recherche/publications', RecherchePublicationController::class)
    ->name('recherche.publications');

Route::post('/langue', function (Request $request) {
$data = $request->validate([
    'locale' => ['required', Rule::in(['fr', 'en'])],
]);

$request->session()->put('locale', $data['locale']);

return back();
})->name('locale.update');
