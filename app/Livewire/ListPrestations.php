<?php

namespace App\Livewire;

use App\Models\Prestation;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class ListPrestations extends Component
{
    use WithPagination;

    /** Terme de recherche (lié au champ de filtre). */
    public string $search = '';

    /** Réinitialise la pagination quand la recherche change. */
    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $prestations = Prestation::active()
            ->withCount('avis')
            ->withAvg('avis', 'note')
            ->when($this->search, function ($query) {
                $query->where('nom', 'like', "%{$this->search}%")
                      ->orWhere('description', 'like', "%{$this->search}%");
            })
            ->orderBy('nom')
            ->paginate(9);

        return view('livewire.list-prestations', [
            'prestations' => $prestations,
        ]);
    }
}
