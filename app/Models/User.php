<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'profile_photo_path',
        'last_active_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_active_at' => 'datetime',
        ];
    }
    
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function getProfilePhotoUrlAttribute()
    {
        return $this->profile_photo_path
                    ? asset('storage/' . $this->profile_photo_path)
                    : 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&color=7F9CF5&background=EBF4FF';
    }
    public function classrooms()
    {
        return $this->belongsToMany(Classroom::class, 'classroom_user')
                    ->withPivot('status')
                    ->withTimestamps();
    }

    public function isOnline()
    {
        return $this->last_active_at && $this->last_active_at->gt(now()->subMinutes(5));
    }

    public function managedClassrooms()
    {
        return $this->hasMany(Classroom::class, 'admin_id');
    }
}
