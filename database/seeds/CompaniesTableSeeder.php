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
        factory(Company::class, 5)->create()->each(function ($company) {
            $company->customers()->saveMany(factory(Customer::class, 3)->make());
        });
    }
}
