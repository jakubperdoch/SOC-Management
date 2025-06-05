<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Project extends Model
{
    use HasFactory;

    public $timestamps = true;
    protected $table = 'projects';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'status',
        'student_id',
        'teacher_id',
        'odbor',
        'first_review',
        'second_review',
        'third_review',
        'mark',
        'document',
        'presentation',
    ];


}
