<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use App\Http\Controllers\BaseController as BaseController;
use App\Http\Controllers\EmployeeController as EController;
use App\Employee;
use App\Department;
use Validator;
use Illuminate\Support\Facades\DB;


class EmployeeController extends EController
{
    
  protected $dep;
  public function __construct(EController $dep)
  {
     $this->dep = $dep;
  }

    public function index()
    {
        return EController::index();
    }

    
    public function store(Request $request)
    {    
        return EController::store($request);
            
        }

    
    public function show($id)
    {
        return Econtroller::show($id);
    }

    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        return Econtroller::update($request,$employee);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function destroy( $id)
    {
        return Econtroller::destroy($id);
    
     }
}
