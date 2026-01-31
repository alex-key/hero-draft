<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\RedirectResponse;

abstract class Controller
{
    public function home(): RedirectResponse
    {
        return redirect()->route('home');
    }
}
