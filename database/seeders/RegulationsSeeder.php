<?php

namespace Database\Seeders;

use App\Models\Regulations;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegulatiosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Regulations::create([
            'regulation_name' => 'via pública',
        ]);
        Regulations::create([
            'regulation_name' => 'festividades',
        ]);
        Regulations::create([
            'regulation_name' => 'festividad, metro extra',
        ]);
    }
}
