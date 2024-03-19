<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyRequest;
use App\Http\Resources\CompanyResource;
use App\Models\Company;
use App\Services\CompanyService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class CompanyController extends Controller
{
    public function create(CompanyRequest $request, CompanyService $service): Response
    {
        $service->create($request->validated());

        return response()->noContent(201);
    }

    public function list(Request $request, CompanyService $service): AnonymousResourceCollection
    {
        $companies = $service->getCompanies();

        return CompanyResource::collection($companies);
    }

    public function details(Request $request, Company $company): CompanyResource
    {
        return CompanyResource::make($company);
    }

    public function update(CompanyRequest $request, CompanyService $service, Company $company): Response
    {
        $service->update($company, $request->validated());

        return response()->noContent(200);
    }
}
