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

    protected $fillable=['price', 'account_number', 'description', 'status'];

    public function created_at()
    {
        return Jalalian::forge($this->created_at)->format('%A, %d %B %Y');
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

}
