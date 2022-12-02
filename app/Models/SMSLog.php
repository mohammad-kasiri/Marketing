<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Morilog\Jalali\Jalalian;

class SMSLog extends Model
{
    use HasFactory;
    protected $fillable=['sales_case_id', 'customer_id', 'agent_id', 'template_id', 'text'];

    public function agent()
    {
        return $this->belongsTo(User::class , 'agent_id');
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class , 'customer_id');
    }
    public function salesCase()
    {
        return $this->belongsTo(SalesCase::class , 'sales_case_id');
    }
    public function created_at()
    {
        return Jalalian::forge($this->created_at)->format('%A, %d %B %Y');
    }
}
