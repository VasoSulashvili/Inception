<?php

declare(strict_types=1);

namespace App\Actions\Prize;

use App\Exceptions\UnfulfilledException;
use Illuminate\Http\Request;
use App\Models\Prize;

class DeletePrize
{
    /**
     * @param Prize $prize
     * @return bool|null
     * @throws UnfulfilledException
     */
    public function handle(Prize $prize): bool|null
    {
        try {
            return $prize->delete();
        } catch (\Exception $e) {
            throw new UnfulfilledException();
        }
    }
}
