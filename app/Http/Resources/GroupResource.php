<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GroupResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'active' => $this->active,
            'included' => [
                'rank' => new RankResource($this->whenLoaded('rank')),
                'prizes' => PrizeResource::collection($this->whenLoaded('prizes'))
            ]
        ];
    }
}
