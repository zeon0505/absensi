<?php

namespace App\Livewire\User;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Profile extends Component
{
    use WithFileUploads;

    public $name;
    public $email;
    public $password;
    public $password_confirmation;
    public $photo;

    public function mount()
    {
        $user = auth()->user();
        $this->name = $user->name;
        $this->email = $user->email;
    }

    public function updateProfile()
    {
        /** @var User $user */
        $user = auth()->user();
        
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8|confirmed',
            'photo' => 'nullable|image|max:1024', // Max 1MB
        ]);

        if ($this->photo) {
            // Delete old photo if exists
            if ($user->profile_photo_path) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }
            
            $path = $this->photo->store('profile-photos', 'public');
            $user->profile_photo_path = $path;
        }

        $user->name = $this->name;
        $user->email = $this->email;

        if ($this->password) {
            $user->password = Hash::make($this->password);
        }

        $user->save();

        $this->password = '';
        $this->password_confirmation = '';
        $this->photo = null;

        session()->flash('message', 'Profil berhasil diperbarui!');
        $this->dispatch('profile-updated');
    }

    public function render()
    {
        $layout = auth()->user()->role === 'admin' ? 'layouts.admin' : 'layouts.app';
        
        return view('livewire.user.profile')
            ->layout($layout);
    }
}
