<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProjectionAmount extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function families(): HasMany
    {
        return $this->hasMany(Family::class,'FamilyId');
    } 

}
