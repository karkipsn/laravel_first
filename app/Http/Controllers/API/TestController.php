<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use App\Http\Controllers\DepartmentController as DepartmentController;
use App\Department;

class TestController extends DepartmentController
{
  
  protected $dep;

  public function __construct(DepartmentController $dep)
  {
     $this->dep = $dep;
  }

    public function index()
    {
     
      return DepartmentController::index();

 }
}