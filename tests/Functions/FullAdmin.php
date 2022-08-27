<?php

namespace Tests\Functions;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\PermissionSeeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;

class FullAdmin
{
    public static function make()
    {
        // Here 1 Admin Created
        $admin = User::factory()->superAdmin()->create();
        return $admin;
    }
}
