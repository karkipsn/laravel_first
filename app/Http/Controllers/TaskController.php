<?php


namespace App\Http\Controllers;

use App\Task;
use App\Employee;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use App\Http\Controllers\Controller as Controller;
use App\Http\Controllers\BaseController as BaseController;

class TaskController extends BaseController
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

     $input = $request->all();

     $type = $request->input('type');

     $validator = Validator::make($input, [
       'title' => 'required|string|max:60',
       'description' => 'required|string|max:120',
       'deadline' => 'required|date',
       'attachment' => 'required|file|image|mimes:jpeg,png,gif,webp|max:2048',
       'employee_id' => 'required|exists:employees,id'

   ]);
     $path = $request->file('attachment')->store('avatars');
     $input['attachment'] = $path;

     if($validator->fails()){

        if($type ==1){
           return redirect('/tasks')
           ->withErrors($validator)
           ->withInput();
       }

       if( $request->wantsJson()){
        return $this->sendError('Validation Error or Format Error.', $validator->errors());
    }   
}
$task = Task::create($input);
if($type ==1){

 return redirect('/tasks')
 ->with('success','Task created successfully.');
}
if($request->wantsJson()){
 return $this->sendResponse($task->toArray(), 'Task created successfully.');
}
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

    public function update(Request $request, Task $task)
    {
       try{
        $input = $request->all();
        $type = $request->input('type');

        $validator = Validator::make($input, [
            'title' => 'required|string|max:60',
            'description' => 'required|string|max:120',
            'deadline' => 'required|date',
            'attachment' => 'required|mimes:jpeg,PNG,gif,webp|max:2048',
            'employee_id' => 'required|exists:employees,id'
        ]);

        if($validator->fails()){

            if($type ==1){
               return redirect('/tasks')
               ->withErrors($validator)
               ->withInput();
           }

           if( $request->wantsJson()){
            return $this->sendError('Validation Error or Format Error.', $validator->errors());
        }   
    }

    $task->title = $input['title'];
    $task->description = $input['description'];
    $task->deadline = $input['deadline'];
    $task->employee_id = $input['employee_id'];

    if ($request->file('attachment')) {

      $path = $request->file('attachment')->store('avatars');
      $input['attachment'] = $path;
      $task->attachment = $input['attachment']; }

  $task->save();

  if($type ==1){

     return redirect('/task')
     ->with('success','Task created successfully.');
 }
 if($request->wantsJson()){
     return BaseController::sendResponse($task->toArray(), 'Task updated successfully.');
 }}
 catch (Exception $e) {
    if($type ==1){

       return redirect('/tasks')
       ->with('success','Task updated UnSuccessfull.');
   }
   if($request->wantsJson()){
      return $this->sendError('Task delete Unsuccessful.', $e->getMessage());  
  }
}
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
     $del =Task::where('id', $id)->delete();
     if($del == null){

        return redirect()->intended('/tasks')
        ->with('Error','Task deletion UnSuccessfull');;
    }


    return redirect()->intended('/tasks')
    ->with('success','Task deleted successfully');;
}

// private function validateInput($request) {

//     $this->validate($request, [
//         'title' => 'required|string|max:60',
//         'description' => 'required|string|max:120',
//         'deadline' => 'required|date',
//         'attachment' => 'required|file|image|mimes:jpeg,png,gif,webp|max:2048',
//         'employee_id' => 'required|integer'

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
}

