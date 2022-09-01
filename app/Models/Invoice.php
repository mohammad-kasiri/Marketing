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

    protected $fillable=['price', 'account_number', 'description', 'status', 'paid_at'];

    public function created_at()
    {
        return Jalalian::forge($this->created_at)->format('%A, %d %B %Y');
    }
    public function paid_at()
    {
        return Jalalian::forge($this->paid_at)->format('%A, %d %B %Y');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
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
        if($this->status == 'sent')     return 'ارسال شده';
        if($this->status == 'approved') return 'تایید شده';
        if($this->status == 'rejected') return 'غیر قابل قبول';
    }
    public function price()
    {
        return number_format($this->price);
    }

    //------------------------------------------    Queries      ------------------------------------------//

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
        return ($key == null) ? $query : $query->where("account_number" , $key);
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
