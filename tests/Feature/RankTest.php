<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Group;
use App\Models\Rank;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RankTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_group_can_be_assigned_to_rank(): void
    {
        $admin = Admin::factory()->create();
        $group = Group::factory()->create();
        $rank = Rank::factory()->create();
        $this->actingAs($admin);
        $this->assertAuthenticatedAs($admin);
        $response = $this->post('ranks/assign/group',[
            'rank_id' => $rank->id,
            'group_id' => $group->id
        ]);

        $response->assertStatus(200);
    }
}
