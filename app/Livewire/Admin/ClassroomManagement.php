<?php

namespace App\Livewire\Admin;

use App\Models\Classroom;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class ClassroomManagement extends Component
{
    use WithPagination;

    public string $search = '';
    public bool $isOpen = false;
    public ?int $classroomId = null;
    public string $name = '';
    public ?string $description = '';
    public ?string $enroll_code = '';
    public ?int $admin_id = null;
    public bool $manageMembersMode = false;
    public $selectedClass = null;

    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function openModal()
    {
        $this->resetValidation();
        $this->reset(['name', 'description', 'classroomId', 'manageMembersMode', 'selectedClass', 'admin_id']);
        $this->enroll_code = strtoupper(bin2hex(random_bytes(3))); // Default random code
        $this->isOpen = true;
    }

    public function manageMembers($id)
    {
        $this->selectedClass = Classroom::with('users')->find($id);
        $this->manageMembersMode = true;
        $this->isOpen = true;
    }

    public function updateMemberStatus($userId, $status)
    {
        $this->selectedClass->users()->updateExistingPivot($userId, ['status' => $status]);
        $this->selectedClass->load('users');
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->manageMembersMode = false;
    }

    public function edit($id)
    {
        $this->manageMembersMode = false;
        $classroom = Classroom::findOrFail($id);
        $this->classroomId = $id;
        $this->name = $classroom->name;
        $this->description = $classroom->description;
        $this->enroll_code = $classroom->enroll_code;
        $this->admin_id = $classroom->admin_id;
        $this->isOpen = true;
    }

    public function store()
    {
        $rules = $this->rules;
        if ($this->classroomId) {
            $rules['enroll_code'] = 'required|unique:classrooms,enroll_code,' . $this->classroomId;
        }

        $this->validate($rules);

        Classroom::updateOrCreate(['id' => $this->classroomId], [
            'name' => $this->name,
            'description' => $this->description,
            'enroll_code' => $this->enroll_code,
            'admin_id' => $this->admin_id,
        ]);

        session()->flash('message', $this->classroomId ? 'Kelas berhasil diperbarui.' : 'Kelas berhasil ditambahkan.');
        $this->closeModal();
    }

    public function delete(int $id)
    {
        if ($this->isRestrictedAdmin()) {
            session()->flash('error', 'Hanya admin global yang dapat menghapus kelas.');
            return;
        }
        Classroom::findOrFail($id)->delete();
        session()->flash('message', 'Kelas berhasil dihapus.');
    }

    private function isRestrictedAdmin()
    {
        $user = auth()->user();
        $managedCount = $user->managedClassrooms()->count();
        // If they are assigned to classes, they are restricted
        return $managedCount > 0;
    }

    public function render()
    {
        $user = auth()->user();
        $managedClassIds = $user->managedClassrooms()->pluck('id')->toArray();
        $isGlobalAdmin = empty($managedClassIds);

        $classrooms = Classroom::with(['users', 'admin'])
            ->withCount('users')
            ->when(!$isGlobalAdmin, fn($q) => $q->whereIn('id', $managedClassIds))
            ->when($this->search, fn($q) => $q->where('name', 'like', '%' . $this->search . '%'))
            ->latest()
            ->paginate(10);

        $admins = User::where('role', 'admin')->get();

        return view('livewire.admin.classroom-management', compact('classrooms', 'admins', 'isGlobalAdmin'))
            ->layout('layouts.admin');
    }
}
