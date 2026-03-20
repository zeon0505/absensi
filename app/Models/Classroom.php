<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    protected $fillable = [
        'name',
        'description',
        'enroll_code',
        'admin_id',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'classroom_user')
                    ->withPivot('status')
                    ->withTimestamps();
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function qrCodes()
    {
        return $this->hasMany(QrCode::class);
    }
}
