<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    /**
     * Handle login request
     * 
     * @param LoginRequest $request
     */
    public function login(LoginRequest $request)
    {
        $token = null;

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $message = __('messages.login.successfully');
            $statusCode = Response::HTTP_OK;

            $token = $request->user()->createToken($request->token_name);
        } else {
            $message = __('messages.login.error');
            $token = null;
            $statusCode = Response::HTTP_NOT_FOUND;
        }

        return response()->json(
            [
                'bearer_token' => $token,
                'message' => $message,
            ],
            $statusCode
        );
    }
}
