<?php

namespace Tests;

use App\Models\Company;
use App\Models\CompanyFund;
use App\Models\Fund;
use App\Models\FundManager;
use Faker\Factory as Faker;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected $faker;

    protected function setUp(): void
    {
        parent::setUp();
        $this->faker = Faker::create();
    }

    public function createCompany(): Company|Model
    {
        return Company::query()->create([
            'name' => $this->faker->name,
        ]);
    }

    public function createFundManager(): FundManager|Model
    {
        return FundManager::query()->create([
            'name' => $this->faker->name,
        ]);
    }

    public function createFund($managerId): Fund|Model
    {
        return Fund::query()->create([
            'name' => $this->faker->name,
            'start_year' => "2024",
            'manager_id' => $managerId,
            'aliases' => [$this->faker->name, $this->faker->name]
        ]);
    }

    public function createDuplicateFund($managerId, $name): Fund|Model
    {
        return Fund::query()->create([
            'name' => $name,
            'start_year' => "2024",
            'manager_id' => $managerId,
            'aliases' => [$this->faker->name, $this->faker->name]
        ]);
    }

    public function createCompanyFund($companyId, $fundId): CompanyFund|Model
    {
        return CompanyFund::query()->create([
            'company_id' => $companyId,
            'fund_id' => $fundId,
        ]);
    }

    public function createMockData(): void
    {
        $company = $this->createCompany();
        $fundManager = $this->createFundManager();
        $fund = $this->createFund($fundManager->id);
        $this->createCompanyFund($company->id, $fund->id);
    }
}
