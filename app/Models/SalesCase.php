<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Morilog\Jalali\Jalalian;

class SalesCase extends Model
{
    use HasFactory;

    protected $fillable=['agent_id', 'customer_id', 'status_id', 'failure_reason_id', 'invoice_id', 'failure_reason','admin_note', 'description', 'is_promoted', 'tag_id' ];

    public function scopeUnassigned($query)
    {
        return $query->where('agent_id', null);
    }
    public function agent()
    {
        return $this->belongsTo(User::class , 'agent_id');
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class , 'customer_id');
    }
    public function status()
    {
        return $this->belongsTo(SalesCaseStatus::class , 'status_id');
    }
    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }
    public function tag()
    {
        return $this->belongsTo(SalesCaseTag::class, 'tag_id');
    }
    public function failureReason()
    {
        return $this->belongsTo(FailureReason::class , 'failure_reason_id');
    }
    public function created_at()
    {
        return Jalalian::forge($this->created_at)->format('%A, %d %B %Y');
    }
    public function updated_at()
    {
        return Jalalian::forge($this->updated_at)->format('%A, %d %B %Y');
    }
    public function products()
    {
        return $this->belongsToMany(Product::class,
            'product_sales_case',
            'sales_case_id',
            'product_id');
    }

    public static function makeUniqueGroupTag()
    {
        $tag= Str::random(10);
        $exists= SalesCaseTag::query()->where('tag', '=', $tag)->exists();
        return $exists
            ? static::makeUniqueGroupTag()
            : $tag;
    }
}
