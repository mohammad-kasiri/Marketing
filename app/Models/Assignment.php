<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Morilog\Jalali\Jalalian;

class Assignment extends Model
{
    use HasFactory;
    protected $fillable=['from_user_id', 'to_user_id', 'sales_case_status_id', 'failure_reason_id', 'count'];

    public function from_user()              {return $this->belongsTo(User::class,'from_user_id'); }
    public function to_user()                {return $this->belongsTo(User::class,'to_user_id'); }
    public function sales_case_status()      {return $this->belongsTo(SalesCaseStatus::class,'sales_case_status_id'); }
    public function failure_reason()         {return $this->belongsTo(SalesCaseStatus::class,'failure_reason_id'); }
    public function salescases()
    {
        return $this->belongsToMany(SalesCase::class,
            'assignment_sales_case',
            'assignment_id',
            'sales_cases_id');
    }
    public function created_at()             {return Jalalian::forge($this->created_at)->format('   %A, %d %B   H:i   ');}
}
