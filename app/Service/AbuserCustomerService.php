<?php


namespace App\Service;


use App\Company;
use Illuminate\Support\Facades\DB;

class AbuserCustomerService
{
    public function findAbuserCompanyCustomersByMonth(Company $company, int $month)
    {
        return DB::table('customers')
            ->join('transfers', function ($join) use ($month) {
                $join
                    ->on('customers.id', '=', 'transfers.customer_id')
                    ->whereMonth('transfers.created_at', $month);
            })
            ->select('customers.id', 'customers.given_name', 'customers.family_name', DB::raw('SUM(transfers.amount) as total_amount'))
            ->where('customers.company_id' ,'=', $company->id)
            ->groupBy('customers.id', 'customers.given_name','customers.family_name')
            ->orderBy('total_amount', 'desc')
            ->get();
    }
}