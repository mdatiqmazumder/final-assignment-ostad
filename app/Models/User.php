<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'password', 'role'];

    function isAdmin(){
        return $this->role == 'admin';
    }

    function isCustomer(){
        return $this->role == 'customer';
    }

    function rentals() {
        return $this->hasMany(Rental::class);
    }
}
