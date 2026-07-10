<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class GuestLayout extends Component
{
    /**
     * Retourne la vue de mise en page pour les pages publiques (invités).
     */
    public function render(): View
    {
        return view('layouts.guest');
    }
}
