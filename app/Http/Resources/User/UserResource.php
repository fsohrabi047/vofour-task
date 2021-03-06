<?php

namespace App\Http\Resources\User;

use App\Http\Resources\Task\TaskCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request 
     * 
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
            $this->mergeWhen(
                isset($this->tasks_count),
                ['tasks_count' => $this->tasks_count ?? 0]
            ),
            'tasks' => new TaskCollection($this->whenLoaded('tasks'))
        ];
    }

    /**
     * Undocumented function
     *
     * @param [type] $request 
     * @param [type] $response 
     * 
     * @return void
     */
    // public function withResponse($request, $response)
    // {
    //     if (is_null($this->resource)) {
    //         $request->status(404);
    //     }
    // }
}
