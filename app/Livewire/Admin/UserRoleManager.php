<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class UserRoleManager extends Component
{
    use WithPagination;

    public $search = '';
    public $roleFilter = '';
    public $selectedUserId;
    public $newRole;

    protected $queryString = ['search', 'roleFilter'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingRoleFilter()
    {
        $this->resetPage();
    }

    public function openRoleModal($userId)
    {
        $user = User::findOrFail($userId);
        $this->selectedUserId = $userId;
        $this->newRole = $user->role;
        $this->dispatch('open-modal', name: 'change-role');
    }

    public function saveRole()
    {
        $this->validate([
            'newRole' => 'required|in:admin,coordinator,volunteer',
        ]);

        $user = User::findOrFail($this->selectedUserId);
        $user->role = $this->newRole;
        $user->save();

        session()->flash('message', 'Peran pengguna ' . $user->name . ' berhasil diubah menjadi ' . $this->newRole . '.');
        $this->dispatch('close-modal', name: 'change-role');
        $this->reset(['selectedUserId', 'newRole']);
    }

    public function render()
    {
        $users = User::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->when($this->roleFilter, function ($query) {
                $query->where('role', $this->roleFilter);
            })
            ->orderBy('name')
            ->paginate(10);

        return view('livewire.admin.user-role-manager', [
            'users' => $users,
            'roles' => ['admin', 'coordinator', 'volunteer'],
        ]);
    }
}

