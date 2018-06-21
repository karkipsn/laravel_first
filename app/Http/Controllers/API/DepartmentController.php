<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Department;
use Validator;

class DepartmentController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $departments = Department::all();

       return $this->sendResponse($departments->toArray(), 'Departments retrieved successfully.');
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

       $validator = Validator::make($input, [
        'name' => 'required|string|max:60|unique:departments',
        
    ]);

       if($validator->fails()){
        return $this->sendError('Validation Error.', $validator->errors());       
    }
    $department = Department::create($input);
    return $this->sendResponse($department->toArray(), 'Department created successfully.');
    }

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
    public function update(Request $request, Department $department)
    {
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
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $department)
    {
        $department->delete();

        return $this->sendResponse($department->toArray(), 'Department deleted successfully.');
    }
}
