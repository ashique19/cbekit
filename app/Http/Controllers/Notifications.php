<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notification;

class Notifications extends Controller
{
    

    public function index()
    {

        auth()->user()->notifications()->update(['is_read' => 1]);

        if( auth()->user()->role == 3) return $this->student();

        if( auth()->user()->role == 4) return $this->teacher();

    }


    public function student()
    {
    
        $notifications = auth()->user()->notifications()->latest()->paginate(30);

        return view('student.notifications', compact('notifications') );
    
    }


    public function teacher()
    {
    
        $notifications = auth()->user()->notifications()->latest()->paginate(30);

        return view('teacher.notifications', compact('notifications') );
    
    }
    
    


}
