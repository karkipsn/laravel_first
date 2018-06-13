<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{   
	protected $table = 'employees';
     protected $fillable = [
        'name', 'add','date_hired','birthdate','department_id',
    ];
}
