<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    protected $fillable = [
        'name',
        'price',
        'benefits',
        'file_path',
        'duration_days',
        'is_active',
    ];

    public function userContracts()
    {
        return $this->hasMany(UserContract::class);
    }
}
