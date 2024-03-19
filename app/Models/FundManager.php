<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FundManager extends Model
{
    protected $fillable = [
        'name',
    ];

    public function funds(): HasMany
    {
        return $this->hasMany(Fund::class);
    }
}
