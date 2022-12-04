<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesCaseStatus extends Model
{
    use HasFactory;
    protected $fillable= ['name', 'sort', 'color', 'icon', 'is_active', 'is_first_step', 'is_before_last_step', 'is_last_step'];

    public function salesCases()
    {
        return $this->hasMany(SalesCase::class, 'status_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function note()
    {
        if ($this->is_first_step)
            return 'وضعیت هنگام تعریف یک پرونده';

        if ($this->is_before_last_step)
            return 'وضعیت یکی مانده به آخر';

        if ($this->is_last_step)
            return 'وضعیت موفق';
    }

}
