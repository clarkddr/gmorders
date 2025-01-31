<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Projection;

class ProjectionAmount extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function families(): HasMany
    {
        return $this->hasMany(Family::class,'FamilyId');
    }

    public function projection(): BelongsTo
    {
        return $this->belongsTo(Projection::class);
    }

}
