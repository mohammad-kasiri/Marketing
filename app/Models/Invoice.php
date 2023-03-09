<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Morilog\Jalali\Jalalian;

class Invoice extends Model
{
    use HasFactory, SoftDeletes;

    const PAGINATION_LIMIT = 20;

    protected $fillable=['price', 'suspicious_with', 'paid_by', 'account_number', 'gateway_tracking_code', 'order_number', 'description', 'status', 'paid_at'];

    public function created_at()
    {
        return Jalalian::forge($this->created_at)->format('   %A, %d %B   H:i   ');
    }
    public function paid_at()
    {
        return Jalalian::forge($this->paid_at)->format('   %A, %d %B   H:i   ');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function suspicious()
    {
        return $this->belongsTo(static::class , 'suspicious_with');
    }

    public function salesCase()
    {
        return $this->hasMany(SalesCase::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class,
                                    'invoice_product',
                                    'invoice_id',
                                    'product_id');
    }

    public function status()
    {
        if($this->status == 'sent')       return 'در حال بررسی';
        if($this->status == 'approved')   return 'تایید شده';
        if($this->status == 'rejected')   return 'عدم تایید';
        if($this->status == 'suspicious') return  auth()->user()->level == 'admin' ? 'مشکوک' : 'در حال بررسی';
    }

    public function status_color()
    {
        if($this->status == 'sent')       return 'primary';
        if($this->status == 'approved')   return 'success';
        if($this->status == 'rejected')   return 'danger';
        if($this->status == 'suspicious') return  auth()->user()->level == 'admin' ? 'warning' : 'primary';
    }

    public function price()
    {
        return number_format($this->price);
    }

    //------------------------------------------    Queries      ------------------------------------------//

    public function scopeApproved($query)
    {
        return  $query->where("status" , '=' , 'approved');
    }

    public function scopeStatusfilter($query , $key)
    {
        return ($key == null) ? $query : $query->where("status" , $key);
    }

    public function scopeUserfilter($query , $key)
    {
        return ($key == null) ? $query : $query->where("user_id" , $key);
    }

    public function scopeAccountfilter($query , $key)
    {
        return ($key == null) ? $query : $query
            ->where("account_number" , 'LIKE' , '%'.$key.'%')
            ->orWhere('gateway_tracking_code', 'LIKE' , '%'.$key.'%')
            ->orWhere('order_number', 'LIKE' , '%'.$key.'%');
    }

    public function scopeFilter($query , $key)
    {
        return $query
            ->userfilter($key["user"] ?? null)
            ->accountfilter($key["account_number"] ?? null)
            ->statusfilter($key["status"] ?? null)
            ->latest()
            ->paginate(static::PAGINATION_LIMIT);
    }

    public function jalaliPaidDate()
    {
        return $this->paid_at == null
            ? null
            : Jalalian::forge($this->paid_at)->format('Y/m/d');
    }
    public function jalaliPaidTime()
    {
        return Jalalian::forge($this->paid_at)->format('H:i');
    }
}
