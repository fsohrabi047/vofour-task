<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Http\Resources\User\UserCollection;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * User repository
     *
     * @var UserRepositoryInterface
     */
    protected $userRepo;

    /**
     * Instantiate user controller
     *
     * @param \App\Repositories\Interfaces\UserRepositoryInterface $userRepositoryInterface 
     */
    public function __construct(UserRepositoryInterface $userRepositoryInterface)
    {
        $this->userRepo = $userRepositoryInterface;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request 
     * 
     * @return \Illuminate\Http\Response 
     */
    public function index(Request $request)
    {
        return new UserCollection($this->userRepo->index($request));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request 
     * 
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        list($user, $message, $statusCode ) = $this->userRepo->store($request);

        return ( new UserResource($user) )
            ->additional(
                [
                    'message' => $message
                ]
            )
            ->response()
            ->setStatusCode($statusCode);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id 
     * 
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new UserResource($this->userRepo->findById($id, ['tasks']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request 
     * @param User $user 
     * 
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        list(
            $user,
            $message,
            $statusCode
        ) = $this->userRepo->update($user, $request);

        return ( new UserResource($user) )
            ->additional(
                [
                    'message' => $message
                ]
            )
            ->response()
            ->setStatusCode($statusCode);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user 
     * 
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        list($message, $statusCode) = $this->userRepo->destroy($user);
        
        return response()
            ->json(
                [
                    'message' => $message
                ],
                $statusCode
            );
    }
}
