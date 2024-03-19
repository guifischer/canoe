<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FundManagerTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_fund_manager(): void
    {
        $fundManagerName = $this->faker->name;

        $response = $this->post('/api/fund-managers', [
            'name' => $fundManagerName,
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('fund_managers', [
            'name' => $fundManagerName,
        ]);
    }

    public function test_list_fund_managers(): void
    {
        $response = $this->get('/api/fund-managers');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                ],
            ],
        ]);
    }

    public function test_update_fund_manager(): void
    {
        $fundManager = $this->createFundManager();
        $newName = $this->faker->name;

        $response = $this->put("/api/fund-managers/{$fundManager->id}", [
            'name' => $newName,
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('fund_managers', [
            'id' => $fundManager->id,
            'name' => $newName,
        ]);
    }

    public function test_get_fund_manager_details(): void
    {
        $fundManager = $this->createFundManager();

        $response = $this->get("/api/fund-managers/{$fundManager->id}");

        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'id' => $fundManager->id,
                'name' => $fundManager->name,
            ],
        ]);
    }
}
