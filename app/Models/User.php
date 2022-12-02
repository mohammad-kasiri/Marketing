<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Functions\Avatar;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Morilog\Jalali\Jalalian;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class User extends Authenticatable implements HasMedia
{
    use HasApiTokens, HasFactory, InteractsWithMedia;

    const PAGINATION_LIMIT = 20;

    protected $fillable = [
        'level',
        'first_name',
        'last_name',
        'mobile',
        'email',
        'percentage',
        'sheba_number',
        'is_active',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function scopeAgents($query)
    {
        return $query->where('level','agent');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }

    public function scopeInactive($query)
    {
        return $query->where('is_active', 0);
    }

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function last_login()
    {
        return Jalalian::forge($this->last_login)->ago();
    }

    public function created_at()
    {
        return Jalalian::forge($this->created_at)->format('%A, %d %B %Y');
    }
    public function gender()
    {
        return $this->gender == 'male'
            ? 'آقا'
            : 'خانم';
    }
    public function genderIcon()
    {
        return $this->gender == 'male'
            ? asset("images/static/genders/male.png")
            : asset("images/static/genders/female.png");
    }

    public function avatar($collection = 'avatar')
    {
        return $this->getFirstMedia($collection)?->getUrl()
               ??
               Avatar::{$this->gender}() ;
    }

    public function setAvatar()
    {
        if (request()->hasFile('avatar')) {
            $this->media()->delete();
            $this->addMediaFromRequest('avatar')
                ->toMediaCollection('avatar');
        }
    }

    public function invoice()
    {
        return $this->hasMany(Invoice::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
