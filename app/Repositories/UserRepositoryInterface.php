<?php

namespace App\Repositories;

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
     * @param int $id 
     * 
     * @return App\Models\User
     */
    public function findById($id) : User;

    /**
     * Find a user resource by id and update it's properties
     *
     * @param int $id 
     * @param Request $request 
     * 
     * @return User
     */
    public function update($id, Request $request) : User;

    /**
     * Remove a user resource from storage.
     *
     * @param int $id 
     *  
     * @return void 
     */
    public function destroy($id);
}