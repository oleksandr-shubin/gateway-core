<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\ProcessTransferDataGeneration;
use App\Service\TransferDataService;

class TransferDataController extends Controller
{
    public const CUSTOMER_TRANSFERS_PER_MONTH_COUNT = 60;


    public function update()
    {
        ProcessTransferDataGeneration::dispatch(self::CUSTOMER_TRANSFERS_PER_MONTH_COUNT);
    }
}
