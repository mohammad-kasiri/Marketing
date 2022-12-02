<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesCaseStatusRule extends Model
{
    use HasFactory;
    protected $fillable=['to', 'from', 'is_active'];

    public function fromStatus()
    {
        return $this->belongsTo(SalesCaseStatus::class , 'from');
    }
    public function toStatus()
    {
        return $this->belongsTo(SalesCaseStatus::class , 'to');
    }
}
