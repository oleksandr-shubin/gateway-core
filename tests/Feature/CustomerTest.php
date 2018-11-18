<?php

namespace Tests\Feature;

use App\Customer;
use App\Http\Controllers\Api\CustomerController;
use Illuminate\Http\Response;
use Tests\TestCase;

class CustomerTest extends TestCase
{
    private const TABLE = 'customers';
    private const FACTORY_AMOUNT = 15;

    /**
     * @test
     */
    public function it_can_index_customers()
    {
        $this->assertTrue(self::FACTORY_AMOUNT > CustomerController::PER_PAGE);

        factory(Customer::class, self::FACTORY_AMOUNT)
            ->states('with_company')
            ->create();

        $this
            ->getJson(route('customer.index'))
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonCount(CustomerController::PER_PAGE, 'data');
    }

    /**
     * @test
     */
    public function it_can_store_customer()
    {
        $customerData = factory(Customer::class)
            ->states('with_company')
            ->make()
            ->toArray();

        $this
            ->postJson(route('customer.store'), $customerData)
            ->assertStatus(Response::HTTP_CREATED)
            ->assertJsonFragment($customerData);

        $this->assertDatabaseHas(self::TABLE, $customerData);
    }

    /**
     * @test
     */
    public function it_can_show_customer()
    {
        $customer = factory(Customer::class)
            ->states('with_company')
            ->create();

        $this
            ->getJson(route('customer.show', $customer))
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonFragment($customer->toArray());
    }

    /**
     * @test
     */
    public function it_can_update_customer()
    {
        $customer = factory(Customer::class)
            ->states('with_company')
            ->create();

        $customer->fill(factory(Customer::class)->make()->toArray());

        $this
            ->putJson(route('customer.update', $customer), $customer->toArray())
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonFragment($customer->toArray());

        $this->assertDatabaseHas(self::TABLE, $customer->toArray());
    }

    /**
     * @test
     */
    public function it_can_destroy_customer()
    {
        $customer = factory(Customer::class)
            ->states('with_company')
            ->create();

        $this
            ->deleteJson(route('customer.destroy', $customer))
            ->assertStatus(Response::HTTP_NO_CONTENT);
    }
}
