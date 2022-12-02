<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SMS extends Model
{
    use HasFactory;
    protected $fillable=['template_id', 'text', 'is_active'];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
