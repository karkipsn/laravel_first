<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;

class BaseController extends Controller
{
	
  
  public function sendDelete($message){

		$response = [
			'success' => false,
			'data'    => null,
			'message' => $message,
		];
		

		return response()->json($response,200);
}

	public function sendResponse($result, $message){

		$response = [
			'success' => true,
			'message' => $message,
			'data'    => $result,
		];
		

		return response()->json($response);

	}


	public function sendError($error, $errorMessages = [], $code = 404){
		$response = [
			'success' => false,
			'message' => $error,
		];
		if(!empty($errorMessages)){
			$response['data'] = $errorMessages;
		}
		return response()->json($response, $code);
	}
}

