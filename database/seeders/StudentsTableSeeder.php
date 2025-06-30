<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // ✅ this line is essential

class StudentsTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('students')->insert([
            [
                'name' => 'Ali',
                'batch' => 'B1',
                'fees_paid' => 1000.00,
                'due_date' => '2025-07-10',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Fatima',
                'batch' => 'B1',
                'fees_paid' => 500.00,
                'due_date' => '2025-07-05',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Rahul',
                'batch' => 'B2',
                'fees_paid' => 2000.00,
                'due_date' => '2025-07-01',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
