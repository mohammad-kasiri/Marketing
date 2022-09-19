<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Morilog\Jalali\Jalalian;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = ['agent_id', 'admin_id', 'total','status' , 'percentage', 'from_date', 'to_date', 'tracing_number', 'description'];

    public function agent()
    {
        return $this->belongsTo(User::class , 'agent_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class , 'admin_id');
    }

    public function total()
    {
        return number_format($this->total);
    }

    public function percentage()
    {
        return number_format($this->percentage);
    }

    public function from_date()
    {
        return Jalalian::forge($this->from_date)->format('%A, %d %B %Y');
    }

    public function to_date()
    {
        return Jalalian::forge($this->to_date)->format('%A, %d %B %Y');
    }
}
