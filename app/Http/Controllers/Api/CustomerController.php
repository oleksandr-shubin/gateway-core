<?php

namespace App\Http\Controllers\Api;

use App\Customer;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCustomer;
use App\Http\Requests\UpdateCustomer;
use App\Http\Resources\Customer as CustomerResource;
use Illuminate\Http\Response;

class CustomerController extends Controller
{
    public const PER_PAGE = 10;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return CustomerResource::collection(Customer::paginate(self::PER_PAGE));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCustomer $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCustomer $request)
    {
        $customer = Customer::create($request->all());
        return response()->json(new CustomerResource($customer), Response::HTTP_CREATED);
    }

    /**
     *
     * Display the specified resource.
     *
     * @param  \App\Customer $customer
     * @return CustomerResource
     */
    public function show(Customer $customer)
    {
        return new CustomerResource($customer);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCustomer $request
     * @param  \App\Customer $customer
     * @return CustomerResource
     */
    public function update(UpdateCustomer $request, Customer $customer)
    {
        $customer->update($request->only('given_name', 'family_name', 'email'));
        return new CustomerResource($customer);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Customer $customer
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();
        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
