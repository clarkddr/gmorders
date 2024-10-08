<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Family extends Model
{
    use HasFactory;
    protected $connection = 'mssql';
    protected $table = 'Family';
    protected $primaryKey = 'FamilyId';
    
    public function projection(): HasMany
    {
        return $this->hasMany(Projection::class,'FamilyId');
    }
}
