
<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class StudentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $classes = DB::table('class_forms')->get();
        $teachers = DB::table('teachers')->get();

        foreach ($classes as $class) {
            for ($i = 0; $i < 20; $i++) {
                $teacher = $teachers->random();
                $email = $faker->unique()->safeEmail;
                DB::table('admission_forms')->updateOrInsert(
                    ['email' => $email],
                    [
                        'full_name' => $faker->name,
                        'parent_name' => $faker->name('male'),
                        'gender' => $faker->randomElement(['male', 'female']),
                        'dob' => $faker->date($format = 'Y-m-d', $max = '2018-01-01'),
                        'blood_group' => $faker->randomElement(['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-']),
                        'religion' => 'Islam',
                        'class' => $class->class,
                        'section' => $class->section,
                        'teacher_name' => $teacher->first_name . ' ' . $teacher->last_name,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
            }
        }
    }
}
