<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Group;
use App\Models\Player;
use App\Models\Prize;
use Database\Seeders\SettingSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class PrizeTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_store_update_and_delete_prize()
    {
        $this->refreshTestDatabase();
        $admin = Admin::factory()->create();
        Sanctum::actingAs(
            $admin,
            ['role:admin']
        );
        $this->assertAuthenticatedAs($admin);

        // Store
        $prize = Prize::factory()->make();
        $response = $this->post('api/admin/prizes', [
            'name' => $prize->name,
            'type' => $prize->type,
        ]);
        $response->assertStatus(201);
        $this->assertDatabaseHas('prizes',[
            'name' => $prize->name,
            'type' => $prize->type,
        ]);

        // Update
        $prize = Prize::where('name', '=', $prize->name)->first();
        $prize1 = Prize::factory()->make();
        $response = $this->put('api/admin/prizes/' . $prize->id, [
            'name' => $prize1->name,
            'type' => $prize1->type,
        ]);
        $response->assertStatus(200);
        $this->assertDatabaseHas('prizes',[
            'name' => $prize1->name,
            'type' => $prize1->type,
        ]);
        $this->assertDatabaseMissing('prizes',[
            'name' => $prize->name,
            'type' => $prize->type,
        ]);

        // Delete
        $response = $this->delete('api/admin/prizes/' . $prize->id);
        $this->assertDatabaseMissing('prizes',[
            'name' => $prize1->name,
            'type' => $prize1->type,
        ]);
        $response->assertStatus(204);
    }
    public function test_non_admin_can_not_store_update_and_delete_prize()
    {
        $this->refreshTestDatabase();
        $player = Player::factory()->create();
        Sanctum::actingAs(
            $player,
            ['role:player']
        );
        $this->assertAuthenticatedAs($player);

        // Store
        $prize = Prize::factory()->make();
        $response = $this->post('api/admin/prizes', [
            'name' => $prize->name,
            'type' => $prize->type,
        ]);
        $response->assertStatus(401);
        $this->assertDatabaseMissing('prizes',[
            'name' => $prize->name,
            'type' => $prize->type,
        ]);

        // Update
        $prize = Prize::factory()->create();


        $prize1 = Prize::factory()->make();
        $response = $this->put('api/admin/prizes/' . $prize->id, [
            'name' => $prize1->name,
            'type' => $prize1->type,
        ]);
        $response->assertStatus(401);
        $this->assertDatabaseMissing('prizes',[
            'name' => $prize1->name,
            'type' => $prize1->type,
        ]);

        // Delete
        $response = $this->delete('api/admin/prizes/' . $prize->id);
        $this->assertDatabaseHas('prizes',[
            'name' => $prize->name,
            'type' => $prize->type,
        ]);
        $response->assertStatus(401);
    }
    public function test_guest_can_not_store_update_and_delete_prize()
    {
        $this->refreshTestDatabase();
        $this->assertGuest();

        // Store
        $prize = Prize::factory()->make();
        $response = $this->post('api/admin/prizes', [
            'name' => $prize->name,
            'type' => $prize->type,
        ]);
        $response->assertStatus(401);
        $this->assertDatabaseMissing('prizes',[
            'name' => $prize->name,
            'type' => $prize->type,
        ]);

        // Update
        $prize = Prize::factory()->create();


        $prize1 = Prize::factory()->make();
        $response = $this->put('api/admin/prizes/' . $prize->id, [
            'name' => $prize1->name,
            'type' => $prize1->type,
        ]);
        $response->assertStatus(401);
        $this->assertDatabaseMissing('prizes',[
            'name' => $prize1->name,
            'type' => $prize1->type,
        ]);

        // Delete
        $response = $this->delete('api/admin/prizes/' . $prize->id);
        $this->assertDatabaseHas('prizes',[
            'name' => $prize->name,
            'type' => $prize->type,
        ]);
        $response->assertStatus(401);
    }
    public function test_admin_can_assign_prize_to_group()
    {
        $this->refreshTestDatabase();
        $this->seed(SettingSeeder::class);
        $admin = Admin::factory()->create();
        Sanctum::actingAs(
            $admin,
            ['role:admin']
        );
        $this->assertAuthenticatedAs($admin);

        $group = Group::factory()->create();
        $prize = Prize::factory()->create();
        $number = fake()->numberBetween(1, 1000000);
        $amount = fake()->randomFloat(4, 1, 8);

        $response = $this->post('api/admin/prizes/assign/group', [
            'prize_id' => $prize->id,
            'group_id' => $group->id,
            'amount' => $amount,
            'number' => $number
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('group_prize', [
            'prize_id' => $prize->id,
            'group_id' => $group->id,
            'amount' => $amount,
            'number' => $number
        ]);
    }
    public function test_non_admin_can_not_assign_prize_to_group()
    {
        $this->refreshTestDatabase();
        $this->seed(SettingSeeder::class);
        $player = Player::factory()->create();
        Sanctum::actingAs(
            $player,
            ['role:player']
        );
        $this->assertAuthenticatedAs($player);

        $group = Group::factory()->create();
        $prize = Prize::factory()->create();
        $number = fake()->numberBetween(1, 1000000);
        $amount = fake()->randomFloat(4, 1, 8);

        $response = $this->post('api/admin/prizes/assign/group', [
            'prize_id' => $prize->id,
            'group_id' => $group->id,
            'amount' => $amount,
            'number' => $number
        ]);

        $response->assertStatus(401);
        $this->assertDatabaseMissing('group_prize', [
            'prize_id' => $prize->id,
            'group_id' => $group->id,
            'amount' => $amount,
            'number' => $number
        ]);
    }
    public function test_guest_can_not_assign_prize_to_group()
    {
        $this->refreshTestDatabase();
        $this->seed(SettingSeeder::class);
        $this->assertGuest();

        $group = Group::factory()->create();
        $prize = Prize::factory()->create();
        $number = fake()->numberBetween(1, 1000000);
        $amount = fake()->randomFloat(4, 1, 8);

        $response = $this->post('api/admin/prizes/assign/group', [
            'prize_id' => $prize->id,
            'group_id' => $group->id,
            'amount' => $amount,
            'number' => $number
        ]);

        $response->assertStatus(401);
        $this->assertDatabaseMissing('group_prize', [
            'prize_id' => $prize->id,
            'group_id' => $group->id,
            'amount' => $amount,
            'number' => $number
        ]);
    }
}
