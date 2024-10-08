<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    const FIRST_CITY_ID = 32;
    const LAST_CITY_ID = 458;

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_id');
    }

    public function customer()
    {
        return $this->hasMany(Customer::class);
    }

    public function scopeProvinces($query)
    {
        return $query->where('province_id' , '=' , null);
    }

    public function scopeCities($query)
    {
        return $query->where('province_id' , '!=' , null);
    }
}
