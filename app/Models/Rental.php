<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    use HasFactory;

    protected $fillable = [
        'car_id',
        'user_id',
        'start_date',
        'end_date',
        'total_cost',
        'status'
    ];

    function car() {
        return $this->belongsTo(Car::class);
    }
    function user() {
        return $this->belongsTo(User::class);
    }
}
