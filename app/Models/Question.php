<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    public $timestamps = TRUE;

    protected $table = 'question';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'description',
        'user_id',
        'subject_id',
        'is_public',
        'content',
        'timeline',
        'answer',
        'has_answer',
    ];

}
