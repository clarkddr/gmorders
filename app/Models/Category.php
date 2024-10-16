<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;
    protected $connection = 'mssql';
    protected $table = 'Category';
    protected $primaryKey = 'CategoryId';

    public function subcategories(): belongsToMany
    {
        return $this->belongsToMany(Subcategory::class, 'CategoryHasSubcategory', 'CategoryId', 'SubcategoryId');
    }

}
