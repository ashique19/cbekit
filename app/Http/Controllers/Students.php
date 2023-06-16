<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Invitation;
use App\Notification;

class Students extends Controller
{
    
    public function myInvitations()
    {
    
        $invitations = Invitation::where("student_id", auth()->user()->id)->where('invited_by', '!=', auth()->user()->id)->latest()->paginate(30);
        
        return view('student.invitations', compact('invitations') );
    
    }


    public function acceptInvitation($id)
    {

        $invitation = Invitation::where('id', $id)->where('student_id', auth()->user()->id)->first();

        if( ! $invitation ) return back()->withErrors('Invitation was not found.');

        $course_student = \App\CourseUser::where('user_id', auth()->user()->id )->where('course_id', $invitation->course_id)->first();

        if( ! $course_student ) return back()->withErrors('You must enrole into this course first in order to accept invitation.');
        
        if( $course_student->teacher_id != null )
        {

            $teacher = $course_student->teacher;

            Notification::create([
                'user_id' => auth()->user()->id,
                'name' => $teacher->name.' has been removed to add new teacher (Invitaion ID:'.$id.') for the course:'.$invitation->course->name.'.'
            ]);

        }

        $course_student->update([ 'teacher_id' => $invitation->teacher_id ]);
        $invitation->update([ 'is_accepted' => 1 ]);

        Notification::create([
            'user_id' => auth()->user()->id,
            'name' => $invitation->teacher->name.' has been added (Invitaion ID:'.$id.') for the course:'.$invitation->course->name.'.'
        ]);

        Notification::create([
            'user_id' => $invitation->teacher_id,
            'name' => $invitation->student->name.' has accepted your invitation (Invitaion ID:'.$id.') for the course:'.$invitation->course->name.'.'
        ]);

        return back()->withErrors('Invitation has been accepted successfully.');

    }


    public function deleteInvitation($id)
    {

        $invitation = Invitation::where('id', $id)->where('student_id', auth()->user()->id)->first();

        if( ! $invitation ) return back()->withErrors('Invitation was not found.');

        Notification::create([
            'user_id' => auth()->user()->id,
            'name' => 'Invitation has been deleted by '.auth()->user()->name.' (Invitaion ID:'.$id.') for the course:'.$invitation->course->name.'.'
        ]);


        Notification::create([
            'user_id' => $invitation->teacher_id,
            'name' => 'Invitation has been deleted by '.auth()->user()->name.' (Invitaion ID:'.$id.') for the course:'.$invitation->course->name.'.'
        ]);

        $invitation->delete();

        return back()->withErrors('Invitation has been deleted successfully.');

    }
    

}
