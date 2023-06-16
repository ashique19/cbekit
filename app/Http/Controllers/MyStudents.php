<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Course;
use App\Invitation;
use App\User;

class MyStudents extends Controller
{
    
    public function course($course_id)
    {

        $course = Course::find($course_id);

        if( ! $course) return back()->withErrors('Course was not found');

        $students = $course->myStudents()->paginate(100);

        // return $students;

        return view('teacher.my-students', compact('course', 'students') );

    }


    public function inviteStudent($course_id)
    {

        $course = Course::find($course_id);

        if( ! $course ) return back()->withErrors('Course was not found in system.');

        $student = null;

        return view('teacher.invite-student', compact('course', 'student') );

    }


    public function postInviteStudent(Request $request, $course_id)
    {

        $this->validate($request, [
            'email' => 'required|email'
        ]);

        $course = Course::find($course_id);

        if( ! $course ) return back()->withErrors('Course was not found in system.');

        $student = User::students()->where('email', 'like', $request->input('email') )->first();

        if(! $student) return back()->withErrors('Student was not found');

        $already_enrolled = $course->students()->where('user_id', $student->id)->where('teacher_id', auth()->user()->id)->first();

        if( $already_enrolled ) return back()->withErrors('This student is already enroled for you.');

        $invitation_sent = Invitation::where('course_id', $course->id)->where('student_id', $student->id)->where('teacher_id', auth()->user()->id)->first();

        if( $invitation_sent ) return back()->withErrors('You have already invited this student to enroll.');

        return view('teacher.invite-student', compact('course', 'student') );

    }


    public function addStudent($course_id, $student_id)
    {

        $invitation_exists = Invitation::where('teacher_id', auth()->user()->id )->where('student_id', $student_id)->where('course_id', $course_id)->first() ;

        if( $invitation_exists )
        {

            return back()->withErrors('Invitation already exists for this course.');

        }

        $student = User::students()->where('id', $student_id)->first();

        if( ! $student ) return back()->withErrors('Student was not found in system.');

        $course = Course::find($course_id);

        if( ! $course ) return back()->withErrors('Course does not exist in system');

        $already_enrolled = $course->students()->where('user_id', $student->id)->where('teacher_id', auth()->user()->id)->first();

        if( $already_enrolled ) return back()->withErrors('This student is already enroled for you.');

        $invitation = Invitation::create([
            'student_id'=> $student->id,
            'course_id' => $course_id,
            'teacher_id' => auth()->user()->id
        ]);

        return back()->withErrors('Invitation has been created successfully.');

    }


    public function pendingInvitesSent($course_id)
    {

        $course = Course::find($course_id);

        if( ! $course ) return back()->withErrors('Course does not exist in system');

        $invitations = Invitation::where('invited_by', auth()->user()->id )->where('course_id', $course_id)->paginate(100) ;

        return view('teacher.pending-invites-sent', compact('course', 'invitations') );
    }


    public function pendingInvitesReceived($course_id)
    {

        $course = Course::find($course_id);

        if( ! $course ) return back()->withErrors('Course does not exist in system');

        $invitations = Invitation::where('invited_by', '!=', auth()->user()->id )
                                 ->where('teacher_id', auth()->user()->id)
                                 ->where('course_id', $course_id)
                                 ->paginate(100) ;

        return view('teacher.pending-invites-received', compact('course', 'invitations') );
    }

}
