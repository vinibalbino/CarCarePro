<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Addres extends Model
{
    use HasFactory;

    protected $table = 'address';

    protected $fillable = [
        'street',
        'house_number',
        'zipcode',
        'city',
        'neighborhood',
    ];
}
