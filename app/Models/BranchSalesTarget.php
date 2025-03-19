<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BranchSalesTarget extends Model
{
    use HasFactory;
    protected $fillable = ['branch_id','slug'];
}
