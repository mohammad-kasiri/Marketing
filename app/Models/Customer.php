<?php

namespace App\Models;

use App\Functions\Avatar;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Morilog\Jalali\Jalalian;

class Customer extends Model
{
    use HasFactory;

    const PAGINATION_LIMIT = 50;

    protected $fillable=['fullname', 'mobile', 'email', 'birth_date', 'gender', 'city', 'possibility_of_purchase', 'description', 'status'];

    public function salesCases()
    {
        return $this->hasMany(SalesCase::class);
    }

    public function city()
    {
        return $this->belongsTo(Province::class);
    }

    public function created_at()
    {
        return Jalalian::forge($this->created_at)->format('%A, %d %B %Y ');
    }

    public function updated_at()
    {
        return Jalalian::forge($this->updated_at)->format(' H:i | %A, %d %B %Y ');
    }

    public function genderIcon()
    {
        return is_null($this->gender)
            ? Avatar::male()
            : Avatar::{$this->gender}() ;
    }
    public function age()
    {
        return $this->birth_date == null
            ? null
            : Jalalian::forge($this->birth_date)->format('Y/m/d');
    }
    public function gender()
    {
        return $this->gender == 'male'
            ? 'آقا'
            : 'خانم';
    }
    //------------------------------------------    Queries      ------------------------------------------//
    public function scopeMobilefilter($query , $key)
    {
        return ($key == null) ? $query : $query->where("mobile" ,'LIKE' , '%'.$key.'%');
    }
    public function scopeGenderfilter($query , $key)
    {
        return ($key == null) ? $query : $query->where("gender", $key);
    }

    public function scopeFullnamefilter($query , $key)
    {
        return ($key == null) ? $query : $query->Where("fullname", 'LIKE' , '%'.$key.'%');
    }

    public function scopeFilter($query , $key)
    {
        return $query
            ->fullnamefilter($key["name"] ?? null)
            ->mobilefilter($key["mobile"] ?? null)
            ->genderfilter($key["gender"] ?? null)
            ->latest()
            ->paginate(static::PAGINATION_LIMIT);
    }

    public function DoesNotHaveSalesCase()
    {
        return $this->salesCases()->count() == 0;
    }
}
