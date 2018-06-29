<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller as Controller;
use App\Http\Controllers\BaseController as BaseController;
use App\User;
use Validator;

class PassportController extends BaseController
{

        public function __construct(){
        $this->content = array();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();

        return $this->sendResponse(json_decode($users), 'Departments retrieved successfully.');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $validator = Validator::make($request->all(), [
        'fname' => 'required',
        'lname' => 'required',
        'email' => 'required|email',
        'password' => 'required',
        'c_password' => 'required|same:password',
    ]);


      if($validator->fails()){
        return $this->sendError('Validation Error or Format Error.', $validator->errors());       
    }

    $input = $request->all();

    $input['password'] = bcrypt($input['password']);
    $user = User::create($input);
    $success['fname'] =  $user->fname;
    $success['lname'] =  $user->lname;
    $success['email'] =  $user->email;

    return $this->sendResponse($success, 'User register successfully.');     
}


      public function login(){
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
        $user = Auth::user();
        $this->content['token'] =  $user->createToken('Pizza App')->accessToken;
        $status = 200;
    }
    else{
        $this->content['error'] = "Unauthorised";
         $status = 401;
    }
     return response()->json($this->content, $status);    
    }
    // public function login() {
    //     if(Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
    //         $user = Auth::user();
    //         $success['token'] = $user->createToken('MyApp')->accessToken;
    //         return response()->json(['success' => $success], $this->sucessStatus);
    //     }
    //     else {
    //         return response()->json(['error' => 'Unauthorised'], 401);
    //     }
    // }

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
    public function destroy(User $user)
    {
       $user->delete();

       return $this->sendResponse($user->toArray(), 'User deleted successfully.');
   }
    public function getDetails() {
         $user = Auth::user();
         return response()->json(['success' => $user], 200);
     }
}
