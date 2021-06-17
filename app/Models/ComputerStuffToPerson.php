<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComputerStuffToPerson extends Model
{
    use HasFactory;

    protected $table = 'ComputerStuffToPerson';
    protected $primaryKey = 'ID';
    public $timestamps=false;
}
