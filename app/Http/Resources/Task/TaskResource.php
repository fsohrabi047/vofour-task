<?php

namespace App\Http\Resources\Task;

use App\Http\Resources\User\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $data = [];

        if (!is_null($this->resource)) {
            $data = [
                'id' => $this->id,
                'title' => $this->title,
                'description' => $this->description,
                'status' => $this->status,
                'due_date' => $this->due_date,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
                'user' => new UserResource($this->whenLoaded('user')),
                $this->mergeWhen(
                    $request->user()->role == 'admin',
                    [
                        'deleted_at' => $this->deleted_at
                    ]
                )
            ];
        }
        
        return $data;
    }
}
