<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RegisterController extends Controller
{
    /**
     * Register newly user resource
     *
     * @param StoreUserRequest $request 
     * @param UserRepositoryInterface $userRepositoryInterface 
     * 
     * @return void
     */
    public function __invoke(StoreUserRequest $request, UserRepositoryInterface $userRepositoryInterface)
    {
        list($user, $message, $statusCode ) = $userRepositoryInterface->store($request);

        if ($statusCode == Response::HTTP_CREATED) {
            $message = __('messages.users.registered');
            $loginUrl = route('login');
        }

        return response()
            ->json(
                [
                    'message' => $message,
                    'login_url' => isset($loginUrl) ? $loginUrl : null
                ],
                $statusCode
            );
    }
}
