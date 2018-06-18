<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{

use SoftDeletes;
   protected $table = 'tasks';
   protected $dates = ['deleted_at'];

     protected $fillable = [
        'employee_id',
         'title',
         'description',
         'attachment',
         'deadline',
    ];

    public function employees(){
    	return $this->belongsTo(Employee::class);
    }
}
