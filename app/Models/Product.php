<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    const PAGINATION_LIMIT = 20;

    protected $fillable=['title'];

    public function invoices()
    {
        return $this->belongsToMany(Invoice::class,
            'invoice_product',
            'product_id',
            'invoice_id');
    }

    public function sales_cases()
    {
        return $this->belongsToMany(SalesCase::class,
            'product_sales_case',
            'product_id',
            'sales_case_id');
    }
}
