<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryHasFamily extends Model
{
    use HasFactory;
    protected $connection = 'mssql';
    protected $table = 'vw_FamilyHasCategory';

}
