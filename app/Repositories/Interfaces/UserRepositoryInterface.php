<?php

namespace App\Repositories\Interfaces;

use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;


interface UserRepositoryInterface
{
    /**
     * Get all users
     *
     * @param \Illuminate\Http\Request $request 
     * 
     * @return \Illuminate\Support\Collection
     */
    public function index(Request $request) : Collection;

    /**
     * Find user resource by id
     * 
     * @param int   $id 
     * @param array $with Relationship to be eager load
     * 
     * @return \App\Models\User
     */
    public function findById($id, array $with = null) : User;

    /**
     * Store newly user resource
     *
     * @param \App\Http\Requests\Admin\StoreUserRequest $request 
     * 
     * @return array Returned array must be [$user, $message, $statusCode] 
     */
    public function store(StoreUserRequest $request) : array;

    /**
     * Find a user resource by id and update it's properties
     *
     * @param \App\Models\User $user 
     * @param \App\Http\Requests\Admin\UpdateUserRequest $request 
     * 
     * @return array Returned array must be [$user, $message, $statusCode] 
     */
    public function update(User $user, UpdateUserRequest $request) : array;

    /**
     * Remove a user resource from storage.
     *
     * @param \App\Models\User $user 
     *  
     * @return array Return array must be [$message, $statusCode] 
     */
    public function destroy(User $user);
}