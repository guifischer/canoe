<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CompanyTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_company(): void
    {
        $companyName = $this->faker->name;

        $response = $this->post('/api/companies', [
            'name' => $companyName,
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('companies', [
            'name' => $companyName,
        ]);
    }

    public function test_list_companies(): void
    {
        $response = $this->get('/api/companies');
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

    public function test_update_company(): void
    {
        $company = $this->createCompany();
        $newName = $this->faker->name;

        $response = $this->put("/api/companies/{$company->id}", [
            'name' => $newName,
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('companies', [
            'id' => $company->id,
            'name' => $newName,
        ]);
    }

    public function test_get_company_details(): void
    {
        $company = $this->createCompany();

        $response = $this->get("/api/companies/{$company->id}");

        $response->assertStatus(200);
        $response->assertJson(
            ['data' => [
                'id' => $company->id,
                'name' => $company->name,
            ]]
        );
    }
}
