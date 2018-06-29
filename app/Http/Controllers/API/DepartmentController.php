<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller as Controller;
use App\Http\Controllers\BaseController as BaseController;
use App\Http\Controllers\DepartmentController as DController;
use App\Department;
use Validator;

class DepartmentController extends DController
{
  
  protected $dep;
  public function __construct(DController $dep)
  {
     $this->dep = $dep;
     // $this->middleware('auth:api');
  }

  
    public function index()
    {
      return DController::index();
     }


     public function store(Request $request)
     {
        return DController::store($request);
     }


    
    public function show($id)
    {
      return DController::show($id);
         }



    public function update(Request $request, Department $department)
    {
       return DController::update($request,$department);
  }


    public function destroy( $id)
    {
       
     return DController::destroy($id);
}

}
