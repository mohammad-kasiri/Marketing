<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Morilog\Jalali\Jalalian;

class Task extends Model
{
    use HasFactory;

    protected $fillable= ['sales_case_id', 'user_id', 'title', 'note', 'remind_at', 'done_at'];

    public function user()
    {
        return $this->belongsTo(User::class , 'user_id');
    }
    public function salesCase()
    {
        return $this->belongsTo(SalesCase::class , 'sales_case_id');
    }

    public function created_at()
    {
        return Jalalian::forge($this->created_at)->format('%A, %d %B %Y');
    }
    public function markAsDone()
    {
        $this->update(['done_at' => now()]);
    }

    public static function markAllAsRead()
    {
        static::query()
            ->where('user_id',auth()->id())
            ->where('done_at' , null)
            ->where('remind_at' , '<=', now())
            ->update([
            ['done_at' => now()]
        ]);
    }

    public function updated_at()
    {
        return Jalalian::forge($this->updated_at)->format('%A, %d %B %Y');
    }

    public function remined_at()
    {
        return Jalalian::forge($this->remind_at)->format('%A, %d %B %Y - H:i');
    }
    public function done_at()
    {
        return Jalalian::forge($this->done_at)->format('%A, %d %B %Y - H:i');
    }
    public function jalaliRemindDate()
    {
        return $this->remind_at == null
            ? null
            : Jalalian::forge($this->remind_at)->format('Y/m/d');
    }
    public function jalaliRemindTime()
    {
        return Jalalian::forge($this->remind_at)->format('H:i');
    }
}
