<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Otp extends Model
{
    protected $fillable = [
        'user_id',
        'code',
        'expires_at',
        'attempts',
        'resend_attempts',
        'last_sent_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
