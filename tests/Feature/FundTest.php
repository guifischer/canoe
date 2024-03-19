<?php

namespace Tests\Feature;

use App\Events\DuplicateFundEvent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class FundTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_fund(): void
    {
        $fundManager = $this->createFundManager();
        $fundName = $this->faker->name;
        $fundStartYear = "2024";
        $fundAliases = [$this->faker->name, $this->faker->name];

        $response = $this->post('/api/funds', [
            'name' => $fundName,
            'start_year' => $fundStartYear,
            'manager_id' => $fundManager->id,
            'aliases' => $fundAliases
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('funds', [
            'name' => $fundName,
            'start_year' => $fundStartYear,
            'manager_id' => $fundManager->id,
            'aliases' => json_encode($fundAliases)
        ]);
    }

    public function test_list_funds(): void
    {
        $response = $this->get('/api/funds');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'start_year',
                    'manager_id',
                    'aliases'
                ],
            ],
        ]);
    }

    public function test_filtered_list_funds(): void
    {
        $fundManager = $this->createFundManager();
        $fund = $this->createFund($fundManager->id);
        $fund2 = $this->createFund($fundManager->id);

        $response = $this->get('/api/funds');
        $response->assertStatus(200);
        $response->assertJsonCount(2, 'data');

        $response = $this->get('/api/funds?name=' . $fund->name);
        $response->assertStatus(200);
        $response->assertJsonCount(1, 'data');
    }

    public function test_update_fund(): void
    {
        $fundManager = $this->createFundManager();
        $fund = $this->createFund($fundManager->id);
        $newName = $this->faker->name;
        $newStartYear = "2023";
        $newAliases = [$this->faker->name, $this->faker->name];

        $response = $this->putJson("/api/funds/{$fund->id}", [
            'name' => $newName,
            'start_year' => $newStartYear,
            'manager_id' => $fundManager->id,
            'aliases' => $newAliases
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('funds', [
            'id' => $fund->id,
            'name' => $newName,
            'start_year' => $newStartYear,
            'manager_id' => $fundManager->id,
            'aliases' => json_encode($newAliases)
        ]);
    }

    public function test_get_fund_details(): void
    {
        $fundManager = $this->createFundManager();
        $fund = $this->createFund($fundManager->id);

        $response = $this->get("/api/funds/{$fund->id}");

        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'id' => $fund->id,
                'name' => $fund->name,
                'start_year' => $fund->start_year,
                'manager_id' => $fund->manager_id,
                'aliases' => $fund->aliases
            ],
        ]);
    }

    public function test_get_potential_duplicates(): void
    {
        Event::fake([DuplicateFundEvent::class]);

        $fundManager = $this->createFundManager();
        $fund = $this->createFund($fundManager->id);
        $fund2 = $this->createDuplicateFund($fundManager->id, $fund->name);

        $response = $this->get('/api/funds/duplicates');

        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                [
                    'id' => $fund->id,
                    'name' => $fund->name,
                    'start_year' => $fund->start_year,
                    'manager_id' => $fund->manager_id,
                    'aliases' => $fund->aliases
                ],
                [
                    'id' => $fund2->id,
                    'name' => $fund2->name,
                    'start_year' => $fund2->start_year,
                    'manager_id' => $fund2->manager_id,
                    'aliases' => $fund2->aliases
                ]
            ]
        ]);

        Event::assertDispatched(DuplicateFundEvent::class);
    }
}
