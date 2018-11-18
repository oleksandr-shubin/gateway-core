<?php


namespace App\Service;


use App\Customer;
use App\Transfer;
use Faker\Factory as FakerFactory;
use Illuminate\Support\Facades\DB;

class TransferDataService
{
    public const HALF_YEAR_MONTHS = 6;
    private const INTERVAL = '+1 months';

    private $faker;

    public function __construct()
    {
        $this->faker = FakerFactory::create();
    }

    public function generate($customerTransfersPerMonthCount)
    {
        DB::transaction(function () use ($customerTransfersPerMonthCount) {
            Transfer::query()->delete();

            foreach (Customer::all() as $customer) {
                $transfers = collect();

                for ($i = -1; $i >= (-1 * self::HALF_YEAR_MONTHS); $i--) {
                    $startDate = $i . ' months';

                    $transfersPerMonth = $this->generateTransfers(
                        $startDate,
                        $customerTransfersPerMonthCount
                    );

                    $transfers = $transfers->merge($transfersPerMonth);
                }

                $customer->transfers()->saveMany($transfers);
            };
        });
    }

    private function generateTransfers($startDate, $customerTransfersPerMonthCount)
    {
        $transfersPerMonth = factory(Transfer::class, $customerTransfersPerMonthCount)->make();
        $transfersPerMonth->each(function ($transfer) use ($startDate) {
            $transfer->created_at = $this->faker->dateTimeInInterval($startDate, self::INTERVAL);
        });

        return $transfersPerMonth;
    }
}