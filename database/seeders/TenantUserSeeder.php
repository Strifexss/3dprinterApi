<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TenantUserSeeder extends Seeder
{
    public function run(): void
    {
        // Create tenant with generated UUID
        $tenantId = (string) Str::uuid();

        DB::table('tenants')->insert([
            'id' => $tenantId,
            'name' => '3DK',
            'slug' => '3dk',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create user and link to tenant (let DB assign user id)
        DB::table('users')->insert([
            'name' => 'Matheus Henrique',
            'email' => 'matheushlm2@gmail.com',
            'password' => Hash::make('matheus007'),
            'tenant_id' => $tenantId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
