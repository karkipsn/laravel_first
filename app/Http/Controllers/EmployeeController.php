<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Excel;
use File;
use Session;
use App\Employee;
use App\Department;
use Datatables;
use Validator;
use App\Http\Controllers\Controller as Controller;
use App\Http\Controllers\BaseController as BaseController;


class EmployeeController extends BaseController
{


   public function __construct()
   {
   // $this->middleware('auth');
   }


   public function index()
   {
      try{

         $employees = DB::table('employees')
         ->leftJoin('departments', 'employees.department_id', '=', 'departments.id')
         ->select('employees.*', 'departments.name as department_name', 'departments.id as department_id')->paginate(5);


         if (\Request::is('api*')) {

             return BaseController::sendResponse($employees->toArray(), 'Employees retrieved successfully.');

         }else{

            return view('employees/index', ['employees' => $employees]);      
        }

    }catch (Exception $e){

        if(\Request::is('api*')){

           return $this->sendError('Employees retrival Unsuccessful.', $e->getMessage());  }
           else{
               return redirect('/employees')
               ->with('Error','Employees retrival UnSuccessfull.');
           }

       } 
   }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
     $departments = Department::all();

     return view('employees/create', [
        'departments' => $departments]);
 }


 public function add_import(){

    return view ('employees/add_import');

}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {

           $input = $request->all();

           $validator = Validator::make($input, [
            'name' => 'required|string|max:10',
            'add' => 'required|string|max:120',
            'birthdate' => 'required|date',
            'date_hired' => 'required|date',
            'department_id' => 'required|exists:departments,id',

        ]);

           if($validator->fails()){

            if(\Request::is('api*')){

               return BaseController::sendError('Validation or Data Format Error.', $validator->errors());
           } else{

             return redirect('/employees')->withErrors($validator)
             ->withInput();
         }  
     }
     $employee = Employee::create($input);

     if(\Request::is('api*')){
       return BaseController::sendResponse($employee->toArray(), 'Employee created successfully.');

   }else{
       return redirect('/employees')
       ->with('success','Employee created successfully.');
   }            
} catch (Exception $e) {

  if(\Request::is('api*')){
      return $this->sendError('Employee creation Unsuccessful.', $e->getMessage());  }else{
       return redirect('/employees')
       ->with('Error','Employee creation UnSuccessfull.');
   }
}
}

    /**
     * Display the specified resource.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $employee = Employee::find($id);

        if (is_null($employee)) {

           if(\Request::is('api*')){

             return $this->sendDelete('No employee with such id exists .');
         }
         else{

           return redirect('/employees')
           ->with('Error','No such employee with Id');
       }    
   }
   else{

    try {

        $employee = DB::table('employees')
        ->leftJoin('departments', 'employees.department_id', '=', 'departments.id')
        ->select('employees.*', 'departments.name as department_name', 'departments.id as department_id' )
        ->where('employees.id', '=', $id)
        ->get();

        if(\Request::is('api*')){

         return $this->sendResponse($employee->toArray(), 'Department retrieved successfully.');
     }else{

       return view('employees.show',compact('employee'));
   }    
}        
catch (Exception $e) {

    if(\Request::is('api*')){

      return $this->sendError('Department retrival Unsuccessful.', $e->getMessage());  }
      else{
       return redirect('/employees')
       ->with('Error','Employee retrival UnSuccessfull.');
   }
}
}
}

public function import(Request $request){
         //validate the xls file
    $this->validate($request, array(
        'file'      => 'required'
    ));

    if($request->hasFile('file')){
        $extension = File::extension($request->file->getClientOriginalName());
        if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {

            $path = $request->file->getRealPath();
            $data = Excel::load($path, function($reader) {
            })->get();
            if(!empty($data) && $data->count()){

                foreach ($data as $key => $value) {
                    $insert[] = [
                        'name' => $value->name,
                        'add' => $value->add,
                        'birthdate' => $value->birthdate,
                        'date_hired' => $value->date_hired,
                        'department_id' => $value->department_id,
                    ];
                }

                if(!empty($insert)){

                    $insertData = DB::table('employees')->insert($insert); 
                }
                return redirect()->intended('/employees');
            }

        }
    }
}

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
     $employee = Employee::find($id);


     $departments = Department::all();

     return view('employees/edit', ['employee' => $employee, 
        'departments' => $departments]);
 }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        $id = Employee::findOrFail($employee);

        if (is_null($id)) {

           if(\Request::is('api*')){

             return $this->sendDelete('No employee with such id exists .');
         }
         else{

           return redirect('/employees')
           ->with('Error','No such employee with Id');
       }    
   }
   else{
    try {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required|string|max:10',
            'add' => 'required|string|max:120',
            'birthdate' => 'required|date',
            'date_hired' => 'required|date',
            'department_id' => 'required|exists:departments,id',
        ]);

        if($validator->fails()){

            if(\Request::is('api*')){

               return BaseController::sendError('Validation or Data Format Error.', $validator->errors());
           } else{

             return redirect('/employees')->withErrors($validator)
             ->withInput();
         }  
     }

     $employee->name = $input['name'];
     $employee->add = $input['add'];
     $employee->birthdate = $input['birthdate'];
     $employee->date_hired = $input['date_hired'];
     $employee->department_id = $input['department_id'];
     $employee->save();

     if(\Request::is('api*')){

         return $this->sendResponse($employee->toArray(), 'Employee updated successfully.');
     }else{

       return view('employees.show',compact('employee'));
   } 

} catch (Exception $e) {
     if(\Request::is('api*')){

      return $this->sendError('Employee updation Unsuccessful.', $e->getMessage());  }
      else{
       return redirect('/employees')
       ->with('Error','Employee retrival UnSuccessfull.');
   }
}
}
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
   public function destroy($id)
{

         // $department= Employee::where('id', $id);
      $employee = Employee::find($id);

      if(is_null($employee)){

         if(\Request::is('api*')){

          return $this->sendDelete('No employee with such id exists .');
      }else{

         return redirect('/employees')
         ->with('Error','No such department with Id');
     }    
 }
     try{

 $employee->delete();

 if(\Request::is('api*')){

   return $this->sendResponse($employee, 'Employee deletion successfully.'); 
}else{

   return redirect('/employees')
   ->with('success','Employee deleted successfully');
}

}catch (Exception $e) {

    if(\Request::is('api*')){
      return $this->sendError('Employee delete Unsuccessful.', $e->getMessage());  }else{

        return redirect('/employees')
        ->with('Error','Employee deleted UnSuccessfull');
    }
}
}

}


// private function validateInput($request) {
//     $this->validate($request, [
//         'name' => 'required|string|max:10',
//         'add' => 'required|string|max:120',
//         'birthdate' => 'required|date',
//         'date_hired' => 'required|date',
//         'department_id' => 'required|integer'
//     ]);

// }


// private function createQueryInput($keys, $request) {
//     $queryInput = [];
//     for($i = 0; $i < sizeof($keys); $i++) {
//         $key = $keys[$i];
//         $queryInput[$key] = $request[$key];
//     }

//     return $queryInput;
// }

