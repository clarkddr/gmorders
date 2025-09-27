<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BranchMaxMin extends Model
{
    protected $table = 'branch_maxmins';
    protected $fillable = [
        'branch_id', 'maxmin_id','max','min'
    ];
    public function maxmin()
    {
        return $this->belongsTo(Maxmin::class);
    }

    public function branch(){
        return $this->belongsTo(Branch::class, 'branch_id', 'BranchId');
    }
}
