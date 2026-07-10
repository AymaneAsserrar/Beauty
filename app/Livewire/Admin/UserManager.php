<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class UserManager extends Component
{
    use WithPagination;

    public bool $showForm = false;
    public ?int $editingId = null;

    public string $name = '';
    public string $email = '';
    public string $role = 'client';
    public string $phone = '';
    public string $bio = '';
    public string $password = '';

    public string $filtreRole = '';

    public function updatingFiltreRole(): void
    {
        $this->resetPage();
    }

    protected function rules(): array
    {
        return [
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', Rule::unique('users', 'email')->ignore($this->editingId)],
            'role'     => ['required', Rule::in(['admin', 'prestataire', 'client'])],
            'phone'    => ['nullable', 'string', 'max:30'],
            'bio'      => ['nullable', 'string', 'max:500'],
            // Mot de passe requis seulement à la création.
            'password' => [$this->editingId ? 'nullable' : 'required', 'string', 'min:8'],
        ];
    }

    public function nouveau(): void
    {
        $this->resetForm();
        $this->showForm = true;
    }

    public function editer(int $id): void
    {
        $u = User::findOrFail($id);

        $this->editingId = $u->id;
        $this->name  = $u->name;
        $this->email = $u->email;
        $this->role  = $u->role;
        $this->phone = $u->phone ?? '';
        $this->bio   = $u->bio ?? '';
        $this->password = '';

        $this->showForm = true;
    }

    public function enregistrer(): void
    {
        $data = $this->validate();

        // On ne touche au mot de passe que s'il a été renseigné.
        if (! empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        User::updateOrCreate(['id' => $this->editingId], $data);

        session()->flash('status', $this->editingId ? 'Utilisateur modifié.' : 'Utilisateur créé.');
        $this->resetForm();
        $this->showForm = false;
    }

    public function supprimer(int $id): void
    {
        // On empêche un admin de se supprimer lui-même.
        if ($id === auth()->id()) {
            session()->flash('error', "Vous ne pouvez pas supprimer votre propre compte.");
            return;
        }

        User::findOrFail($id)->delete();
        session()->flash('status', 'Utilisateur supprimé.');
    }

    private function resetForm(): void
    {
        $this->reset(['editingId', 'name', 'email', 'phone', 'bio', 'password']);
        $this->role = 'client';
        $this->resetValidation();
    }

    public function render()
    {
        $users = User::when($this->filtreRole, fn ($q) => $q->where('role', $this->filtreRole))
            ->orderBy('name')
            ->paginate(15);

        return view('livewire.admin.user-manager', [
            'users' => $users,
        ]);
    }
}
