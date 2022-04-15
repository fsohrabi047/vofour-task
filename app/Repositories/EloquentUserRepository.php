<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class EloquentUserRepository implements UserRepositoryInterface
{
    /**
     * Get a filtered listing of the users resource.
     *
     * @param Request $request 
     * 
     * @return Collection
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
     * Undocumented function
     *
     * @param int   $id 
     * @param array $with To load user relationships
     * 
     * @return User 
     */
    public function findById($id, array $with = null): User
    {
        return User::when(
            !is_null($with),
            function ($query) use ($with) {
                $query->with($with);
            }
        )
        ->find('id');
    }

    /**
     * Undocumented function
     *
     * @param int $id 
     * @param Request $request 
     * 
     * @return User
     */
    public function update($id, Request $request): User
    {
        //
    }

    /**
     * Undocumented function
     *
     * @param int $id 
     * 
     * @return void
     */
    public function destroy($id)
    {
        
    }
}