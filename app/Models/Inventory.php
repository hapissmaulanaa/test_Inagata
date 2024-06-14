<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'quantity',
    ];

    // Atribut yang akan disembunyikan dari array respons JSON
    protected $hidden = [
        'created_at', 'updated_at',
    ];
}
