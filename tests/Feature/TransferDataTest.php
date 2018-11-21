<?php

namespace Tests\Feature;

use App\Company;
use App\Customer;
use App\Http\Controllers\Api\TransferDataController;
use App\Jobs\ProcessTransferDataGeneration;
use App\Service\TransferDataService;
use App\Transfer;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Bus;
use Symfony\Component\Process\Process;
use Tests\TestCase;

class TransferDataTest extends TestCase
{
    private const COMPANIES_COUNT = 2;
    private const COMPANY_CUSTOMERS_COUNT = 2;

    /**
     * @test
     */
    public function it_can_update_transfer_data()
    {
        $this->seedCompanyCustomers();

        $this
            ->putJson(route('transfer-data.update'))
            ->assertStatus(Response::HTTP_OK);

        $expectedTransfersCount = Customer::count()
            * TransferDataService::HALF_YEAR_MONTHS
            * TransferDataController::CUSTOMER_TRANSFERS_PER_MONTH_COUNT;

        $this->assertEquals($expectedTransfersCount, Transfer::count());
    }

    /**
     * @test
     */
    public function it_can_dispatch_data_generation_job()
    {
        Bus::fake();

        $this->seedCompanyCustomers();

        $this
            ->putJson(route('transfer-data.update'))
            ->assertStatus(Response::HTTP_OK);

        Bus::assertDispatched(ProcessTransferDataGeneration::class);
    }

    private function seedCompanyCustomers()
    {
        factory(Company::class, self::COMPANIES_COUNT)->create()->each(function ($company) {
            $company->customers()->saveMany(factory(Customer::class, self::COMPANY_CUSTOMERS_COUNT)->make());
        });
    }
}
