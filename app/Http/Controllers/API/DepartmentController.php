<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
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
  }

  
    public function index()
    {
     //  $departments = Department::all();

     // // return $this->sendResponse($departments->toArray(), 'Departments retrieved successfully.');
      return DController::index();
 }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(Request $request)
    // {
    //      $input = $request->all();

    //    $validator = Validator::make($input, [
    //     'name' => 'required|string|max:60|unique:departments',
    
    // ]);

    //    if($validator->fails()){
    //     return $this->sendError('Validation Error.', $validator->errors());       
    // }
    // $department = Department::create($input);
    
    // return $this->sendResponse($department->toArray(), 'Department created successfully.');
    // }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       $department = Department::find($id);

       if (is_null($department)) {
        return $this->sendError('Department not found.');
    }
    return $this->sendResponse($department->toArray(), 'Department retrieved successfully.');
}



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Department $department)
    {
        try {
         
            $input = $request->all();

            $validator = Validator::make($input, [
                'name' => 'required|string|max:60|unique:departments',
            ]);

            if($validator->fails()){
                return $this->sendError('Validation Error.', $validator->errors());       
            }
            $department->name = $input['name'];
            $department->save();

            return $this->sendResponse($department->toArray(), 'Department updated successfully.');

        } catch (Exception $e) {
          return $this->sendError('Department delete Unsuccessful.', $e->getMessage());  
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
            $department = Department::find($id);

            if($department != null){
              $department->delete();
              
              return $this->sendDelete('Department delete Successful.');
          }else{
            return $this->sendDelete('Department not found. Enter the Valid Deprtment');
        }

    } catch (Exception $e) {
        return $this->sendError('Department delete Unsuccessful.', $e->getMessage());
    }
    
}
}
