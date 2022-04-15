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
     * @param  LoginRequest $request
     * @return Illuminate\http\Response
     */
    public function login(LoginRequest $request)
    {
        if (Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')])) {
            $message = __('messages.login.successfully');

            $statusCode = Response::HTTP_OK;

            $token = $request->user()
                ->createToken(
                    $request->input('token_name', 'token')
                )
                ->plainTextToken;
                
        } else {
            $message = __('messages.login.error');
            $token = null;
            $statusCode = Response::HTTP_NOT_FOUND;
        }

        return response()->json(
            [
                'token' => $token,
                'message' => $message,
            ],
            $statusCode
        );
    }

    /**
     * Logout user and delete all tokens
     *
     * @param Request $request
     * @return void
     */
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(
            ['message' => 'خروج از حساب کاربری با موفقیت انجام شد!'],
            200
        );
    }
}
