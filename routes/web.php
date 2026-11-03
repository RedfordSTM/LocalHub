<?php

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicationController;
use App\Http\Controllers\RecherchePublicationController;
use App\Http\Controllers\InscriptionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompteController;
use App\Http\Middleware\EnsureManager;

Route::redirect('/', '/publications');

Route::resource('publications', PublicationController::class)
    ->only(['index', 'show']);

Route::resource('publications', PublicationController::class)
    ->only(['create', 'store', 'edit', 'update', 'destroy'])
    ->middleware('auth');

Route::get('/recherche/publications', RecherchePublicationController::class)
    ->name('recherche.publications');

Route::post('/langue', function (Request $request) {
    $data = $request->validate([
        'locale' => ['required', Rule::in(['fr', 'en'])],
    ]);

    $request->session()->put('locale', $data['locale']);

    return back();
})->name('locale.update');

// Sign up
Route::get('/inscription', [InscriptionController::class, 'create'])
    ->middleware('guest')->name('register');

Route::post('/inscription', [InscriptionController::class, 'store'])
    ->middleware('guest')->name('register.store');

// Sign in
Route::get('/connexion', [AuthController::class, 'create'])
    ->middleware('guest')->name('login');

Route::post('/connexion', [AuthController::class, 'login'])
    ->middleware(['guest', 'throttle:6,1'])->name('login.store');

Route::post('/deconnexion', [AuthController::class, 'logout'])
    ->middleware('auth')->name('logout');

// compte

Route::get('/', [PublicationController::class, 'index'])->name('home');

Route::get('/compte', [CompteController::class, 'show'])
    ->middleware('auth')->name('account.show');

Route::put('/compte/mot-de-passe', [CompteController::class, 'updatePassword'])
    ->middleware('auth')->name('account.password.update');

Route::delete('/compte', [CompteController::class, 'destroy'])
    ->middleware('auth')->name('account.destroy');


// admin
Route::middleware(['auth', EnsureManager::class])->group(function () {
    Route::get('/administration', [\App\Http\Controllers\AdminController::class, 'index'])
        ->name('admin.index');
    Route::delete('/administration/images/{publication}', [\App\Http\Controllers\AdminController::class, 'destroyImage'])
        ->name('admin.images.destroy');
});
