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
        // Verificar se o tenant já existe
        $existingTenant = DB::table('tenants')->where('slug', '3dk')->first();

        if ($existingTenant) {
            $tenantId = $existingTenant->id;
            $this->command->info("Tenant '3DK' já existe. Usando tenant existente.");
        } else {
            // Create tenant with generated UUID
            $tenantId = (string) Str::uuid();

            DB::table('tenants')->insert([
                'id' => $tenantId,
                'name' => '3DK',
                'slug' => '3dk',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $this->command->info("Tenant '3DK' criado com sucesso.");
        }

        // Verificar se o usuário já existe
        $existingUser = DB::table('users')->where('email', 'matheushlm2@gmail.com')->first();

        if ($existingUser) {
            $this->command->info("Usuário 'matheushlm2@gmail.com' já existe.");
        } else {
            // Create user and link to tenant (let DB assign user id)
            DB::table('users')->insert([
                'name' => 'Matheus Henrique',
                'email' => 'matheushlm2@gmail.com',
                'password' => Hash::make('matheus007'),
                'tenant_id' => $tenantId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $this->command->info("Usuário 'Matheus Henrique' criado com sucesso.");
        }
    }
}
