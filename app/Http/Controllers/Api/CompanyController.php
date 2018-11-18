<?php

namespace App\Http\Controllers\Api;

use App\Company;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCompany;
use App\Http\Requests\UpdateCompany;
use App\Http\Resources\Company as CompanyResource;
use Illuminate\Http\Response;

class CompanyController extends Controller
{
    public const PER_PAGE = 10;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return CompanyResource::collection(Company::paginate(self::PER_PAGE));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCompany $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCompany $request)
    {
        $company = Company::create($request->all());
        return response()->json(new CompanyResource($company), Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Company $company
     * @return CompanyResource
     */
    public function show(Company $company)
    {
        return new CompanyResource($company);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCompany $request
     * @param  \App\Company $company
     * @return CompanyResource
     */
    public function update(UpdateCompany $request, Company $company)
    {
        $company->update($request->all());
        return new CompanyResource($company);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Company $company
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Company $company)
    {
        $company->delete();
        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
