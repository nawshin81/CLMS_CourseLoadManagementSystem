<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class instructors_infos extends Model
{
        protected $table = 'instructors_infos';
    
    protected $fillable = [
        'department',
        'name',
        'credit',
        
    ];
}
