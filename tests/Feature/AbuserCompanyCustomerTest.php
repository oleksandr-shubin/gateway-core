<?php

namespace Tests\Feature;

use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Tests\CreatesCompany;
use Tests\TestCase;

class AbuserCompanyCustomerTest extends TestCase
{
    use CreatesCompany;

    /**
     * @test
     */
    public function it_can_index_abuser_company_customers()
    {
        $currentMonth = Carbon::now()->month;

        $abuserCompany = $this->createCompany(true);

        $this->assertTrue($abuserCompany->transfers()->ofMonth($currentMonth)
                ->sum('amount') > $abuserCompany->quota);

        $this
            ->getJson(route('abuser-customer.index', [
                'company' => $abuserCompany,
                'month' => $currentMonth,
            ]))
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonCount($abuserCompany->customersActiveAtMonth($currentMonth)->count(), 'data')
            ->assertJsonFragment(['company' => $abuserCompany->name])
            ->assertJsonFragment(['month' => strval($currentMonth)]);
    }
}
