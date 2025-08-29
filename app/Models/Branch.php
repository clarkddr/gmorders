<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static whereNotIn(string $string, int[] $array)
 */
class Branch extends Model
{
    use HasFactory;
    protected $connection = 'mssql';
    protected $table = 'Branch';
    protected $primaryKey = 'BranchId';


    public function projectionAmounts(): HasMany
    {
        return $this->hasMany(Projection::class,'BranchId');
    }
}
