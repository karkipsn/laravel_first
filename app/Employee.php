<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Employee extends Model
{   

 use SoftDeletes;

 protected $table = 'employees';
 protected $dates = ['deleted_at'];

 protected $fillable = [
    'name', 'add','date_hired','birthdate','department_id',
];

public function depaertment(){
   return $this->belongsTo(Department::class);
}

public function tasks(){
   return $this->hasMany(Task::class);
}
}
