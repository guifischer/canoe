<?php

namespace App\Services;

use App\Models\Company;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

class CompanyService
{

    public function create(array $data): Model|Company
    {
        return Company::query()
            ->create($data);
    }

    public function getCompanies(): LengthAwarePaginator
    {
        return Company::query()
            ->paginate();
    }

    public function update(Company $company, array $data): Company
    {
        $company->update($data);

        return $company;
    }
}
