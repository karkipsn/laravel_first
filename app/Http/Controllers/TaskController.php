<?php


namespace App\Http\Controllers;

use App\Task;
use App\Employee;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request as Req;
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
      try{

       $tasks = DB::table('tasks')
       ->leftJoin('employees', 'tasks.employee_id', '=', 'employees.emp_id')
       ->select ('tasks.*','employees.name as employee_name','employees.emp_id as employee_id');


       if (\Request::is('api*')) {
        $tasks1= $task->get();

         return BaseController::sendResponse($tasks1->toArray(), 'Tasks retrieved successfully.');

       }else{
         $tasks2= $tasks->paginate(5);
        
        return view('tasks/index', ['tasks' => $tasks2]);      
      }

    }catch (Exception $e){

      if(\Request::is('api*')){

       return $this->sendError('Tasks retrival Unsuccessful.', $e->getMessage());  }
       else{
         return redirect('/tasks')
         ->with('Error','Tasks retrival UnSuccessfull.');
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
      try{

       $input = $request->all();

       $validator = Validator::make($input, [
         'title' => 'required|string|max:60',
         'description' => 'required|string|max:120',
         'deadline' => 'required|date',
         'attachment' => 'required|file|image|mimes:jpeg,png,gif,webp|max:2048',
         'employee_id' => 'required|exists:employees,emp_id'

       ]);

       if($validator->fails()){

        if(\Request::is('api*')){

         return BaseController::sendError('Validation or Data Format Error.', $validator->errors());
       } else{

         return redirect('/tasks')->withErrors($validator)
         ->withInput();
       }  
     }
      
      //avatars bhanne path ma rakhna lai yo garni
      // $path = $request->file('attachment')->store('images');
      //   $input['attachment'] = $path;

     $attachment = Req::file('attachment');

            $random = str_random(10);
            $destinationPath    = public_path().'/images/';
            $filename            = $random.'_'.$attachment->getClientOriginalName();

     list($width, $height) = getimagesize($attachment);

            $thumbnail_width = 350;
            $ratio = $width/$thumbnail_width;
            $thumbnail_height = $height/$ratio;

            // \Image::make($attachment->getRealPath())->resize($thumbnail_width, $thumbnail_height)->save(public_path().'/images/thumbnails/'.$filename);

            \Image::make($attachment->getRealPath())->resize($thumbnail_width, $thumbnail_height)->save(public_path().'/images/thumbnails/'.$filename);

            \Image::make($attachment->getRealPath())->resize(2*$thumbnail_width, 2*$thumbnail_height)->save(public_path().'/images/'.$filename);

         //ani file name lai db ma save garne
            $input['attachment']=$filename;
        

        // $image = $request->attachment;  // your base64 encoded
        // $image = str_replace('data:image/png;base64,', '', $image);
        // $image = str_replace(' ', '+', $image);
        // $imageName = str_random(10).'.'.'png';
        // \File::put(storage_path(). '/' . $imageName, base64_decode($image));

        $task = Task::create($input);

        if(\Request::is('api*')){

         return BaseController::sendResponse($task->toArray(), 'Task created successfully.');

       }else{

        return redirect('/tasks')
        ->with('success','Task created successfully.');
      } 
    }
    catch (Exception $e) {

      if(\Request::is('api*')){
        return $this->sendError('Task creation Unsuccessful.', $e->getMessage());  }

        else{

         return redirect('/tasks')
         ->with('Error','Task creation UnSuccessfull.');
       }
     }
   }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($emp_id)
    {
      $task = Task::find($emp_id);

      if (is_null($task)) {

       if(\Request::is('api*')){

         return $this->sendDelete('No task with such id exists .');
       }
       else{

         return redirect('/employees')
         ->with('Error','No such task with Id');
       }    
     }
     else{

      try {

       $task = DB::table('tasks')
       ->leftJoin('employees', 'tasks.employee_id', '=', 'employees.emp_id')
       ->select ('tasks.*','employees.name as employee_name','employees.emp_id as employee_id')
       ->where('employees.emp_id', '=', $emp_id)
       ->get();

       if(\Request::is('api*')){

         return $this->sendResponse($task->toArray(), 'Task retrieved successfully.');
       }else{

         return view('tasks.show',compact('task'));
       }    
     }        
     catch (Exception $e) {

      if(\Request::is('api*')){

        return $this->sendError('Task retrival Unsuccessful.', $e->getMessage());  }
        else{
         return redirect('/tasks')
         ->with('Error','Task retrival UnSuccessfull.');
       }
     }
   }

 }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($emp_id)
    {

     $task = Employee::find($emp_id);
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

      $id = Task::findOrFail($task);

      if (is_null($id)) {

       if(\Request::is('api*')){

         return $this->sendDelete('No task with such id exists .');
       }
       else{

         return redirect('/tasks')
         ->with('Error','No such task with Id');
       }    
     }
     else{

       try{
        $input = $request->all();

        $validator = Validator::make($input, [
          'title' => 'required|string|max:60',
          'description' => 'required|string|max:120',
          'deadline' => 'required|date',
          'attachment' => 'required|mimes:jpeg,PNG,gif,webp|max:2048',
          'employee_id' => 'required|exists:employees,emp_id'
        ]);

        if($validator->fails()){

          if(\Request::is('api*')){

           return BaseController::sendError('Validation or Data Format Error.', $validator->errors());
         } else{

           return redirect('/tasks')->withErrors($validator)
           ->withInput();
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

        if(\Request::is('api*')){
         return $this->sendResponse($task->toArray(), 'Task updated successfully.');

       }else{
         return redirect('/tasks')
         ->with('success',' Task updated successfully.');
       }}
       catch (Exception $e) {

         if(\Request::is('api*')){
          return $this->sendError('Task updation Unsuccessful.', $e->getMessage());  
        }else{
          return redirect('/tasks')
          ->with('success','Task update UnSuccessfull.');
        }
      }

    } }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $department= Employee::where('id', $id);
      $task = Task::find($id);

      if(is_null($task)){

       if(\Request::is('api*')){

        return $this->sendDelete('No task with such id exists .');
      }else{

       return redirect('/tasks')
       ->with('Error','No such tasks asssociated with this Id');
     }    
   }
   try{

     $task->delete();

     if(\Request::is('api*')){

       return $this->sendResponse($task, 'Task deletion successfully.'); 
     }else{

       return redirect('/tasks')
       ->with('success','Task deleted successfully');
     }

   }catch (Exception $e) {

    if(\Request::is('api*')){
      return $this->sendError('Task delete Unsuccessful.', $e->getMessage());  }else{

        return redirect('/tasks')
        ->with('Error','Task deleted UnSuccessfull');
      }
    }
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

