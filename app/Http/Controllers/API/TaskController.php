<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Task;
use Validator;

class TaskController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $tasks = Task::all();

       return $this->sendResponse($tasks->toArray(), 'Tasks retrieved successfully.');
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
           'title' => 'required|string|max:60',
           'description' => 'required|string|max:120',
           'deadline' => 'required|date',
           'attachment' => 'required|file|image|mimes:jpeg,png,gif,webp|max:2048',
           'employee_id' => 'required|exists:employees,id'
           
       ]);

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
     $task = Task::find($id);

     if (is_null($task)) {
        return $this->sendError('Task not found.');
    }

    return $this->sendResponse($task->toArray(), 'Task retrieved successfully.');
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
    public function update(Request $request, Task $task)
    {
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
        $task->attachment = $input['attachment'];
        $task->employee_id = $input['employee_id'];
        $task->save();

        return $this->sendResponse($task->toArray(), 'Task updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return $this->sendResponse($task->toArray(), 'Task deleted successfully.');
    }
}
