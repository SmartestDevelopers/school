
<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClassesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $teachers = DB::table('teachers')->get();

        DB::table('class_forms')->insert([
            ['class' => '1', 'section' => 'A', 'teacher_name' => $teachers->random()->first_name . ' ' . $teachers->random()->last_name],
            ['class' => '1', 'section' => 'B', 'teacher_name' => $teachers->random()->first_name . ' ' . $teachers->random()->last_name],
            ['class' => '2', 'section' => 'A', 'teacher_name' => $teachers->random()->first_name . ' ' . $teachers->random()->last_name],
            ['class' => '2', 'section' => 'B', 'teacher_name' => $teachers->random()->first_name . ' ' . $teachers->random()->last_name],
            ['class' => '3', 'section' => 'A', 'teacher_name' => $teachers->random()->first_name . ' ' . $teachers->random()->last_name],
            ['class' => '3', 'section' => 'B', 'teacher_name' => $teachers->random()->first_name . ' ' . $teachers->random()->last_name],
            ['class' => '4', 'section' => 'A', 'teacher_name' => $teachers->random()->first_name . ' ' . $teachers->random()->last_name],
            ['class' => '4', 'section' => 'B', 'teacher_name' => $teachers->random()->first_name . ' ' . $teachers->random()->last_name],
            ['class' => '5', 'section' => 'A', 'teacher_name' => $teachers->random()->first_name . ' ' . $teachers->random()->last_name],
            ['class' => '5', 'section' => 'B', 'teacher_name' => $teachers->random()->first_name . ' ' . $teachers->random()->last_name],
        ]);
    }
}
