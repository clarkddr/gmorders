<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Image extends Model
{
    use HasFactory;
    protected $fillable = ['gallery_id','supplier_id','subcategory','url'];

    public function gallery(): BelongsTo {
        return $this->belongsTo(Gallery::class);
    }
    public function supplier(): BelongsTo {
        return $this->belongsTo(Supplier::class)->withDefault();
    }
}
