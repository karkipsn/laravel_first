<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
//        * Create a new controller instance.
//      *
//      * @return void
//      */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index()
    // {
    //     return view('home');
    // }

     public function index()
	{
		$users=\App\User::all();
		return view('user_index',compact('users'));
	}
     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function create()
     {
         return view('user_create');//returns the create file from the view
     }


     public function store(Request $request)
     {
     	$user= new \App\User;       
     	$user->fname=$request->get('fname');
     	$user->lname=$request->get('lname');
     	$user->email=$request->get('email');
     	$user->password=$request->get('password');
     	$user->save();

     	return redirect('users')->with('success', 'User has been added');
     }


     public function edit($id){

     	$user = \App\User::find($id);
     	//return view('user_edit',compact('user','id'));
     	return view('user_edit');
     }


     public function update(Request $request, $id){

     	$user= \App\User::find($id);       
     	$user->password=$request->get('password');
     	$user->save();
     	return redirect('users');

     }
     public function show(){

     }
}
