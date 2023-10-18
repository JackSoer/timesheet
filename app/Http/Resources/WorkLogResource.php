<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkLogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'date' => $this->date,
            'developerId' => $this->developer_id,
            'projectId' => $this->projectId,
            'rate' => $this->rate,
            'hrs' => $this->hrs,
            'total' => $this->total,
            'status' => $this->status,
            'developer' => new DeveloperResource($this->developer),
            'project' => new ProjectResource($this->project),
        ];
    }
}
