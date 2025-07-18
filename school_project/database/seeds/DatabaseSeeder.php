<?php

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
        $this->call([
            UsersTableSeeder::class,
            TeachersTableSeeder::class,
            SubjectsTableSeeder::class,
            ClassesTableSeeder::class,
            StudentsTableSeeder::class,
            ParentsTableSeeder::class,
            FeesTableSeeder::class,
            ChallansTableSeeder::class,
        ]);
    }
}
