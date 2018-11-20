<?php


namespace App\Service;


use Illuminate\Support\Facades\DB;

class AbuserCompanyService
{
    public function findAbuserCompaniesByMonth(int $month)
    {
        return DB::table('companies')
            ->join('customers', 'companies.id', '=', 'customers.company_id')
            ->join('transfers', function ($join) use ($month) {
                $join
                    ->on('customers.id', '=', 'transfers.customer_id')
                    ->whereMonth('transfers.created_at', $month);
            })
            ->select('companies.id', 'companies.name', 'companies.quota', DB::raw('SUM(transfers.amount) as total_amount'))
            ->groupBy('companies.id', 'companies.name', 'companies.quota')
            ->havingRaw('total_amount > companies.quota')
            ->orderBy('total_amount', 'desc')
            ->get();
    }
}