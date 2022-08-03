<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class dup_teach extends Model
{
    protected $table = 'dup_teach';
    
    protected $fillable = [
        'id',
        'instructor_id',
        'course_code',
        'course_credit',
        'course_taken'
    ];
}
