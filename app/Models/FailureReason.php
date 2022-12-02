<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FailureReason extends Model
{
    use HasFactory;
    protected $fillable= ['title', 'is_deletable'];

    public function salesCases()
    {
        return $this->hasMany(SalesCase::class, 'failure_reason_id');
    }
}
