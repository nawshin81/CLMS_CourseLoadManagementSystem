<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class teach extends Model
{
    protected $table = 'teach';
    
    protected $fillable = [
        'id',
        'instructor_id',
        'course_code',
        'course_credit',
        'course_taken'
    ];
}
