<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;
    protected $connection = 'mssql';
    protected $table = 'Branch';
    protected $primaryKey = 'BranchId';
}
