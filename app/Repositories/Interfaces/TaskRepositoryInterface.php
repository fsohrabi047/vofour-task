<?php

namespace App\Repositories\Interfaces;


use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Models\Task;
use Illuminate\Pagination\Paginator;

interface TaskRepositoryInterface
{
    /**
     * Get all tasks
     *
     * @param \Illuminate\Http\Request $request 
     * 
     * @return \Illuminate\Support\Collection
     */
    public function index(Request $request);

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
     * @param Illuminate\Http\Request $request 
     * 
     * @return array Returned array must be [$task, $message, $statusCode] 
     */
    public function store(Request $request) : array;

    /**
     * Find a task resource by id and update it's properties
     *
     * @param \App\Models\Task  $task  
     * @param \Illuminate\Http\Request $request 
     * 
     * @return array Returned array must be [$task, $message, $statusCode] 
     */
    public function update(Task $task, Request $request) : array;

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