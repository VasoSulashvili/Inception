<?php

declare(strict_types=1);

namespace App\Actions\Prize;

use App\Exceptions\UnfulfilledException;
use App\Http\Requests\Prize\StorePrizeRequest;
use App\Models\Prize;
use Illuminate\Http\Request;

class StorePrize
{
    /**
     * @param StorePrizeRequest $request
     * @return mixed
     * @throws UnfulfilledException
     */
    public function handle(StorePrizeRequest $request)
    {
        try {
            return Prize::create([
                'name' => $request->input('name'),
                'type' => $request->input('type'),
                'active' => ($request->input('active') ? 1 : 0),
            ]);
        } catch (\Exception $e) {
            throw new UnfulfilledException();
        }
    }
}
