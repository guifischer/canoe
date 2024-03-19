<?php

namespace App\Observers;

use App\Models\Fund;
use App\Services\FundService;

class FundObserver
{
    public function __construct(
        protected FundService $service,
    ) {}

    public function created(Fund $fund): void
    {
        $this->service->alertIfDuplicateFunds($fund);
    }
}
