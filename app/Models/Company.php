<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Company extends Model
{
    protected $fillable = [
        'name',
    ];

    public function funds(): HasManyThrough
    {
        return $this->hasManyThrough(Fund::class, CompanyFund::class);
    }
}
