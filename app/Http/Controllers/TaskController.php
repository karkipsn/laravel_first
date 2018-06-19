<?php


namespace App\Http\Controllers;

use App\Task;
use App\Employee;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{

   public function __construct()
   {
    // $this->middleware('auth');
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

       $valid=$this->validateInput($request);
       
       if(!$valid){
        return back()
        ->with('error', 'Invalid input');
    }

    $path = $request->file('attachment')->store('avatars');

    $keys = ['title','description','deadline','employee_id',];

    $input = $this->createQueryInput($keys,$request);
    $input['attachment'] = $path;

    Task::create($input);

    return redirect()->intended('/tasks')
    ->with('success','Task deleted successfully');;
}


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {//
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

       $task = Employee::find($id);
        // Redirect to state list if updating state wasn't existed
       if ($task == null || count($task) == 0) {
        return redirect()->intended('/tasks');
    }

    $employees = Employee::all();

    return view('tasks/edit', ['task' => $task, 
        'employees' => $employees]);
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
        $task = Task::findOrFail($id);
        $valid=$this->validateInput($request);
        if(!$valid){
            return back()
            ->with('error', 'Invalid input');
        }
        // Upload image
        $keys = ['title','description','deadline','employee_id',];

        $input = $this->createQueryInput($keys, $request);
        if ($request->file('attachment')) {
            $path = $request->file('attachment')->store('avatars');
            $input['attachment'] = $path;
        }


        Task::where('id', $id)
        ->update($input);

        return redirect()->intended('/tasks')
        ->with('success','Task updated successfully');;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       Task::where('id', $id)->delete();
       return redirect()->intended('/tasks')
       ->with('success','Task deleted successfully');;
   }

   private function validateInput($request) {
    
    $this->validate($request, [
        'title' => 'required|max:60',
        'description' => 'required|max:120',
        'deadline' => 'required',
        'attachment' => 'required|file|image|mimes:jpeg,png,gif,webp|max:2048',
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

