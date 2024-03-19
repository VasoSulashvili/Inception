<?php

declare(strict_types=1);

namespace App\Actions\Rank;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\Exceptions\UnfulfilledException;
use Illuminate\Http\Request;
use App\Models\Group;
use App\Models\Rank;

class AssignGroup
{
    /**
     * @param Request $request
     * @return mixed
     * @throws UnfulfilledException
     */
    public function handle(Request $request)
    {
        try {
            // Retrieve records
            $rank = Rank::where('id', '=', $request->input('rank_id'))->first();
            $rankGroup = Group::where('id', '=', $request->input('group_id'))->first();

            // Check
            if(!$rank?->id || !$rankGroup?->id) {
                throw new NotFoundHttpException();
            }

            // Assign group
            $rank->update(['group_id' => $rankGroup->id]);

            return $rank->refresh();
        } catch (NotFoundHttpException $e) {
            throw new NotFoundHttpException();
        } catch (\Exception $e) {
            throw new UnfulfilledException($e->getMessage());
        }
    }
}
