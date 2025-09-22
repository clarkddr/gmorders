<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Maxmin extends Model
{
    use SoftDeletes;
    protected $fillable = ['code'];

    public function supplier(){
        return $this->belongsTo(Supplier::class,'SupplierId');
    }

    public function family(){
        return $this->belongsTo(Family::class,'FamilyId');
    }

    public function subcategory(){
        return $this->belongsTo(Subcategory::class,'SubcategoryId');
    }

    public function color(){
        return $this->belongsTo(Color::class,'ColorId');
    }

    public function branches(){
        return $this->hasMany(BranchMaxMin::class,'maxmin_id');
    }

}
