<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Service\TransferDataService;

class TransferDataController extends Controller
{
    public const CUSTOMER_TRANSFERS_PER_MONTH_COUNT = 60;


    private $transferDataService;

    public function __construct(TransferDataService $transferDataService) {
        $this->transferDataService = $transferDataService;
    }

    public function update()
    {
        $this->transferDataService->generate(self::CUSTOMER_TRANSFERS_PER_MONTH_COUNT);
    }
}
