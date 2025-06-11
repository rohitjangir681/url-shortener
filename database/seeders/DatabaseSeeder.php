<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create a SuperAdmin
        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'password' => bcrypt('password'),
            'role' => 'superadmin',
            'company_id' => null,
        ]);

        // Create a demo company and admin
        $company = Company::create(['name' => 'Demo Company']);
        
        User::create([
            'name' => 'Company Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'company_id' => $company->id,
        ]);
    }
}