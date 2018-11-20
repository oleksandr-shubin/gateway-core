<?php

namespace App\Http\Controllers\Api;

use App\Company;
use App\Http\Controllers\Controller;
use App\Http\Resources\AbuserCompanyCustomerCollection;
use App\Service\AbuserCustomerService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AbuserCustomerController extends Controller
{
    private $abuserCustomerService;

    public function __construct(AbuserCustomerService $abuserCustomerService)
    {
        $this->abuserCustomerService = $abuserCustomerService;
    }

    public function index(Company $company, Request $request)
    {
        $request->validate([
           'month' => ['required', 'integer', 'min:1', 'max:12'],
        ]);

        $month = intval($request->input('month'));

        if ($company->transfers()->ofMonth($month)->sum('amount') <= $company->quota) {
            return response()->json([
                'message' => [
                    'errors' => [
                        'company' => 'Invalid company',
                    ]
                ]
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $abuserCustomers = $this->abuserCustomerService->findAbuserCompanyCustomersByMonth($company, $month);

        return new AbuserCompanyCustomerCollection($abuserCustomers);
    }
}
