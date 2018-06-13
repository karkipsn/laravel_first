<?php

namespace App\Http\Controllers;

use App\Task;
use App\Employee;

use Illuminate\Http\Request;

class EmployeeTaskController extends Controller
{

     public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = DB::table('tasks')
        ->leftJoin('employees', 'tasks.employee_id', '=', 'employees.id')
        ->select ('tasks.*','employees.name as employee_name','employees.id as employee_id')
        ->paginate(5);

          // $employees = DB::table('employees')
       //  ->leftJoin('departments', 'employees.department_id', '=', 'departments.id')
       //  ->select('employees.*', 'departments.name as department_name', 'departments.id as department_id')
       //  ->paginate(5);


        return view('tasks/index', ['tasks' => $tasks]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $employees = Employee::all();

           return view('tasks/create', [
            'employees' => $employees]);
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
        $keys = ['title','description','attachment','deadline','employee_id'];

        $input = $this->createQueryInput($keys,$reuest);
         
        Task::create($input);

        return redirect()->intended('/tasks');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    private function validateInput($request) {
        $this->validate($request, [
            'title' => 'required|max:60',
            'description' => 'required|max:120',
            'attachment' => 'required',
            'deadline' => 'required',
            'employee_id' => 'required'

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
