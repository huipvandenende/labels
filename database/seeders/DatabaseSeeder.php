<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $company = \App\Models\Company::create([
            'name' => 'Test Company',
            'qls_company_id' => config('services.qls_demo.company_id'),
        ]);

        \App\Models\Brand::create([
            'company_id' => $company->id,
            'qls_brand_id' => config('services.qls_demo.brand_id'),
        ]);

        $user = \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'company_id' => $company->id,
        ]);

        \App\Models\Api::create([
            'company_id' => $company->id,
            'qls_user' => config('services.qls_demo.user'),
            'qls_password' => config('services.qls_demo.password'),
        ]);
    }
}
