<?php

namespace App\Http\Controllers;
use Excel;
use File;
use Session;
use App\Employee;
use App\Department;
use Datatables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
   public function __construct()
   {
    $this->middleware('auth');
}


public function index()
{
    $employees = DB::table('employees')
    ->leftJoin('departments', 'employees.department_id', '=', 'departments.id')
    ->select('employees.*', 'departments.name as department_name', 'departments.id as department_id')
    ->paginate(5);

    return view('employees/index', ['employees' => $employees]);
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

        $this->validateInput($request);
        
        $keys = ['name', 'add', 'birthdate', 'date_hired', 'department_id', 'department_id', ];
        $input = $this->createQueryInput($keys, $request);

        Employee::create($input);

        return redirect()->intended('/employees');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        //
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
        // Redirect to state list if updating state wasn't existed
     if ($employee == null || count($employee) == 0) {
        return redirect()->intended('/employees');
    }

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
    public function update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);
        $this->validateInput($request);
        // Upload image
        $keys = ['name',  'add', 'birthdate', 'date_hired', 'department_id', 'department_id'];
        $input = $this->createQueryInput($keys, $request);

        Employee::where('id', $id)
        ->update($input);

        return redirect()->intended('/employees');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
     Employee::where('id', $id)->delete();
     return redirect()->intended('/employees');
 }




 


 private function validateInput($request) {
    $this->validate($request, [
        'name' => 'required|max:60',
        'add' => 'required|max:120',
        'birthdate' => 'required',
        'date_hired' => 'required',
        'department_id' => 'required'
    ]);
}

private function createQueryInput($keys, $request) {
    $queryInput = [];
    for($i = 0; $i < sizeof($keys); $i++) {
        $key = $keys[$i];
        $queryInput[$key] = $request[$key];
    }

    return $queryInput;
}
}
