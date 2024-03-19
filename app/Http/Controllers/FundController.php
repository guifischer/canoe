<?php

namespace App\Http\Controllers;

use App\Http\Requests\FundRequest;
use App\Http\Resources\FundResource;
use App\Models\Fund;
use App\Services\FundService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;

class FundController extends Controller
{
    public function create(FundRequest $request, FundService $service): Response
    {
        $service->create($request->validated());

        return response()->noContent(201);
    }

    public function list(Request $request, FundService $service): AnonymousResourceCollection
    {
        $funds = $service->getFunds($request);

        return FundResource::collection($funds);
    }

    public function update(FundRequest $request, FundService $service, Fund $fund): Response
    {
        $service->update($fund, $request->validated());

        return response()->noContent(200);
    }

    public function details(Request $request, FundService $fundService, Fund $fund): FundResource
    {
        return FundResource::make($fund);
    }

    public function getPotentialDuplicates(Request $request, FundService $service): AnonymousResourceCollection
    {
        $funds = $service->getPotentialDuplicatedFunds();

        return FundResource::collection($funds);
    }
}
