<?php

declare(strict_types=1);

namespace App\Actions\Prize;

use App\Support\Facades\CacheService;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Http\Requests\Prize\StorePriceGroupRequest;
use App\Exceptions\UnfulfilledException;
use App\Models\Prize;
use App\Models\Group;

class AssignGroup
{
    /**
     * @param StorePriceGroupRequest $request
     * @return true
     * @throws UnfulfilledException
     */
    public function handle(StorePriceGroupRequest $request): mixed
    {
        // Retrieve records
        $group = Group::where('id', '=', $request->input('group_id'))->first();
        $prize = Prize::where('id', '=', $request->input('prize_id'))->first();

        // Check
        if (!$prize?->id || !$group?->id) {
            throw new NotFoundHttpException();
        }

        $groupData = CacheService::getGroupData($group->name);

        // Assign group
        if (
            setting('prize-total-number')
            >= ($groupData['prize_total_number'] + $request->input('number'))
        )
        {
            $prize->groups()->attach($group->id, [
                'number' => $request->input('number'),
                'amount' => $request->input('amount'),
            ]);
        } else {
            throw new UnfulfilledException('Too much prize number per group!');
        }

        // Update Group Cache Data
        CacheService::updateGroupData($group->name);

        return $group;
    }
}
