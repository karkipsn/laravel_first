<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;

class BaseController extends Controller
{
	public function sendResponse($result, $message){

		$response = [
			'success' => true,
			'data'    => $result,
			'message' => $message,
		];
		

		return response()->json($response);

	}


	public function sendError($error, $errorMessages = [], $code = 404){
		$response = [
			'error' => true,
			'message' => $error,
		];
		if(!empty($errorMessages)){
			$response['data'] = $errorMessages;
		}
		return response()->json($response, $code);
	}
}

