<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;

    protected $fillable = ['given_name', 'family_name', 'email', 'company_id'];

    protected $dates = ['deleted_at'];

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
