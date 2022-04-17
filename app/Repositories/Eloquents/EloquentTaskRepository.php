<?php

namespace App\Repositories\Eloquents;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\Frontend\StoreTaskRequest;
use App\Http\Requests\Frontend\UpdateTaskRequest;
use App\Repositories\Interfaces\TaskRepositoryInterface;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Carbon;

class EloquentTaskRepository implements TaskRepositoryInterface
{
    /**
     * Get a filtered listing of the tasks resource.
     *
     * @param \Illuminate\Http\Request $request 
     * 
     * @return \Illuminate\Support\Collection
     */
    public function index(Request $request)
    {
        return Task::with('user')
            ->when(
                $request->input('title'),
                function ($query) use ($request) {
                    $query->where('title', 'like', "%{$request->input('title')}%");
                }
            )
            ->when(
                $request->input('description'),
                function ($query) use ($request) {
                    $query->where(
                        'description',
                        'like',
                        "%{$request->input('description')}%"
                    );
                }
            )
            ->when(
                $request->filled('from_due_date') || $request->input('to_due_date'),
                function ($query) use ($request) {
                    $from = $request->input('from_due_date')
                        ? date($request->input('from_due_date'))
                        : now()->subMonth(1)->format('Y-m-d');

                    $to = $request->input('to_due_date')
                        ? date($request->input('to_due_date')) 
                        : now()->addMonth(1)->format('Y-m-d');
                    
                    if ($from == $to) {
                        return $query->whereDate('due_date', $from);
                    }

                    return $query->whereBetween('due_date', [$from, $to]);
                }
            )
            ->when(
                $request->input('status'),
                function ($query) use ($request) {
                    $query->ofStatus($request->input('status'));
                }
            )
            ->when(
                $request->input('is_trashed') === 'true',
                function ($query) {
                    $query->withTrashed();
                }
            )
            ->paginate($request->input('per_page'));
    }

    /**
     * Find a task resource by id
     *
     * @param int   $id 
     * @param array $with To load task relationships
     * 
     * @return Task 
     */
    public function findById($id, array $with = null): Task
    {
        return Task::when(
            !is_null($with),
            function ($query) use ($with) {
                $query->with($with);
            }
        )
        ->find($id);
    }

    /**
     * Store a new task resource
     *
     * @param \Illuminate\Http\Request $request 
     * 
     * @return array Returned array must be [$user, $message, $statusCode]
     */
    public function store(Request $request): array
    {
        return DB::transaction(
            function () use ($request) {
                try {
                    $task = Task::create([
                        'title' => $request->input('title'),
                        'description' => $request->input('description'),
                        'due_date' => $request->input('due_date'),
                        'user_id' => $request->input('user_id', Auth::id()),
                        'status' => $request->input('status', 'todo')
                    ]);

                    $statusCode = Response::HTTP_CREATED;
                    $message = __('messages.tasks.store.success');
                } catch(\Throwable $th) {
                    $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
                    $message = __('messages.tasks.store.failed');
                    $task = null;
                    Log::error("Store task error: {$th->getMessage()}");
                }
                
                return [$task, $message, $statusCode];
            }
        );
    }

    /**
     * Update a task resource data
     *
     * @param \App\Model\Task $task
     * @param \Illuminate\Http\Request $request 
     * 
     * @return array Returned array must be [$user, $message, $statusCode]
     */
    public function update(Task $task, Request $request): array
    {
        return DB::transaction(
            function () use ($request, $task) {
                try {
                    $task->update([
                        'title' => $request->input('title'),
                        'description' => $request->input('description'),
                        'due_date' => $request->input('due_date'),
                        'status' => $request->input('status', 'todo')
                    ]);

                    $message = __('messages.tasks.update.success');
                    $statusCode = Response::HTTP_ACCEPTED;
                } catch (\Throwable $th) {
                    $message = __('messages.tasks.update.failed');
                    $task = null;
                    $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
                    Log::error("Update task error: {$th->getMessage()}");
                }

                return [$task, $message, $statusCode];
            }
        );
    }

    /**
     * Remove a Task resource
     *
     * @param \App\Models\Task $task 
     * 
     * @return array Return array must be [$message, $statusCode] 
     */
    public function destroy(Task $task)
    {
        try {
            $task->delete();
            $message = __('messages.tasks.destroy.success');
            $statusCode = Response::HTTP_OK;
        } catch (\Throwable $th) {
            $message = __('messages.tasks.destroy.failed');
            $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
            Log::error("Delete task error: {$th->getMessage()}");
        }

        return [$message, $statusCode];
    }

    /**
     * Get all authenticated user tasks
     *
     * @param \Illuminate\Http\Request $request 
     * 
     * @return \Illuminate\Support\Collection
     */
    public function getUserTasks(Request $request)
    {
        return Task::where('user_id', Auth::id())
            ->when(
                $request->filled('s'),
                function ($query) use ($request) {
                    $query->where(
                        function ($q) use ($request) {
                            $q->where('title', 'like', "%{$request->input('s')}%")
                                ->orWhere('description', 'like', "%{$request->input('s')}%");
                        }
                    );
                }
            )
            ->when(
                $request->filled('from_due_date') || $request->input('to_due_date'),
                function ($query) use ($request) {
                    $from = $request->input('from_due_date')
                        ? date($request->input('from_due_date'))
                        : now()->subMonth(1)->format('Y-m-d');

                    $to = $request->input('to_due_date')
                        ? date($request->input('to_due_date')) 
                        : now()->addMonth(1)->format('Y-m-d');
                    
                    if ($from == $to) {
                        return $query->whereDate('due_date', $from);
                    }

                    return $query->whereBetween('due_date', [$from, $to]);
                }
            )
            ->when(
                $request->input('status'),
                function ($query) use ($request) {
                    $query->ofStatus($request->input('status'));
                }
            )
            ->paginate($request->input('per_page'));
    }
}