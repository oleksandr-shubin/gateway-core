<?php

namespace Tests\Feature;

use App\Company;
use App\Customer;
use App\Transfer;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class ReportTest extends TestCase
{
    private const MIN_CUSTOMERS_COUNT = 2;
    private const MAX_CUSTOMERS_COUNT = 3;
    private const MIN_CUSTOMER_TRANSFERS_COUNT = 1;
    private const MAX_CUSTOMER_TRANSFERS_COUNT = 3;
    private const ABUSER_COMPANIES_COUNT = 1;

    /**
     * @test
     */
    public function it_can_index_monthly_report()
    {
        $currentMonth = Carbon::now()->month;

        $abuserCompany = $this->createCompany(true);
        $quotaAbidingCompany = $this->createCompany();

        $this->assertTrue($abuserCompany->transfers()->ofMonth($currentMonth)
                ->sum('amount') > $abuserCompany->quota);
        $this->assertTrue($quotaAbidingCompany->transfers()->ofMonth($currentMonth)
                ->sum('amount') <= $quotaAbidingCompany->quota);

        $this
            ->getJson(route('report.index', ['month' => $currentMonth]))
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonCount(self::ABUSER_COMPANIES_COUNT)
            ->assertJsonFragment(['id' => $abuserCompany->id]);
    }


    private function createCompany(bool $abuser = false)
    {
        $customersCount = mt_rand(self::MIN_CUSTOMERS_COUNT, self::MAX_CUSTOMERS_COUNT);
        $customerTransfersCount = mt_rand(self::MIN_CUSTOMER_TRANSFERS_COUNT, self::MAX_CUSTOMER_TRANSFERS_COUNT);
        $companyTransfersCount = $customersCount * $customerTransfersCount;

        $company = factory(Company::class)->create();

        $customers = $company->customers()->saveMany(factory(Customer::class, $customersCount)->make());

        foreach($customers as $customer) {
            $customer->transfers()->saveMany(factory(Transfer::class, $customerTransfersCount)->make([
                'created_at' => Carbon::now(),
                'amount' => $abuser
                    ? $company->quota
                    : $this->findQuotaAbidingTransferAmount($company->quota, $companyTransfersCount),
            ]));
        }

        return $company;
    }

    private function findQuotaAbidingTransferAmount($quota, $transfersCount)
    {
        return intval($quota / $transfersCount);
    }
}
