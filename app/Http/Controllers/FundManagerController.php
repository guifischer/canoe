<?php

namespace App\Http\Controllers;

use App\Http\Requests\FundManagerRequest;
use App\Http\Resources\FundManagerResource;
use App\Models\FundManager;
use App\Services\FundManagerService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class FundManagerController extends Controller
{
    public function create(FundManagerRequest $request, FundManagerService $service): Response
    {
        $service->create($request->validated());

        return response()->noContent(201);
    }

    public function list(Request $request, FundManagerService $service): AnonymousResourceCollection
    {
        $managers = $service->getFundManagers();

        return FundManagerResource::collection($managers);
    }

    public function details(Request $request, FundManager $fund_manager): FundManagerResource
    {
        return FundManagerResource::make($fund_manager);
    }

    public function update(FundManagerRequest $request, FundManagerService $service, FundManager $fund_manager): Response
    {
        $service->update($fund_manager, $request->validated());

        return response()->noContent(200);
    }
}
