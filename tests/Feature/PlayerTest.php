<?php

namespace Tests\Feature;

use App\Enums\LogType;
use App\Models\Player;
use App\Models\Prize;
use Database\Seeders\SettingSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class PlayerTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_trigger_spinner(){
        $this->refreshTestDatabase();
        $this->seed(SettingSeeder::class);
        $player = Player::factory()->create();
        Sanctum::actingAs(
            $player,
            ['role:player']
        );
        $this->assertAuthenticatedAs($player);

        $prize = Prize::factory()->create();
        $number = fake()->numberBetween(1, 1000000);
        $amount = fake()->randomFloat(4, 1, 8);

        DB::table('group_prize')->insert([
            'group_id' => $player->rank->group_id,
            'prize_id' => $prize->id,
            'amount' => $amount,
            'number' => $number
        ]);
        $this->assertDatabaseHas('group_prize',[
            'group_id' => $player->rank->group_id,
            'prize_id' => $prize->id,
            'amount' => $amount,
            'number' => $number
        ]);

        $response = $this->post('api/spinner/trigger');

        $response->assertStatus(200);

        // Test database has a record about player prize win
        $this->assertDatabaseHas('player_prize', [
            'prize_id' => $prize->id,
            'player_id' => $player->id,
        ]);
        $this->assertDatabaseCount('player_prize', 1);

        // Test log
        $this->assertDatabaseHas('logs', [
            'prize_id' => $prize->id,
            'player_id' => $player->id,
            'action' => LogType::PRIZE_WINNING->value
        ]);


        // Test player received prize amount
        $this->assertDatabaseHas('players', [
            'id' => $player->id,
            'balance' => $amount
        ]);

        ///////////////////////////////////////////////////////////
        // test player can not win a prize until time pass
        $response = $this->post('api/spinner/trigger');
        $response->assertStatus(403);

        // Test database has a record about player prize win
        $this->assertDatabaseCount('player_prize', 1);

        // Test player not received prize amount
        $this->assertDatabaseHas('players', [
            'id' => $player->id,
            'balance' => $amount
        ]);

    }
}
