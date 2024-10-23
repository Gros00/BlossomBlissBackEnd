<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cards extends Model
{

    protected $table = 'cards';

    protected $fillable = ['cost','title', 'rating', 'image', 'to', 'type'];

    protected $casts = [
        'to' => 'json',
        'type' => 'json',
    ];

    use HasFactory;
}
