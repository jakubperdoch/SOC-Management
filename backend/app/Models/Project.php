<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;


class Project extends Model
{
    use HasFactory, Searchable;

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
    ];

    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status,
            'student_id' => $this->student_id,
            'teacher_id' => $this->teacher_id,
            'odbor' => $this->odbor,
            'first_review' => $this->first_review,
            'second_review' => $this->second_review,
            'third_review' => $this->third_review,
            'mark' => $this->mark,
        ];

    }


    public $timestamps = true;
}
