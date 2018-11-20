<?php

namespace Tests\Feature;

use App\Company;
use App\Customer;
use App\Transfer;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Tests\CreatesCompany;
use Tests\TestCase;

class AbuserCompanyTest extends TestCase
{
    use CreatesCompany;

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
            ->getJson(route('abuser-company.index', ['month' => $currentMonth]))
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonCount(static::$abuserCompaniesCount)
            ->assertJsonFragment(['id' => $abuserCompany->id]);
    }
}
