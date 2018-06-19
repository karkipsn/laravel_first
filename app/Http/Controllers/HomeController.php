<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Support\Facades\DB;
use DataTables;
use Illuminate\Http\Request;

class HomeController extends Controller
{
//        * Create a new controller instance.
//      *
//      * @return void
//      */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    

    public function add()
    {
         return view('users/add');//returns the create file from the view
     }

     public function getdata()
     {

         $users= User::all();
         return \DataTables::of($users)
         ->addColumn('action', function ($user) {
            return '<a href="/users/'.$user->id.'/edit" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
        })
         ->editColumn('id', 'ID: {{$id}}')
         ->removeColumn('password')
         ->make(true);
         

     }
     public function index()
     {
        
        $users=User::latest()->paginate(5);

        return view('users/index',compact('users'))
        ->with('i', (request()->input('page', 1) - 1) * 5);

        

    }
     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function create()
     {
         return view('users/create');//returns the create file from the view
     }


     public function store(Request $request)
     {

      $valid= $this->validateInput($request);
      if(!$valid){
        return back()
        ->with('error', 'Invalid input');
    }

    User::create([
        'fname' => $request['fname'],
        'lname' => $request['lname'],
        'email' => $request['email'],
        'password' => Hash::make($request['password'])
        
    ]);

    return redirect()->intended('users')
    ->with('success', 'You are logged in!');

    
}


public function edit($id){

  $user = User::find($id);
        // Redirect to state list if updating state wasn't existed
  if ($user == null || count($user) == 0) {
    return redirect()->intended('/users');
}
     	//return view('user_edit',compact('user','id'));
return view('users/edit',['user'=>$user]);

}


public function update(Request $request, $id){


    $user= User::findOrFail($id);
    $valid= $this->validateInput($request);
    if(!$valid){
        return back()
        ->with('error', 'Invalid input');
    }

    $keys = ['password'];
    $input = $this->createQueryInput($keys, $request);
    
    User::where('id', $id)
    ->update($input);

    return redirect()->intended('/users')
    ->with('success', 'User have been updated Successfully');


}
public function destroy($id){

   $province= User::where('id', $id)->first();

   if($province != null){
    $province->delete();
    

}
return redirect()->intended('/users')
->with('success','User has been deleted Successfully');}

public function show(){

}
private function validateInput($request) {
    $this->validate($request, [
        'fname' => 'required|max:60',
        'lname' => 'required|max:120',
        'email' => 'required|email|max:255|unique:users',
        'password' => 'required|min:6|confirmed',

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
z