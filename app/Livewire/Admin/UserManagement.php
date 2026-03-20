<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class UserManagement extends Component
{
    use WithPagination;

    public string $search = '';
    public string $roleFilter = '';
    public bool $isOpen = false;
    public ?int $userId = null;
    public string $name = '';
    public string $email = '';
    public string $role = 'user';
    public string $password = '';

    protected $rules = [
        'name'     => 'required|string|max:255',
        'email'    => 'required|email',
        'role'     => 'required|in:admin,user',
        'password' => 'nullable|min:6',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function openModal()
    {
        $this->resetForm();
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->userId = null;
        $this->name = '';
        $this->email = '';
        $this->role = 'user';
        $this->password = '';
        $this->resetErrorBag();
    }

    public function edit(int $id)
    {
        $user = User::findOrFail($id);
        $this->userId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->role ?? 'user';
        $this->isOpen = true;
    }

    public function store()
    {
        $this->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $this->userId,
            'role'     => 'required|in:admin,user',
            'password' => $this->userId ? 'nullable|min:6' : 'required|min:6',
        ]);

        $data = [
            'name'  => $this->name,
            'email' => $this->email,
        ];

        // Only allow non-restricted admins to change roles or set to admin
        if (!$this->isRestrictedAdmin()) {
            $data['role'] = $this->role;
        } else {
            $data['role'] = 'user'; // Force user for restricted admins if creating? Or just keep original.
            if ($this->userId) {
                unset($data['role']); // Keep existing role if editing
            }
        }


        if ($this->password) {
            $data['password'] = bcrypt($this->password);
        }

        User::updateOrCreate(['id' => $this->userId], $data);

        session()->flash('message', $this->userId ? 'Pengguna berhasil diperbarui.' : 'Pengguna baru berhasil ditambahkan.');
        $this->closeModal();
    }

    public function delete(int $id)
    {
        if ($this->isRestrictedAdmin()) {
            session()->flash('error', 'Hanya admin global yang dapat menghapus pengguna.');
            return;
        }
        User::findOrFail($id)->delete();
        session()->flash('message', 'Pengguna berhasil dihapus.');
    }

    private function isRestrictedAdmin()
    {
        $user = auth()->user();
        return $user->managedClassrooms()->count() > 0;
    }

    public function render()
    {
        $users = User::when($this->search, fn($q) => $q->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('email', 'like', '%' . $this->search . '%'))
            ->when($this->roleFilter, fn($q) => $q->where('role', $this->roleFilter))
            ->latest()
            ->paginate(10);

        return view('livewire.admin.user-management', compact('users'))
            ->layout('layouts.admin');
    }
}
