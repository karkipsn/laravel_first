<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Department;
use Validator;
use App\Http\Controllers\Controller as Controller;
use App\Http\Controllers\BaseController as BaseController;
use App\Http\Controllers\API\TestController ;

class DepartmentController extends BaseController
{
    
    protected $ser;

    public function __construct(BaseController $ser) 
    { 
        $this->ser = $ser; 
    }

    
    public function index()
    {
         $departments = Department::all();
    
         if (\Request::is('api*')) {
        return BaseController::sendResponse($departments->toArray(), 'Departments retrieved successfully.');
       
    }else{
         return view('departments/index')->with($departments);
        
    }

   // $departments = Department::latest()->paginate(5);

        
    }

    public function create()
    {
        return view('departments/create');
    }



    public function store(Request $request)
    {

        $input = $request->all();

        $type = $request->input('type');
        //$type = ['type' => $request['type']];
        //dd($type);

        $validator = Validator::make($input, [
            'name' => 'required|string|max:60|unique:departments',

        ]);
        if($validator->fails()){

            if($type ==1){
             return redirect('/departments')
             ->withErrors($validator)
             ->withInput();
         }

         if( $request->wantsJson()){

            return BaseController::sendError('Validation Error.', $validator->errors());
        }   
    }

    $department = Department::create($input);

    if($type ==1){

       return redirect('/departments')
       ->with('success','Department created successfully.');
   }
   if($request->wantsJson()){
       return BaseController::sendResponse($department->toArray(), 'Department created successfully.');
   }
}


private function validateInput($request) {
    $this->validate($request, [
        'name' => 'required|string|max:60|unique:departments'
    ]);
}

    
    public function show(Department $department)
    {
        return view('departments.show',compact('department'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $department = Department::find($id);
        // Redirect to department list if updating department wasn't existed
        if ($department == null || count($department) == 0) {
            return redirect()->intended('/departments');
        }
        return view('departments/edit',compact('department'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function update(Request $request, $id)
    // {

    //     $department = Department::findOrFail($id);

    //     $this->validateInput($request);

    //     $input = ['name' => $request['name']];

    //     Department::where('id', $id)->update($input);

    //     return redirect()->route('/departments')
    //     ->with('success','Department updated successfully');
    // }
    public function update(Request $request, Department $department)
    {
        try {

            $input = $request->all();
            $type = $request->input('type');

            $validator = Validator::make($input, [
                'name' => 'required|string|max:60|unique:departments',
            ]);

            if($validator->fails()){

                if($type ==1){
                 return redirect('/departments')
                 ->withErrors($validator)
                 ->withInput();
             }

             if( $request->wantsJson()){

                return BaseController::sendError('Validation Error.', $validator->errors());

            }   
        }

        $department->name = $input['name'];
        $department->save();


        if($type ==1){

           return redirect('/departments')
           ->with('success','Department updated successfully.');
       }
       if($request->wantsJson()){
           return $this->sendResponse($department->toArray(), 'Department updated successfully.');

       }} catch (Exception $e) {
        if($type ==1){

           return redirect('/departments')
           ->with('success','Department updated UnSuccessfull.');
       }
       if($request->wantsJson()){
          return $this->sendError('Department delete Unsuccessful.', $e->getMessage());  
      }
  }}


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{

         Department::where('id', $id)->delete();

         return redirect('/departments')
         ->with('success','Department deleted successfully');

     }catch (Exception $e) {

        return redirect('/departments')
        ->with('Error','Department deleted UnSuccessfull');
    }
}

}
    

    /**
     * Search department from database base on some specific constraints
     *
     * @param  \Illuminate\Http\Request  $request
     *  @return \Illuminate\Http\Response
     */
    // public function search(Request $request) {
    //     $constraints = [
    //         'name' => $request['name']
    //         ];

    //    $departments = $this->doSearchingQuery($constraints);
    //    return view('department/index', ['departments' => $departments, 'searchingVals' => $constraints]);
    // }

    // private function doSearchingQuery($constraints) {
    //     $query = department::query();
    //     $fields = array_keys($constraints);
    //     $index = 0;
    //     foreach ($constraints as $constraint) {
    //         if ($constraint != null) {
    //             $query = $query->where( $fields[$index], 'like', '%'.$constraint.'%');
    //         }

    //         $index++;
    //     }
    //     return $query->paginate(5);
    // }
    

