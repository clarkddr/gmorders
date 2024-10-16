<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Subcategory extends Model
{
    use HasFactory;
    protected $connection = 'mssql';
    protected $table = 'Subcategory';
    protected $primaryKey = 'SubcategoryId';

    public function category(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'CategoryHasSubcategory', 'SubcategoryId', 'CategoryId');
    }

    public function families(): BelongsToMany
    {
        return $this->belongsToMany(Family::class, 'FamilyHasSubcategory', 'SubcategoryId', 'FamilyId');
    }

}
