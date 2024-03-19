<?php

declare(strict_types=1);

namespace App\Actions\Log;

use App\Enums\LogType;
use App\Exceptions\UnfulfilledException;
use App\Models\Log;
use App\Models\Player;
use App\Models\Prize;

class StoreLog
{
    /**
     * @param LogType $action
     * @param int|Player $player
     * @param int|Prize $prize
     * @return mixed
     * @throws UnfulfilledException
     */
    public function handle(LogType $action, int|Player $player, int|Prize $prize)
    {
        try {
            if (!$prize instanceof Prize) {
                $prize = Prize::findOrFail($prize);
            }
            if (!$player instanceof Prize) {
                $player = Player::findOrFail($player);
            }
            return Log::create([
                'action' => $action->value,
                'player_id' => $player->id,
                'prize_id' => $prize->id,
                'player_data' => json_encode($player->toArray()),
                'prize_data' => json_encode($prize->toArray()),
                'won_at' => now()
            ]);
        } catch (\Exception $e) {
            throw new UnfulfilledException($e->getMessage());
        }
    }
}
