<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Group;
use App\Models\Player;
use App\Models\Rank;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class RankTest extends TestCase
{
    use RefreshDatabase;

    public function test_auth_admin_can_assign_rank_to_group(): void
    {
        $this->refreshTestDatabase();
        $admin = Admin::factory()->create();
        $group = Group::factory()->create();
        $rank = Rank::factory()->create();
        Sanctum::actingAs(
            $admin,
            ['role:admin']
        );
        $this->assertAuthenticatedAs($admin);
        $response = $this->post('api/admin/ranks/assign/group',[
            'rank_id' => $rank->id,
            'group_id' => $group->id
        ]);

        $this->assertDatabaseHas('ranks',[
            'id' => $rank->id,
            'group_id' => $group->id
        ]);

        $response->assertStatus(200);
    }

    public function test_auth_non_admin_can_not_assign_rank_to_group(): void
    {
        $this->refreshTestDatabase();
        $player = Player::factory()->create();
        $group = Group::factory()->create();
        $rank = Rank::factory()->create();
        Sanctum::actingAs(
            $player,
            ['role:player'],
        );
        $this->assertAuthenticatedAs($player);
        $response = $this->post('api/admin/ranks/assign/group',[
            'rank_id' => $rank->id,
            'group_id' => $group->id
        ]);
        $this->assertDatabaseMissing('ranks',[
            'id' => $rank->id,
            'group_id' => $group->id
        ]);

        $response->assertStatus(401);
    }

    public function test_guest_can_not_assign_rank_to_group(): void
    {
        $this->refreshTestDatabase();
        $group = Group::factory()->create();
        $rank = Rank::factory()->create();
        $this->assertGuest();
        $response = $this->post('api/admin/ranks/assign/group',[
            'rank_id' => $rank->id,
            'group_id' => $group->id
        ]);
        $this->assertDatabaseMissing('ranks',[
            'id' => $rank->id,
            'group_id' => $group->id
        ]);

        $response->assertStatus(401);
    }

    public function test_guest_can_not_see_ranks(): void
    {
        $this->refreshTestDatabase();
        $rank = Rank::factory(1)->create();
        $this->assertGuest();
        $response = $this->get('api/ranks');

        $response->assertStatus(401);
    }

    public function test_auth_user_can_see_ranks(): void
    {
        $this->refreshTestDatabase();
        $rank = Rank::factory(1)->create();

        // Player
        $player = Player::factory()->create();
        Sanctum::actingAs(
            $player,
            ['role:player'],
        );
        $this->assertAuthenticatedAs($player);
        $response = $this->get('api/ranks');
        $response->assertStatus(200);

        // Admin
        $admin = Admin::factory()->create();
        Sanctum::actingAs(
            $admin,
            ['role:admin'],
        );
        $this->assertAuthenticatedAs($admin);
        $response = $this->get('api/ranks');
        $response->assertStatus(200);
    }
}
