<?php

namespace Tests\Feature;

use App\Company;
use Illuminate\Http\Response;
use Tests\TestCase;

class CompanyListTest extends TestCase
{
    private const FACTORY_AMOUNT = 15;

    /**
     * @test
     */
    public function it_can_index_company_list()
    {
        $companies = factory(Company::class, self::FACTORY_AMOUNT)->create();

        $this
            ->getJson(route('company-list.index'))
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonCount($companies->count(), 'data');
    }
}
