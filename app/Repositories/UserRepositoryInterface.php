<?php

namespace App\Repositories;

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
     * @param Request $request 
     * 
     * @return Illuminate\Support\Collection
     */
    public function index(Request $request) : Collection;

    /**
     * Find user resource by id
     * 
     * @param int   $id 
     * @param array $with Relationship to be eager load
     * 
     * @return App\Models\User
     */
    public function findById($id, array $with = null) : User;

    /**
     * Store newly user resource
     *
     * @param StoreUserRequest $request 
     * 
     * @return array Returned array must be [$user, $message, $statusCode] 
     */
    public function store(StoreUserRequest $request) : array;

    /**
     * Find a user resource by id and update it's properties
     *
     * @param User    $user 
     * @param Request $request 
     * 
     * @return array Returned array must be [$user, $message, $statusCode] 
     */
    public function update(User $user, UpdateUserRequest $request) : array;

    /**
     * Remove a user resource from storage.
     *
     * @param User $user 
     *  
     * @return array Return array must be [$message, $statusCode] 
     */
    public function destroy(User $user);
}