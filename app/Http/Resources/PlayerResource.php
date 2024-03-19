<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PlayerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=> $this->id,
            "rank_id" => $this->rank_id,
            "username" => $this->username,
            "first_name" => $this->first_name,
            "last_name" => $this->last_name,
            "gender" => $this->gender,
            "lang" => $this->lang,
            "balance" => $this->first_name,
            "email" => $this->balance,
            "is_blocked" => $this->active,
            "active" => $this->active,
            "deleted_at" => $this->deleted_at,
            "spinner_last_activity" => $this->spinner_last_activity,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            'included' => [
                'rank' => new RankResource($this->whenLoaded('rank')),
                'prizes' => PrizeResource::collection($this->whenLoaded('prizes'))
            ]
        ];
    }
}
