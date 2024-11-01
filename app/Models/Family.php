<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

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

    public function subcategories(): BelongsToMany
    {
        return $this->belongsToMany(Subcategory::class, 'FamilyHasSubcategory','FamilyId','SubcategoryId');
    }

    public function category(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, CategoryHasFamily::class, 'FamilyId', 'CategoryId');
    }
}
