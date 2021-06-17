<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfficeStuff extends Model
{
    use HasFactory;

    protected $table = 'OfficeStuff';
    protected $primaryKey = 'ID';
    public $timestamps=false;
}
