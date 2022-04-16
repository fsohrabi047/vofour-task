<?php

namespace App\Repositories\Interfaces;


use App\Http\Requests\Frontend\StoreTaskRequest;
use App\Http\Requests\Frontend\UpdateTaskRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Models\Task;

interface TaskRepositoryInterface
{
    /**
     * Get all tasks
     *
     * @param \Illuminate\Http\Request $request 
     * 
     * @return \Illuminate\Support\Collection
     */
    public function index(Request $request) : Collection;

    /**
     * Find task resource by id
     * 
     * @param int   $id 
     * @param array $with Relationship to be eager load
     * 
     * @return \App\Models\Task
     */
    public function findById($id, array $with = null) : Task;

    /**
     * Store newly task resource
     *
     * @param StoreTaskRequest $request 
     * 
     * @return array Returned array must be [$task, $message, $statusCode] 
     */
    public function store(StoreTaskRequest $request) : array;

    /**
     * Find a task resource by id and update it's properties
     *
     * @param \App\Models\Task  $task  
     * @param UpdateTaskRequest $request 
     * 
     * @return array Returned array must be [$task, $message, $statusCode] 
     */
    public function update(Task $task, UpdateTaskRequest $request) : array;

    /**
     * Remove a task resource from storage.
     *
     * @param \App\Models\Task $task 
     *  
     * @return array Return array must be [$message, $statusCode] 
     */
    public function destroy(Task $task);

    /**
     * Get authenticated user tasks
     *
     * @param \Illuminate\Http\Request $request 
     * 
     * @return \Illuminate\Support\Collection
     */
    public function getUserTasks(Request $request);
}