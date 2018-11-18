<?php

use App\Customer;
use Illuminate\Database\Seeder;
use App\Company;

class CompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Company::class, 2)->create()->each(function ($company) {
            $company->customers()->saveMany(factory(Customer::class, 2)->make());
        });
    }
}
