<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Morilog\Jalali\Jalalian;

class SalesCaseStatusHistory extends Model
{
    use HasFactory;
    protected $fillable= ['sales_case_id', 'status_id', 'user_id', 'description'];

    public function salesCase()
    {
        return $this->belongsTo(SalesCase::class , 'sales_case_id');
    }
    public function status()
    {
        return $this->belongsTo(SalesCaseStatus::class , 'status_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class , 'user_id');
    }
    public function created_at()
    {
        return Jalalian::forge($this->created_at)->format('%A, %d %B %Y - H:i');
    }
}
