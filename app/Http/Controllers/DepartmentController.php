<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Department;
use Validator;
use App\Http\Controllers\Controller as Controller;
use App\Http\Controllers\BaseController as BaseController;


class DepartmentController extends BaseController
{

    protected $ser;

    public function __construct(BaseController $ser) 
    { 
        $this->ser = $ser; 
    }

    
    public function index()
    {
        try{
           $departments = Department::all();

           if (\Request::is('api*')) {
            return BaseController::sendResponse($departments->toArray(), 'Departments retrieved successfully.');

        }else{
           return view('departments/index')->with($departments);       
       }
   }catch (Exception $e){
    if(\Request::is('api*')){
      return $this->sendError('Department retrival Unsuccessful.', $e->getMessage());  }else{
         return redirect('/departments')
         ->with('Error','Department retrival UnSuccessfull.');
     }

 }

}

public function create()
{
    return view('departments/create');
}



public function store(Request $request)
{
   try {

    $input = $request->all();

    $validator = Validator::make($input, [
        'name' => 'required|string|max:60|unique:departments',

    ]);

    if($validator->fails()){

        if(\Request::is('api*')){

         return BaseController::sendError('Validation or Data Format Error.', $validator->errors());
     } else{

       return redirect('/departments')->withErrors($validator)
       ->withInput();
   }  
}
$department = Department::create($input);

if(\Request::is('api*')){
 return BaseController::sendResponse($department->toArray(), 'Department created successfully.');

}else{
 return redirect('/departments')
 ->with('success','Department created successfully.');
}       
} catch (Exception $e) {

   if(\Request::is('api*')){
      return $this->sendError('Department creation Unsuccessful.', $e->getMessage());  }else{
         return redirect('/departments')
         ->with('Error','Department creation UnSuccessfull.');
     }

 }

}

public function show($id)
{
    try {

        $department = Department::find($id);

        if (is_null($department)) {

         if(\Request::is('api*')){

           return $this->sendDelete('No department with such id exists .');
       }else{

         return redirect('/departments')
         ->with('Error','No such department with Id');
     }    
 }else{
     if(\Request::is('api*')){

       return $this->sendResponse($department->toArray(), 'Department retrieved successfully.');
   }else{

     return view('departments.show',compact('department'));
 }    
}        
} catch (Exception $e) {

    if(\Request::is('api*')){

      return $this->sendError('Department retrival Unsuccessful.', $e->getMessage());  }
      else{

         return redirect('/departments')
         ->with('Error','Department retrival UnSuccessfull.');
     }
 }
}


public function edit($id)
{

    $department = Department::find($id);
        // Redirect to department list if updating department wasn't existed
    if ($department == null || count($department) == 0) {
        return redirect()->intended('/departments');
    }
    return view('departments/edit',compact('department'));
}



public function update(Request $request, Department $department)
{
    try {

        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required|string|max:60|unique:departments',
        ]);

        if($validator->fails()){

           if(\Request::is('api*')){

            return BaseController::sendError('Validation Error or Data Format Error.', $validator->errors());

        }else{
            return redirect('/departments')
            ->withErrors($validator)
            ->withInput();
        }   
    }

    $department->name = $input['name'];
    $department->save();

    if(\Request::is('api*')){
     return $this->sendResponse($department->toArray(), 'Department updated successfully.');

 }else{
     return redirect('/departments')
     ->with('success','Department updated successfully.');
 }
} catch (Exception $e) {

 if(\Request::is('api*')){
  return $this->sendError('Department delete Unsuccessful.', $e->getMessage());  }else{
     return redirect('/departments')
     ->with('success','Department updated UnSuccessfull.');
 }
}}


public function destroy($id)
{
    try{

         // $department= Department::where('id', $id);
      $department = Department::find($id);

      if(is_null($department)){

         if(\Request::is('api*')){

          return $this->sendDelete('No department with such id exists .');
      }else{

         return redirect('/departments')
         ->with('Error','No such department with Id');
     }    
 }

 $department->delete();

 if(\Request::is('api*')){

   return $this->sendResponse($department, 'Department deletion successfully.'); 
}else{

   return redirect('/departments')
   ->with('success','Department deleted successfully');
}

}catch (Exception $e) {

    if(\Request::is('api*')){
      return $this->sendError('Department delete Unsuccessful.', $e->getMessage());  }else{

        return redirect('/departments')
        ->with('Error','Department deleted UnSuccessfull');
    }
}
}

}





