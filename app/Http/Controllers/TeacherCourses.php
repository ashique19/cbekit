<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Course;
use App\User;

class TeacherCourses extends Controller
{
    
    public function index($name)
    {
        
        $course = Course::where('name', 'like', $name)->first() ?: Course::find($name);

        if( ! $course ) return back()->withErrors('Requested course was not found');
        
        return view('teacher.course', compact('course') );
        
    }
    
    public function exams($name)
    {
        
        $course = Course::where('name', 'like', $name)->first() ?: Course::find($name);

        if( ! $course ) return back()->withErrors('Requested course was not found');
        
        $exams = $course ? $course->exams()->latest()->paginate(30) : [];
        
        return view('teacher.exams', compact('course', 'exams') );
        
    }
    
    
    public function students($id)
    {
        
        $course = Course::find( $id );
        
        if( ! $course ) return back()->withErrors('Course was not found');
        
        $students = $course->students()->withPivot('is_enroled', 'is_free', 'is_premium', 'is_paid', 'is_active', 'start_date', 'end_date', 'note')->get();
        
        return view('teacher.students', compact( 'course', 'students' ));
        
    }
    
    
    
    
    
}
