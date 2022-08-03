<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class curriculum extends Model
{
    protected $table = 'curricula';
    
    protected $fillable = [
        'curriculum_year',
        'offered_by',
        'offered_to',
        'program_code',
        'course_code',
        'course_name',
        'lec',
        'lab',
        'units',
        'level',
        'period',
    ];
}
