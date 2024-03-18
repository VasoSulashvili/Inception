<?php

declare(strict_types=1);

namespace App\Actions\Group;

use App\Enums\Rank\RankGroup;
use App\Events\Group\UpdateGroupData;
use App\Exceptions\UnfulfilledException;
use App\Http\Requests\Prize\StorePriceGroupRequest;
use App\Models\Prize;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class GenerateData
{
    /**
     * @param string|Group $group
     * @return mixed
     * @throws UnfulfilledException
     */
    public function handle(string|Group $group): mixed
    {
        return Cache::rememberForever(RankGroup::from($group->name)->value, function() use ($group) {

        });
    }
}
