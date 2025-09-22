<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    use HasFactory;

    protected $connection = 'mssql';
    protected $table = 'Color';
    protected $primaryKey = 'ColorId';

}
