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

    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {    
        return EController::store($request);
            
        }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //$employee = Employee::find($id);
        $employee = DB::table('employees')
        ->leftJoin('departments', 'employees.department_id', '=', 'departments.id')
        ->select('employees.*', 'departments.name as department_name', 'departments.id as department_id' )
        ->where('employees.id', '=', $id)
        ->get();

        if (is_null($employee)) {
            return $this->sendError('Employee not found.');
        }

        return $this->sendResponse($employee->toArray(), 'Employee retrieved successfully.');
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
        try {

            $input = $request->all();
            $messages = [
                'name.required' => 'The name:attribute is required',
                'add.required' => 'The add:attribute is required',
                'birthdate.required' => 'The birthdate:attribute is required',
                'date_hired.required' => 'The date_hired:attribute is required',
                'department_id.required' => 'The department_id:attribute is required',

            ];
            $validator = Validator::make($input, [
                'name' => 'required|string|max:10',
                'add' => 'required|string|max:120',
                'birthdate' => 'required|date',
                'date_hired' => 'required|date',
                'department_id' => 'required|exists:departments,id',
            ],$messages);

            if($validator->fails()){
                return $this->sendError('Validation Error or Invalid Json Format.', $validator->errors());       
            }
            $employee->name = $input['name'];
            $employee->add = $input['add'];
            $employee->birthdate = $input['birthdate'];
            $employee->date_hired = $input['date_hired'];
            $employee->department_id = $input['department_id'];
            $employee->save();

            return $this->sendResponse($employee->toArray(), 'Employee updated successfully.');
        } catch (Exception $e) {
            return $this->sendError('Employee Update Operation Failed',$e->getMessage());
            
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function destroy( $id)
    {
        try {
            $employee = Employee::find($id);

            if($employee != null){
              $employee->delete();
              
              return $this->sendDelete('Employee delete Successful.');
          }else{
            return $this->sendDelete('Employee not found. Enter the Valid Deprtment');
        }

    } catch (Exception $e) {
        return $this->sendError('Employee delete Unsuccessful.', $e->getMessage());
    }
    
}
}
