<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = ['name', 'quota'];

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }

    public function transfers()
    {
        return $this->hasMany(Transfer::class);
    }

    public function customersActiveAtMonth($month)
    {
        return $this->customers()->activeAtMonth($month);
    }
}
