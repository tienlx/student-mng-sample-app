<?php

namespace App\Http\Controllers;

use App\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = Teacher::all();
        return $this->createSuccessResponse($teachers, 200);
    }

    public function store(Request $request)
    {
        $this->validateRequest($request);
        $teacher = Teacher::create($request->all());
        return $this->createSuccessResponse("The teacher with id {$teacher->id} has been created successfully", 201);
    }

    public function show($id)
    {
        $teacher = Teacher::find($id);
        if ($teacher) {
            return $this->createSuccessResponse($teacher, 200);
        }

        return $this->createErrorResponse("The teacher with id {$id} does not exist", 404);
    }

    public function update(Request $request, $id)
    {
        $teacher = Teacher::find($id);

        if($teacher) {
            $this->validateRequest($request);
            $teacher->name = $request->get('name');
            $teacher->phone = $request->get('phone');
            $teacher->address = $request->get('address');
            $teacher->profession = $request->get('profession');
            $teacher->save();
            return $this->createSuccessResponse("The teacher with id {$teacher->id} has been updated successfully", 200);
        }

        return $this->createErrorResponse("The teacher with the specified id does not exist", 404);
    }

    public function destroy($id)
    {
        $teacher = Teacher::find($id);
        if($teacher) {
            $courses = $teacher->courses;
            if (sizeof($courses) > 0) {
                return $this->createErrorResponse("You can not remove a teacher with active course. Please remove those courses first", 409);
            }
            $teacher->delete();
            return $this->createSuccessResponse("The teacher with id {$id} has been removed successfully", 200);
        }

        return $this->createErrorResponse("The teacher with the specified id does not exist", 404);
    }

    protected function validateRequest($request)
    {
        $rules = [
            'name' => 'required',
            'phone' => array('required', 'regex:/\(?([0-9]{3})\)?([ .-]?)([0-9]{3})\2([0-9]{4})/'),
            'address' => 'required',
            'profession' => 'required|in:engineering,math,physics'
        ];
        $messages = [
            'phone.regex' =>
                "The :attribute must be one of phone format (123) 456 7899 ,(123).456.7899, (123)-456-7899, 123-456-7899, 123 456 7899, 1234567899",
            'in'      => 'The :attribute must be one of the following types: :values',
        ];
        $this->validate($request, $rules, $messages);
    }
}