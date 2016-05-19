<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB as DB;
use App\Teacher;
use App\Student;
use App\Course;
use App\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //disable foreign key check for this connection before running seeders
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        Teacher::truncate();
        Student::truncate();
        Course::truncate();
        User::truncate();
        DB::table('course_student')->truncate();

        factory(Teacher::class, 50)->create();
        factory(Student::class, 500)->create();
        factory(Course::class, 40)->create()->each(function(Course $course) {
            $course->students()->attach(array_rand(range(1, 500), 40));
        });
        factory(User::class, 2)->create();
        //enable foreign key check again
        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
    }
}
