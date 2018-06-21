<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use App\Http\Controllers\API\BaseController as BaseController;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;

class RegisterController extends BaseController
{
    // protected $reportingService;
    // public function __construct(BaseController $reportingService) 
    // { 
    //     $this->reportingService = $reportingService; 
    // }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fname' => 'required',
            'lname' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);


        if($validator->fails()){
            return $this->sendError('Validation or Format Error.', $validator->errors());       
        }

        $input = $request->all();

        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyApp')->accessToken;
        $success['fname'] =  $user->fname;
        $success['lname'] =  $user->lname;
 
        return $this->sendResponse($success, 'User register successfully.');        
        
         //return BaseController::sendResponse($success, 'User register successfully.');
    }
}
