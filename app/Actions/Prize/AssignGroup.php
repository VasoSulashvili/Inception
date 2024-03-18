<?php

declare(strict_types=1);

namespace App\Actions\Prize;

use App\Enums\Rank\RankGroup;
use App\Events\Group\UpdateGroupData;
use App\Exceptions\UnfulfilledException;
use App\Http\Requests\Prize\StorePriceGroupRequest;
use App\Models\Prize;
use App\Models\Group;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
        $groupData = RankGroup::from($group->name)->data();

        // Check
        if (!$prize?->id || !$group?->id) {
            throw new NotFoundHttpException();
        }

        // Assign group
        if (
            setting('prize-total-number')
            >= ($groupData['total_number'] + $request->input('number'))
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
        UpdateGroupData::dispatch($group->name);

        return $group;
    }
}
