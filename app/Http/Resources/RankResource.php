<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RankResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'group_id' => $this->group_id,
            'rank' => $this->rank,
            'name' => $this->name,
            'active' => $this->active,
            'included' => [
                'player' => new PlayerResource($this->whenLoaded('player')),
                'group' => new GroupResource($this->whenLoaded('group')),
            ]
        ];
    }
}
