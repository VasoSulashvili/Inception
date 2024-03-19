<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LogResource extends JsonResource
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
            'actions' => $this->action,
            'player_id' => $this->player_id,
            'prize_id' => $this->prize_id,
            'player_data' => $this->player_data,
            'prize_data' => $this->prize_data,
            'won_at' => $this->won_at
        ];
    }
}
