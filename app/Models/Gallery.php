<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = ['code'];


    public function images(): HasMany {
        return $this->hasMany(Image::class);        
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            DB::beginTransaction();

            try {
                // Obtener el año en formato corto
                $year = now()->format('y');

                // Obtener el último valor incremental para el año actual
                $lastOrder = self::where('code', 'like', "GA$year-%")
                                 ->orderBy('code', 'desc')
                                 ->lockForUpdate()
                                 ->first();

                // Calcular el nuevo número secuencial
                $number = $lastOrder ? intval(substr($lastOrder->code, 5)) + 1 : 1;

                // Formatear el nuevo valor incremental
                $order->code = sprintf('GA%s-%02d', $year, $number);

                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
        });
    }
    
}
