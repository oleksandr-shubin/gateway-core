<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Service\AbuserService;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    private $abuserService;

    public function __construct(AbuserService $abuserService)
    {
        $this->abuserService = $abuserService;
    }

    public function index(Request $request)
    {
        $request->validate([
           'month' => ['required', 'integer', 'min:1', 'max:12'],
        ]);

        $month = intval($request->input('month'));

        return $this->abuserService->findAbuserCompaniesByMonth($month);
    }
}
