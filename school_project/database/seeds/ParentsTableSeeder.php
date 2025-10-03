
<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ParentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $students = DB::table('admission_forms')->get();

        foreach ($students as $student) {
            $email = $faker->unique()->safeEmail;
            DB::table('parents')->updateOrInsert(
                ['email' => $email],
                [
                    'full_name' => $student->parent_name,
                    'gender' => 'male',
                    'spouse_name' => $faker->name('female'),
                    'blood_group' => $faker->randomElement(['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-']),
                    'religion' => 'Islam',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
