<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\StoreTaskRequest;
use App\Http\Requests\Frontend\UpdateTaskRequest;
use App\Http\Resources\Task\TaskCollection;
use App\Http\Resources\Task\TaskResource;
use App\Models\Task;
use App\Repositories\Interfaces\TaskRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Task repository
     *
     * @var TaskRepositoryInterface
     */
    protected $taskRepo;

    /**
     * Instantiate user controller
     *
     * @param \App\Repositories\Interfaces\TaskRepositoryInterface $taskRepositoryInterface 
     */
    public function __construct(TaskRepositoryInterface $taskRepositoryInterface)
    {
        $this->taskRepo = $taskRepositoryInterface;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request $request 
     * 
     * @return \App\Http\Resources\Task\TaskCollection 
     */
    public function index(Request $request)
    {
        return new TaskCollection($this->taskRepo->getUserTasks($request));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Frontend\StoreTaskRequest $request 
     * 
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTaskRequest $request)
    {
        list($task, $message, $statusCode ) = $this->taskRepo->store($request);
        
        return ( new TaskResource($task) )
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
     * @return \App\Http\Resources\Task\TaskResource 
     */
    public function show($id)
    {
        $task = $this->taskRepo->findById($id, ['user']);

        $this->authorize('view', $task);

        return new TaskResource($task);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\Frontend\UpdateTaskRequest $request 
     * @param \App\Models\Task $task 
     * 
     * @return \App\Http\Resources\Task\TaskResource 
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        $this->authorize('update', $task);

        list(
            $task,
            $message,
            $statusCode
        ) = $this->taskRepo->update($task, $request);
        
        return ( new TaskResource($task) )
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
     * @param \App\Models\Task $task 
     * 
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);

        list($message, $statusCode) = $this->taskRepo->destroy($task);
        
        return response()
            ->json(
                [
                    'message' => $message
                ],
                $statusCode
            );
    }
}
