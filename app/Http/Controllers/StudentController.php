<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Student;

class StudentController extends Controller
{
    public function __construct()
    {
        $this->middleware('oauth',['except'=>['index','show']]);
    }

    public function index()
    {
        $student = Student::all();
        return $this->createSuccessResponse($student,200);
    }

    public function store(Request $req)
    {
        $this->validateRequtes($req);

        $student = Student::create($req->all());

        return $this->createSuccessResponse("Ther student with id {$student->id} has been create",201);
    }

    public function show($id)
    {
        $student = Student::find($id);

        if($student)
        {
            return $this->createSuccessResponse($student,200);
        }

        return $this->createErrorMessage("The student id {$id},does not exists",404);
    }

    public function update(Request $req,$student_id)
    {

        $student = Student::find($student_id);

        if($student)
        {
            $this->validateRequtes($req);

            $student->name = $req->get('name');
            $student->phone = $req->get('phone');
            $student->address = $req->get('address');
            $student->career = $req->get('career');

            $student->save();

            return $this->createSuccessResponse("Ther student with id {$student->id} has been update",200);
        }
        
        return $this->createErrorMessage("The Student with the specified id does not exists.",404);
    }

    public function destroy($student_id)
    {
        $student = Student::find($student_id);

        if($student)
        {
            $student->courses()->detach();
            
            $student->delete();

            return $this->createSuccessResponse("Ther student with id {$student->id} has been removed",200);
        }
        return $this->createErrorMessage("The student with the specified id does not exits");
    }

    public function validateRequtes(Request $req)
    {
        $rules = [
            'name' => 'required',
            'phone' => 'required|numeric',
            'address' => 'required',
            'career' => 'required|in:engineering,math,physics'
        ];

        $this->validate($req,$rules);

    }

}
