<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $schemaPath = 'database/database.sql';
        $dataPath = 'database/populate.sql';

        DB::unprepared(file_get_contents($schemaPath));
        $this->command->info('Schema seeded!');

        DB::unprepared(file_get_contents($dataPath));
        $this->command->info('Data seeded!');

    }
}
