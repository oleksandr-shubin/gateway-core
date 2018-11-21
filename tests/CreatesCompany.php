<?php


namespace Tests;


use App\Company;
use App\Customer;
use App\Transfer;
use Illuminate\Support\Carbon;

trait CreatesCompany
{
    private static $minCustomersCount = 2;
    private static $maxCustomersCount = 3;
    private static $minCustomerTransfersCount = 1;
    private static $maxCustomerTransfersCount = 3;
    private static $abuserCompaniesCount = 1;
    
    private function createCompany(bool $abuser = false)
    {
        $customersCount = mt_rand(self::$minCustomersCount, self::$maxCustomersCount);
        $customerTransfersCount = mt_rand(self::$minCustomerTransfersCount, self::$maxCustomerTransfersCount);
        $companyTransfersCount = $customersCount * $customerTransfersCount;

        $company = factory(Company::class)->create();

        $customers = $company->customers()->saveMany(factory(Customer::class, $customersCount)->make());

        foreach($customers as $customer) {
            $customer->transfers()->saveMany(factory(Transfer::class, $customerTransfersCount)->make([
                'created_at' => Carbon::now(),
                'amount' => $abuser
                    ? $company->quota
                    : $this->findQuotaAbidingTransferAmount($company->quota, $companyTransfersCount),
                'company_id' => $customer->company_id,
            ]));
        }

        return $company;
    }

    private function findQuotaAbidingTransferAmount($quota, $transfersCount)
    {
        return intval($quota / $transfersCount);
    }
}