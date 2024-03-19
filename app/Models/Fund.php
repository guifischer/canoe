<?php

namespace App\Models;

use App\Observers\FundObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

#[ObservedBy([FundObserver::class])]
class Fund extends Model
{
    protected $fillable = [
        'name',
        'start_year',
        'manager_id',
        'aliases',
    ];

    protected $casts = [
        'aliases' => 'array',
    ];

    public function manager(): BelongsTo
    {
        return $this->belongsTo(FundManager::class);
    }

    public function companies(): HasManyThrough
    {
        return $this->hasManyThrough(Company::class, FundManager::class);
    }
}
