<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskPolicy
{
    use HandlesAuthorization;

    /**
     * Perform pre-authorization checks.
     *
     * @param \App\Models\User $user 
     * @param string $ability 
     * 
     * @return void|bool
     */
    public function before(User $user, $ability)
    {
        if ($user->role == 'super-admin') {
            return true;
        }
    }
    
    /**
     * Determine whether the user can view any models.
     *
     * @param \App\Models\User $user 
     * 
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param \App\Models\User $user 
     * @param \App\Models\Task $task 
     * 
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Task $task)
    {
        if ($user->role == 'admin' || $task->user_id == $user->id) {
            return true;
        }
    }

    /**
     * Determine whether the user can create models.
     *
     * @param \App\Models\User $user 
     * 
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param \App\Models\User $user 
     * @param \App\Models\Task $task 
     * 
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Task $task)
    {
        if ($user->role == 'admin' || $task->user_id == $user->id) {
            return true;
        }
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param \App\Models\User $user 
     * @param \App\Models\Task $task 
     * 
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Task $task)
    {
        if ($user->role == 'admin' || $task->user_id == $user->id) {
            return true;
        }
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param \App\Models\User $user 
     * @param \App\Models\Task $task 
     * 
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Task $task)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param \App\Models\User $user 
     * @param \App\Models\Task $task 
     * 
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Task $task)
    {
        //
    }
}
