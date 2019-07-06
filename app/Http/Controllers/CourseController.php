<?php

namespace App\Http\Controllers;

use App\Course;

class CourseController extends Controller
{
    public function index()
    {
        $course = Course::all();
        return $this->createSuccessResponse($course,200);
    }
    
    public function show($id)
    {
        $course = Course::find($id);

        if($course)
        {
            return $this->createSuccessResponse($course,200);
        }

        return $this->createErrorMessage("The course id {$id},does not exists",404);
    }

}
