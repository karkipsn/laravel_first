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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    

public function add()
     {
         return view('users/add');//returns the create file from the view
     }

     public function getdata()
	{
     // return Datatables::of(User::query())->make(true);
		// $users=User::latest()->paginate(5);

		// return view('users/index',compact('users'))
  //        ->with('i', (request()->input('page', 1) - 1) * 5);

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

        $this->validateInput($request);

         User::create([
            'fname' => $request['fname'],
            'lname' => $request['lname'],
            'email' => $request['email'],
            'password' => bcrypt($request['password'])
            
        ]);

        return redirect()->intended('users')->with('success', 'User has been added');

     	
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
        $this->validateInput($request);

        $keys = ['password'];
        $input = $this->createQueryInput($keys, $request);
       
        User::where('id', $id)
            ->update($input);

        return redirect()->intended('/users');


     }
     public function destroy($id){
        User::where('id', $id)->delete();
         return redirect()->intended('/users');

     }

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
