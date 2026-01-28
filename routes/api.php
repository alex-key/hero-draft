<?php

use App\Http\Controllers\CardController;
use Illuminate\Support\Facades\Route;

Route::prefix('api')->group(function () {
  Route::get('load-cards', function () {
    return [];
  })->name('load-cards');

  Route::post('generate-hero', [CardController::class, 'generateHero'])->name('generate-hero');
});
