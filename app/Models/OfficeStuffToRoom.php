<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfficeStuffToRoom extends Model
{
    use HasFactory;

    protected $table = 'OfficeStuffToRoom';
    protected $primaryKey = 'ID';
    public $timestamps=false;
}
