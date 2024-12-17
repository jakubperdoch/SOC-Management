<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deadline extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_date',
        'second_date',
        'third_date'
    ];

    public $timestamps = false;
    protected $table = 'deadlines';
}
