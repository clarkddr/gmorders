<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Projection extends Model
{
    use HasFactory;

    protected $fillable = ['name','start','end'];

    public function projectionamounts(): HasMany
    {
        return $this->HasMany(ProjectionAmount::class);
    }

}
