<?php

namespace App\Http\Controllers;

use App\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('oauth', ['except' => 'index']);
    }

    public function index()
    {
        $students = Student::all();
        return $this->createSuccessResponse($students, 200);
    }

    public function store(Request $request)
    {
        $this->validateRequest($request);
        $student = Student::create($request->all());
        return $this->createSuccessResponse("The student with id {$student->id} has been created successful", 201);
    }

    public function show($id)
    {
        $student = Student::find($id);
        if ($student) {
            return $this->createSuccessResponse($student, 200);
        }

        return $this->createErrorResponse("The student with id {$id} does not exist", 404);
    }

    public function update(Request $request, $id)
    {
        $student = Student::find($id);

        if($student) {
            $this->validateRequest($request);
            $student->name = $request->get('name');
            $student->phone = $request->get('phone');
            $student->address = $request->get('address');
            $student->career = $request->get('career');
            $student->save();
            return $this->createSuccessResponse("The student with id {$student->id} has been updated successfully", 200);
        }

        return $this->createErrorResponse("The student with the specified id does not exist", 404);
    }

    public function destroy($id)
    {
        $student = Student::find($id);
        if($student) {
            $student->courses()->detach();
            $student->delete();
            return $this->createSuccessResponse("The student with id {$id} has been removed successfully", 200);
        }

        return $this->createErrorResponse("The student with the specified id does not exist", 404);
    }

    protected function validateRequest($request)
    {
        $rules = [
            'name' => 'required',
            'phone' => array('required', 'regex:/\(?([0-9]{3})\)?([ .-]?)([0-9]{3})\2([0-9]{4})/'),
            'address' => 'required',
            'career' => 'required|in:engineering,math,physic'
        ];
        $messages = [
            'phone.regex' =>
                "The :attribute must be one of phone format (123) 456 7899 ,(123).456.7899, (123)-456-7899, 123-456-7899, 123 456 7899, 1234567899",
            'in'      => 'The :attribute must be one of the following types: :values',
        ];
        $this->validate($request, $rules, $messages);
    }
}