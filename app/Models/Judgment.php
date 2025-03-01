<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Judgment extends Model
{
    use HasFactory;

    protected $fillable = [
        'conflict',
        'public_servant',
        'licensed_professional',
        'contractor',
        'foreign_trainee',
        'mental_illness',
        'trouble',
    ];

    public $timestamps = false;
}
