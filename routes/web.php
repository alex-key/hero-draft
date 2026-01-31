<?php

use App\Models\HeroCard;
use App\Services\HeroCardService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::get('/', function (Request $request) {
    $currentHero = null;
    $heroUuid = $request->cookie(HeroCardService::COOKIE_NAME);

    if ($heroUuid) {
        $currentHero = HeroCard::where('uuid', $heroUuid)->first();
    }

    return Inertia::render('Home', [
        'canRegister' => Features::enabled(Features::registration()),
        'currentHero' => $currentHero,
        'cards' => HeroCard::all(),
    ]);
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/settings.php';
require __DIR__.'/api.php';
