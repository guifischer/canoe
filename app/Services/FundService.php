<?php

namespace App\Services;

use App\Events\DuplicateFundEvent;
use App\Models\Fund;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FundService
{
    public function create(array $data): Model|Fund
    {
        return Fund::query()
            ->create($data);
    }


    // Could be better with a package - https://spatie.be/docs/laravel-query-builder/v5/features/filtering
    public function getFunds(Request $request): LengthAwarePaginator
    {
        $name = $request->get('name', '');
        $startYear = $request->get('start_year', null);
        $managerName = $request->get('manager', '');

        $query = Fund::query();

        if ($name) {
            $query->where('name', 'like', "%$name%");
        }

        if ($startYear) {
            $query->where('start_year', $startYear);
        }

        if ($managerName) {

            // Maybe use JOIN here? Could result in better performance
            $query->whereHas('manager', function (Builder $query) use ($managerName) {
                $query->where('name', 'like', "%$managerName%");
            });
        }

        return $query->paginate();
    }

    public function alertIfDuplicateFunds(Fund $fund): void
    {
        $duplicateFund = $this->checkIfDuplicateFundExists($fund);

        if ($duplicateFund) {
            event(DuplicateFundEvent::class);
        }
    }

    public function checkIfDuplicateFundExists(Fund $fund): bool
    {
        return Fund::query()
            ->whereNot('id', $fund->id)
            ->where('manager_id', $fund->manager_id)
            ->where(function ($query) use ($fund) {
                $query->where('name', $fund->name);

                foreach ($fund->aliases as $alias) {
                    $query->orWhereJsonContains('funds.aliases', $alias);
                }

                return $query;
            })->exists();
    }

    public function update(Fund $fund, mixed $validated): Fund
    {
        $fund->update($validated);

        return $fund;
    }

    public function getPotentialDuplicatedFunds(): LengthAwarePaginator
    {
        // Still need to check aliases
        return Fund::query()
            ->whereExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('funds as f2')
                    ->whereRaw('funds.manager_id = f2.manager_id')
                    ->where('funds.id', '!=', DB::raw('f2.id'));
            })->paginate();
    }
}
