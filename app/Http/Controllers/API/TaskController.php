<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use App\Http\Controllers\BaseController as BaseController;
use App\Task;
use Validator;
use Illuminate\Support\Facades\DB;

class TaskController extends BaseController
{
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
     ->orderBy('employees.id','ASC')
     ->get();

     return $this->sendResponse($tasks, 'Tasks retrieved successfully.');
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
         'title' => 'required|string|max:60',
         'description' => 'required|string|max:120',
         'deadline' => 'required|date',
         'attachment' => 'required|file|image|mimes:jpeg,png,gif,webp|max:2048',
         'employee_id' => 'required|exists:employees,id'

     ]);
       $path = $request->file('attachment')->store('avatars');
       $input['attachment'] = $path;

       Task::create($input);

       if($validator->fails()){
        return $this->sendError('Validation Error or Invalid Json Format..', $validator->errors());       
    }
    $task = Task::create($input);
    return $this->sendResponse($task->toArray(), 'Task created successfully.');
}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       $task = DB::table('tasks')
       ->leftJoin('employees', 'tasks.employee_id', '=', 'employees.id')
       ->select ('tasks.*','employees.name as employee_name','employees.id as employee_id')
       ->where('employees.id', '=' ,$id)
       ->get();

       if (is_null($task)) {
        return $this->sendError('Task not found.');
    }

    return $this->sendResponse($task->toArray(), 'Task retrieved successfully.');
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
     try {

        $input = $request->all();

        $validator = Validator::make($input, [
            'title' => 'required|string|max:60',
            'description' => 'required|string|max:120',
            'deadline' => 'required|date',
            'attachment' => 'required|file|image|mimes:jpeg,png,gif,webp|max:2048',
            'employee_id' => 'required|exists:employees,id'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error or Invalid Json Format.', $validator->errors());       
        }
        $task->title = $input['title'];
        $task->description = $input['description'];
        $task->deadline = $input['deadline'];
    // $task->attachment = $input['attachment'];
        $task->employee_id = $input['employee_id'];
        
        if ($request->file('attachment')) {
          $path = $request->file('attachment')->store('avatars');
          $input['attachment'] = $path;
      }

      $task->save();


      return $this->sendResponse($task->toArray(), 'Task updated successfully.');
  } 
  catch (Exception $e) {
    return $this->sendError('Task Update Operation Failed',$e->getMessage());

}
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        try {
            $task->delete();

            return $this->sendResponse($task->toArray(), 'Task deleted successfully.');
            
        } catch (Exception $e) {
           return $this->sendError('Task Deletion Operation Failed',$e->getMessage());

       }

   }
}
