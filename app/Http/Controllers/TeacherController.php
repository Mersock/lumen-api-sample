<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Teacher;

class TeacherController extends Controller
{
    public function __construct()
    {
        $this->middleware('oauth',['except'=>['index']]);
    }

    public function index()
    {
        $teacher = Teacher::all();
        return $this->createSuccessResponse($teacher,200);
    }

    public function store(Request $req)
    {
        $rules = [
            'name' => 'required',
            'phone' => 'required|numeric',
            'address' => 'required',
            'profession' => 'required|in:engineering,math,physics'
        ];

        $this->validate($req,$rules);

        $teacher = Teacher::create($req->all());

        return $this->createSuccessResponse("Ther student with id {$teacher->id} has been create",201);
    }

    public function show($id)
    {
        $teacher = Teacher::find($id);

        if($teacher)
        {
            return $this->createSuccessResponse($teacher,200);
        }

        return $this->createErrorMessage("The teacher id {$id},does not exists",404);
    }

    public function update(Request $req,$student_id)
    {

        $teacher = Teacher::find($student_id);

        if($teacher)
        {
            $this->validateRequtes($req);

            $teacher->name = $req->get('name');
            $teacher->phone = $req->get('phone');
            $teacher->address = $req->get('address');
            $teacher->profession = $req->get('profession');

            $teacher->save();

            return $this->createSuccessResponse("Ther teacher with id {$teacher->id} has been update",200);
        }
        
        return $this->createErrorMessage("The Student with the specified id does not exists.",404);
    }

    public function destroy($teacher_id)
    {
        $teacher = Teacher::find($teacher_id);

        if($teacher)
        {
            $courses = $teacher->courses;

            if(sizeof($courses) > 0)
            {   
                return $this->createErrorMessage("Can't remaove a teacher with active courses.Please remove those courses firsts",409);
            }
            
            $teacher->delete();

            return $this->createSuccessResponse("Ther teacher with id {$teacher->id} has been removed",200);
        }
    }

    public function validateRequtes(Request $req)
    {
        $rules = [
            'name' => 'required',
            'phone' => 'required|numeric',
            'address' => 'required',
            'profession' => 'required|in:engineering,math,physics'
        ];

        $this->validate($req,$rules);

    }

}
