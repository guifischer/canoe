<?php

namespace App\Services;

use App\Models\FundManager;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

class FundManagerService
{

    public function create(array $data): Model|FundManager
    {
        return FundManager::query()
            ->create($data);
    }

    public function getFundManagers(): LengthAwarePaginator
    {
        return FundManager::query()
            ->paginate();
    }

    public function update(FundManager $fund_manager, array $data): Model|FundManager
    {
        $fund_manager->update($data);

        return $fund_manager;
    }
}
