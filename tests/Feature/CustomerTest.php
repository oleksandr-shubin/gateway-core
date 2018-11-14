<?php

namespace Tests\Feature;

use App\Customer;
use Illuminate\Http\Response;
use Tests\TestCase;

class CustomerTest extends TestCase
{
    public const TABLE = 'customers';

    /**
     * @test
     */
    public function it_can_index_customers()
    {
        $customers = factory(Customer::class, 10)->create();

        $this
            ->getJson(route('customer.index'))
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonCount($customers->count(), 'data');
    }

    /**
     * @test
     */
    public function it_can_store_customer()
    {
        $customerData = factory(Customer::class)->make()->toArray();

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
        $customer = factory(Customer::class)->create();

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
        $customer = factory(Customer::class)->create();

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
        $customer = factory(Customer::class)->create();

        $this
            ->deleteJson(route('customer.destroy', $customer))
            ->assertStatus(Response::HTTP_NO_CONTENT);
    }
}
