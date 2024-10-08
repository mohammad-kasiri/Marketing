<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Verification extends Model
{
    use HasFactory;

    const CODE_VALID_FOR = 3;  // minutes

    protected $fillable = ['mobile' , 'code' , 'code_expire_at'];

    public static function makeCode()
    {
        return  rand(100000, 999999);
    }
}
