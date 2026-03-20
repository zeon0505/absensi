<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QrCode extends Model
{
    protected $table = 'qr_codes';

    protected $fillable = [
        'code',
        'expired_at',
        'classroom_id',
    ];

    protected $casts = [
        'expired_at' => 'datetime',
    ];

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }
}
