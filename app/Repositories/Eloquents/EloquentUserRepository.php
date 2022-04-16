<?php

namespace App\Repositories\Eloquents;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Repositories\Interfaces\UserRepositoryInterface;

class EloquentUserRepository implements UserRepositoryInterface
{
    /**
     * Get a filtered listing of the users resource.
     *
     * @param \Illuminate\Http\Request $request 
     * 
     * @return \Illuminate\Support\Collection
     */
    public function index(Request $request): Collection
    {
        return User::with('tasks')
            ->when(
                $request->input('name'),
                function ($query) use ($request) {
                    $query->where('name', 'like', "%{$request->input('name')}%");
                }
            )
            ->when(
                $request->input('email'),
                function ($query) use ($request) {
                    $query->where('email', $request->input('email'));
                }
            )
            ->when(
                $request->input('role'),
                function ($query) use ($request) {
                    $query->ofRole($request->input('role'));
                }
            )
            ->get();
    }

    /**
     * Find a user resource by id
     *
     * @param int   $id 
     * @param array $with To load user relationships
     * 
     * @return \App\Models\User 
     */
    public function findById($id, array $with = null): User
    {
        return User::when(
            !is_null($with),
            function ($query) use ($with) {
                $query->with($with);
            }
        )
        ->find($id);
    }

    /**
     * Store a new user resource
     *
     * @param \App\Http\Requests\Admin\StoreUserRequest $request 
     * 
     * @return array Returned array must be [$user, $message, $statusCode]
     */
    public function store(StoreUserRequest $request): array
    {
        return DB::transaction(
            function () use ($request) {
                try {
                    $user = User::create([
                        'name' => $request->input('name'),
                        'email' => strtolower($request->input('email')),
                        'password' => bcrypt($request->input('password')),
                        'role' => $request->input('role')
                    ]);

                    $statusCode = Response::HTTP_CREATED;
                    $message = __('messages.users.store.success');
                } catch(\Throwable $th) {
                    $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
                    $message = __('messages.users.store.failed');
                    $user = null;
                    Log::error("Store user error: {$th->getMessage()}");
                }

                return [$user, $message, $statusCode];
            }
        );
    }

    /**
     * Update a user resource data
     *
     * @param \App\Models\User $user
     * @param App\Http\Requests\Admin\UpdateUserRequest $request 
     * 
     * @return array Returned array must be [$user, $message, $statusCode]
     */
    public function update(User $user, UpdateUserRequest $request): array
    {
        return DB::transaction(
            function () use ($request, $user) {
                try {
                    $userData = [
                        'name' => $request->input('name'),
                        'email' => strtolower($request->input('email')),
                        'role' => $request->input('role')
                    ];
        
                    if ($request->filled('password')) {
                        $userData['password'] = bcrypt($request->input('password'));
                    }
        
                    $user = $user->update($userData);
                    $message = __('messages.users.update.success');
                    $statusCode = Response::HTTP_ACCEPTED;
                } catch (\Throwable $th) {
                    $message = __('messages.users.update.failed');
                    $user = null;
                    $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
                    Log::error("Update user error: {$th->getMessage()}");
                }

                return [$user, $message, $statusCode];
            }
        );
    }

    /**
     * Remove a user resource
     *
     * @param \App\Models\User $user 
     * 
     * @return array Return array must be [$message, $statusCode] 
     */
    public function destroy(User $user)
    {
        try {
            $user->delete();
            $message = __('message.users.destroy.success');
            $statusCode = Response::HTTP_OK;
        } catch (\Throwable $th) {
            $message = __('message.users.destroy.failed');
            $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
            Log::error("Delete user error: {$th->getMessage()}");
        }

        return [$message, $statusCode];
    }
}