<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Service\AbuserCompanyService;
use Illuminate\Http\Request;

class AbuserCompanyController extends Controller
{
    private $abuserCompanyService;

    public function __construct(AbuserCompanyService $abuserCompanyService)
    {
        $this->abuserCompanyService = $abuserCompanyService;
    }

    public function index(Request $request)
    {
        $request->validate([
           'month' => ['required', 'integer', 'min:1', 'max:12'],
        ]);

        $month = intval($request->input('month'));

        return $this->abuserCompanyService->findAbuserCompaniesByMonth($month);
    }
}
