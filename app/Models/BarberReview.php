<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarberReview extends Model
{
    use HasFactory;

    protected $table = 'barbers_reviews';
    public $timestamps = false;
}
