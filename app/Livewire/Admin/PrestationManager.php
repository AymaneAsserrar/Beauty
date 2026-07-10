<?php

namespace App\Livewire\Admin;

use App\Models\Prestation;
use Livewire\Component;
use Livewire\WithPagination;

class PrestationManager extends Component
{
    use WithPagination;

    /** Affichage du formulaire (création / édition). */
    public bool $showForm = false;

    /** ID en cours d'édition (null = création). */
    public ?int $editingId = null;

    /** Champs du formulaire. */
    public string $nom = '';
    public string $description = '';
    public $prix = '';
    public $duree = '';
    public string $image = '';
    public bool $active = true;

    protected function rules(): array
    {
        return [
            'nom'         => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'prix'        => ['required', 'numeric', 'min:0'],
            'duree'       => ['required', 'integer', 'min:5'],
            'image'       => ['nullable', 'string', 'max:255'],
            'active'      => ['boolean'],
        ];
    }

    /** Ouvre le formulaire vierge pour créer une prestation. */
    public function nouvelle(): void
    {
        $this->resetForm();
        $this->showForm = true;
    }

    /** Charge une prestation existante dans le formulaire. */
    public function editer(int $id): void
    {
        $p = Prestation::findOrFail($id);

        $this->editingId   = $p->id;
        $this->nom         = $p->nom;
        $this->description = $p->description ?? '';
        $this->prix        = $p->prix;
        $this->duree       = $p->duree;
        $this->image       = $p->image ?? '';
        $this->active      = $p->active;

        $this->showForm = true;
    }

    /** Enregistre (création ou mise à jour). */
    public function enregistrer(): void
    {
        $data = $this->validate();

        Prestation::updateOrCreate(
            ['id' => $this->editingId],
            $data
        );

        session()->flash('status', $this->editingId ? 'Prestation modifiée.' : 'Prestation ajoutée.');

        $this->resetForm();
        $this->showForm = false;
    }

    /** Supprime une prestation. */
    public function supprimer(int $id): void
    {
        Prestation::findOrFail($id)->delete();
        session()->flash('status', 'Prestation supprimée.');
    }

    /** Active/désactive rapidement une prestation. */
    public function toggleActive(int $id): void
    {
        $p = Prestation::findOrFail($id);
        $p->update(['active' => ! $p->active]);
    }

    private function resetForm(): void
    {
        $this->reset(['editingId', 'nom', 'description', 'prix', 'duree', 'image']);
        $this->active = true;
        $this->resetValidation();
    }

    public function render()
    {
        $prestations = Prestation::orderByDesc('id')->paginate(10);

        return view('livewire.admin.prestation-manager', [
            'prestations' => $prestations,
        ]);
    }
}
