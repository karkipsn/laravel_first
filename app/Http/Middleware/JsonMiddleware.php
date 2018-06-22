<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class JsonMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
         $format = $request->headers->set("Accept", "application/json");

        
    //   if ( !$format) {
              
    // //     //abort(403, 'Invalid Data format. Please enter Valid Json');
    // //        // return response(['Invalid Data Format. Please Enter Valid Json '], 200);
    //          $response = [
    //         'Json' => false,
    //         'message' => "Invalid Data Format. Please Enter Valid Json ",
    //     ];
    //         return response()->json($response,200);
            
     //}
       return $next($request);
  
}
}
//to make this class global go to kernel.php and assign it as global.s