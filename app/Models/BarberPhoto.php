<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarberPhoto extends Model
{
    use HasFactory;

    protected $table = 'barbers_photo';
    public $timestamps = false;
}
