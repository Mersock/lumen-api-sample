<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    public function createSuccessResponse($data,$code)
    {
        return response()->json(['data'=>$data,'code'=>$code], $code);
    }

    public function createErrorMessage($msg,$code)
    {
        return response()->json(['message'=>$msg,'code'=>$code], $code);
    }

    protected function buildFailedValidationResponse(Request $request, array $errors)
    {

            return $this->createSuccessResponse($errors, 422);

    }
}
