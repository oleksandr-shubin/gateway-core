<?php

namespace Tests\Feature;

use App\Company;
use App\Http\Controllers\Api\CompanyController;
use Illuminate\Http\Response;
use Tests\TestCase;

class CompanyTest extends TestCase
{
    private const TABLE = 'companies';
    private const FACTORY_AMOUNT = 15;

    /**
     * @test
     */
    public function it_can_index_companies()
    {
        $this->assertTrue(self::FACTORY_AMOUNT > CompanyController::PER_PAGE);

        factory(Company::class, self::FACTORY_AMOUNT)->create();

        $this
            ->getJson(route('company.index'))
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonCount(CompanyController::PER_PAGE, 'data');
    }

    /**
     * @test
     */
    public function it_can_store_company()
    {
        $companyData = factory(Company::class)->make()->toArray();

        $this
            ->postJson(route('company.store'), $companyData)
            ->assertStatus(Response::HTTP_CREATED)
            ->assertJsonFragment($companyData);

        $this->assertDatabaseHas(self::TABLE, $companyData);
    }

    /**
     * @test
     */
    public function it_can_show_company()
    {
        $company = factory(Company::class)->create();

        $this
            ->getJson(route('company.show', $company))
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonFragment($company->toArray());
    }

    /**
     * @test
     */
    public function it_can_update_company()
    {
        $company = factory(Company::class)->create();

        $company->fill(factory(Company::class)->make()->toArray());

        $this
            ->putJson(route('company.update', $company), $company->toArray())
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonFragment($company->toArray());

        $this->assertDatabaseHas(self::TABLE, $company->toArray());
    }

    /**
     * @test
     */
    public function it_can_destroy_company()
    {
        $company = factory(Company::class)->create();

        $this
            ->deleteJson(route('company.destroy', $company))
            ->assertStatus(Response::HTTP_NO_CONTENT);
    }
}
