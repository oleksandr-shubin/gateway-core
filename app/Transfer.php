<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function scopeOfMonth($query, int $month)
    {
        return $query->whereMonth('transfers.created_at', $month);
    }
}
