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

    public function transfers()
    {
        return $this->hasMany(Transfer::class);
    }

    public function scopeActiveAtMonth($query, $month) {
        return $query->whereHas('transfers', function ($query) use($month) {
            $query->whereMonth('created_at', $month);
        });
    }
}
