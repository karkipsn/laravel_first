<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Employee;
use App\Department;
use APIErrorValidationResponse;
use Validator;


class EmployeeController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $employees = Employee::all();
       return $this->sendResponse(json_decode($employees), 'Employees retrieved successfully.');
   }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      
}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $input = $request->all();

         // $department = Department::all();
       
          $messages = [
    'name.required' => 'The :attribute is required',
    'add.required' => 'The :attribute is required',
    'birthdate.required' => 'The :attribute is required',
    'date_hired.required' => 'The :attribute is required',
    'department_id.required' => 'The :attribute is required',

];

       $validator = Validator::make($input, [
        'name' => 'required|string|max:10',
        'add' => 'required|string|max:120',
        'birthdate' => 'required|date',
        'date_hired' => 'required|date',
        'department_id' => 'required|exists:departments,id',

    ], $messages);

       if($validator->fails()){
         //return new APIErrorValidationResponse($request, $validator);
        return $this->sendError('Validation Error or Invalid Json Format.', $validator->errors());       
    }
    $department = Employee::create($input);
    return $this->sendResponse($department->toArray(), 'Employee created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employee = Employee::find($id);

        if (is_null($employee)) {
            return $this->sendError('Employee not found.');
        }

        return $this->sendResponse($employee->toArray(), 'Employee retrieved successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $input = $request->all();

           $messages = [
    'name.required' => 'The name:attribute is required',
    'add.required' => 'The add:attribute is required',
    'birthdate.required' => 'The birthdate:attribute is required',
    'date_hired.required' => 'The date_hired:attribute is required',
    'department_id.required' => 'The department_id:attribute is required',
    
    'name.json' => 'The name :attribute field must be valid JSON',
    'add .json' => 'The :add attribute field must be valid JSON',
    'birthdate.json' => 'The birthdate :attribute field must be valid JSON',
    'date_hired.json' => 'The date_hired :attribute field must be valid JSON',
    'department_id.json' => 'The department_id :attribute field must be valid JSON',
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();

        return $this->sendResponse($employee->toArray(), 'Employee deleted successfully.');
    }
}
