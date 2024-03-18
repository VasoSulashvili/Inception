<?php

declare(strict_types=1);

namespace App\Actions\Prize;

use App\Exceptions\UnfulfilledException;
use App\Http\Requests\Prize\UpdatePrizeRequest;
use App\Models\Prize;
use Illuminate\Http\Request;

class UpdatePrize
{
    /**
     * @param UpdatePrizeRequest $request
     * @param Prize $prize
     * @return Prize
     * @throws UnfulfilledException
     */
    public function handle(UpdatePrizeRequest $request, Prize $prize): mixed
    {
        try {
            $prize->update([
                'name' => $request->input('name'),
                'type' => $request->input('type'),
                'active' => ($request->input('active') ? 1 : 0),
            ]);

            return $prize->refresh();
        } catch (\Exception $e) {
            throw new UnfulfilledException();
        }
    }
}
