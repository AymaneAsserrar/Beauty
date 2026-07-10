<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class AppLayout extends Component
{
    /**
     * Retourne la vue de mise en page pour les pages authentifiées.
     */
    public function render(): View
    {
        return view('layouts.app');
    }
}
