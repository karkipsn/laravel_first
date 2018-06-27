<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\User;
use Validator;

class AuthController extends Controller
{

     public $sucessStatus = 200;
    
     public function login()

    {
       
     if(Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = Auth::user();
            $success['token'] = $user->createToken('MyApp')->accessToken;
            return response()->json(['success' => $success], $this->sucessStatus);
        }
        else {
            return response()->json(['error' => 'Unauthorised'], 401);
        }}


        
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
        // $success['token'] =  $user->api_token;
        $success['fname'] =  $user->fname;
        $success['lname'] =  $user->lname;
 
        return $this->sendResponse($success, 'User register successfully.');        
        
         //return BaseController::sendResponse($success, 'User register successfully.');
    }


    //  public function logout(Request $request)
    // {
        
    //     $value = $request->bearerToken();
    //     $id= (new Parser())->parse($value)->getHeader('jti');

    //     $token=  DB::table('oauth_access_tokens')
    //         ->where('id', '=', $id)
    //         ->update(['revoked' => true]);

    //     $this->guard()->logout();

    //     $request->session()->flush();

    //     $request->session()->regenerate();

    //     $json = [
    //         'success' => true,
    //         'code' => 200,
    //         'message' => 'You are Logged out.',
    //     ];
    //     return response()->json($json, '200');

    //     // return response()->json([
    //     //     'message' => 'Successfully logged out'
    //     // ]);
    // }
}
