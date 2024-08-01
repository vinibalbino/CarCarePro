<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    use HasFactory;

    protected $table = 'owners';

    protected $fillable = [
        'full_name',
        'cpf',
        'sex',
        'addres_id',
    ];

    public function address()
    {
        return $this->belongsTo(Addres::class, 'addres_id');
    }
}
