<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = ['given_name', 'family_name', 'email', 'company_id'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
