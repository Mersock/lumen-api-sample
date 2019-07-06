<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Teacher;
use App\Course;

class TeacherCourseController extends Controller
{
    public function __construct()
    {
        $this->middleware('oauth',['except'=>['index']]);
    }

    public function index($teacher_id)
    {
        $teacher = Teacher::find($teacher_id);

        if($teacher)
        {
            $course = $teacher->courses;
            return $this->createSuccessResponse($course,200);
        }

        return $this->createErrorMessage("Does not exits a course with the give id",404);
    }

    public function store(Request $req,$teacher_id)
    {
        $teacher = Teacher::find($teacher_id);

        if($teacher)
        {
            $this->validateRequtes($req);

            $course = Course::create(
                [
                    'title' => $req->get('title'),
                    'description' => $req->get('description'),
                    'value' => $req->get('value'),
                    'teacher_id' => $teacher->id,
                ]
            );
            return $this->createSuccessResponse("The course with id {$course->id} has been created and assoceated with the teacher with id {$teacher->id}",201);
        }
        return $this->createErrorMessage("The Teacher with id {$teacher_id} does not exists",404);
    }

    public function update(Request $req,$teacher_id,$course_id)
    {
        $teacher = Teacher::find($teacher_id);

        if($teacher)
        {
            $course = Course::find($course_id);

            if($course)
            {
                $this->validateRequtes($req);
                $course->title = $req->get('title');
                $course->description = $req->get('description');
                $course->value = $req->get('value');
                $course->teacher_id = $teacher_id;

                $course->save();

                return $this->createSuccessResponse("The course with id {$course_id} was updated",200);
            }
            return $this->createErrorMessage("Does not exists a course with the id {$course_id}",404);
        }
        return $this->createErrorMessage("Does not exists a teacher with the id {$teacher_id}",404);
    }

    public function destroy($course_id,$teacher_id)
    {
        $teacher = Teacher::find($teacher_id);

        if($teacher)
        {
            $course = Course::find($course_id);

            if($course)
            {   
                if($teacher->courses()->find($course_id))
                {
                    $course->students()->detach();

                    $course->delete();
                    
                    return $this->createSuccessResponse("The course with id {$course_id} was remove",200);
                }
                return $this->createSuccessResponse("The course with id {$course_id} is not associated with id {$teacher_id} exists a course with the {$course_id}",404);
            }
            return $this->createErrorMessage("Does not exists a course with the id {$course_id}",404);
        }
        return $this->createErrorMessage("Does not exists a teacher with the id {$teacher_id}",404);
    }

    public function validateRequtes(Request $req)
    {
        $rules = [
            'title' => 'required',
            'description' => 'required',
            'value' => 'required|numeric',
        ];

        $this->validate($req,$rules);

    }


}
