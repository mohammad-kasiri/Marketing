<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Morilog\Jalali\Jalalian;

class CallLog extends Model
{
    use HasFactory;
    protected $fillable=['event_name', 'from', 'to', 'uid', 'cuid'];
    public function created_at()
    {
        return Jalalian::forge($this->created_at)->format('%A, %d %B %Y');
    }
}
