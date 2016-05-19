<?php

namespace App\Http\Controllers;

use App\Course;
use App\Student;

class CourseStudentController extends Controller
{

    public function index($course_id)
    {
        $course = Course::find($course_id);
        if ($course) {
            $students = $course->students;
            return $this->createSuccessResponse($students, 200);
        }
        return $this->createErrorResponse("The course with id {$course_id} does not exist", 404);
    }

    public function store($course_id, $student_id)
    {
        $course = Course::find($course_id);
        if ($course) {
            $student = Student::find($student_id);
            if ($student) {
                if ($course->students()->find($student->id)) {
                    return $this->createErrorResponse("The student with id {$student_id} already exists in the course with id {$course_id}", 409);
                };

                $course->students()->attach($student->id);
                return $this->createSuccessResponse("The student with id {$student_id} was added to the course with id {$course_id}", 201);
            }

            return $this->createErrorResponse("The student with id {$student_id} does not exist", 404);

        }
        return $this->createErrorResponse("The course with id {$course_id} does not exist", 404);
    }

    public function destroy($course_id, $student_id)
    {
        $course = Course::find($course_id);
        if ($course) {
            $student = Student::find($student_id);
            if ($student) {
                if (!$course->students()->find($student->id)) {
                    return $this->createErrorResponse("The student with id {$student_id} does not exists in the course with id {$course_id}", 409);
                };

                $course->students()->detach($student->id);
                return $this->createSuccessResponse("The student with id {$student_id} was removed to the course with id {$course_id}", 201);
            }

            return $this->createErrorResponse("The student with id {$student_id} does not exist", 404);

        }
        return $this->createErrorResponse("The course with id {$course_id} does not exist", 404);
    }
}