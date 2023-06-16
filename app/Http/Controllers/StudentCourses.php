<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Course;
use App\User;
use App\Exam;
use App\CourseUser;

class StudentCourses extends Controller
{
    
    public function index($name)
    {
        
        $course = Course::where('name', 'like', $name)->first() ?: Course::find($name);

        $enrolled_course = CourseUser::where('user_id', auth()->user()->id )->where('course_id', $course->id)->first();
        
        $graph_1 = [
            'name' => [ 'successful', 'unsuccessful' ],
            'data'  => [ 0,0 ]
        ];

        $graph_2 = [
            'labels' => [],
            'datasets' => [
                'right' => [],
                'wrong' => [],
                'unattempted' => [],
            ]
        ];

        if( $course )
        {

            if( $course->exams()->count() > 0 )
            {

                $attempts = \App\Attempt::join('exams', 'exams.id','attempts.exam_id')
                                        ->where('exams.course_id', $course->id)
                                        ->where('attempts.student_id', auth()->user()->id );
                
                // Graph 1
                if( $attempts->count() > 0 )
                {
                    
                    $success = 0; $failed = 0;

                    foreach( $attempts->get() as $attempt )
                    {
                        
                        $total = $attempt->exam_mark;

                        $acheived = $attempt->achieved_mark;

                        $acheived * 2 > $total ? $success++ : $failed++;

                    }

                    $graph_1['data'] = [ $success, $failed ];

                }
                
                
                $attempts = $attempts->latest('attempts.created_at')->take(10)->get();
                // Graph 2
                if( $attempts->count() > 0 )
                {
                    
                    $success = 0; $failed = 0;

                    foreach( $attempts as $attempt )
                    {
                        
                        $right = $attempt->answers()->groupBy('question_id')->where('achieved_mark', '>', 0)->count();
                        $wrong = $attempt->answers()->groupBy('question_id')->where('achieved_mark', '=', 0)->count();

                        $graph_2['labels'][] = $attempt->created_at->format('d-M');
                        $graph_2['datasets']['right'][] = $right;
                        $graph_2['datasets']['wrong'][] = $wrong;
                        $graph_2['datasets']['unattempted'][] = $attempt->exam->questions()->count() - $right - $wrong;

                    }

                }


            }

        }


        // return $graph_2;
        return view('student.course', compact('course', 'enrolled_course', 'graph_1', 'graph_2') );
        
    }
    
    
    private function expiry_date()
    {
        
        $expiry_date = date('Y-12-31 23:59:59');
        
        if( date('m') == 12 )
        {
            
            $expiry_date = date('Y') + 1 . '-06-30 23:59:59';
            
        } elseif( date('m') >=6 && date('m') < 12 )
        {
            
            $expiry_date = date('Y') . '-12-31 23:59:59';
            
        } elseif( date('m') <= 5 )
        {
            
            $expiry_date = date('Y') . '-06-30 23:59:59';
            
        }
        
        return $expiry_date;
        
    }
    
    
    public function enroleFree($id)
    {
        
        if( ! Course::find($id) ) return back()->withErrors('Requested course was not found in system.');
        
        if( free_enroled($id) ) return back()->withErrors('You are already enroled into this course.');
        
        $expiry_date = $this->expiry_date();
        
        CourseUser::create([
            'user_id'       => auth()->user()->id,
            'course_id'     => $id,
            'is_active'     => 1,
            'start_date'    => date('Y-m-d H:i:s'),
            'end_date'      => $expiry_date
        ]);
        
        return back()->withErrors('You have successfully enroled into this course for FREE.');
        
    }
    
    
    public function enrolePremium($id)
    {
        
        if( ! Course::find($id) ) return back()->withErrors('Requested course was not found in system.');
        
        if( premium_enroled($id) ) return back()->withErrors('You are already enroled into this course.');
        
        $expiry_date = $this->expiry_date();
        
        $free_enroled = free_enroled( $id );

        // return action('StudentCourses@updateToPremium', [$id,'_token' => csrf_token() ]);

        $paymentGateway = new \App\Http\Controllers\ShurjoPay;

        return $paymentGateway->initialize($id);

        return $free_enroled;
        
        if( $free_enroled )
        {
            
            $free_enroled->update([
                'is_free' => 0,
                'is_premium' => 1,
                'start_date'    => date('Y-m-d H:i:s'),
                'end_date'      => $expiry_date
            ]);
            
        } else{
            
            CourseUser::create([
                'user_id'       => auth()->user()->id,
                'course_id'     => $id,
                'is_active'     => 1,
                'is_free'       => 0,
                'is_premium'    => 1,
                'start_date'    => date('Y-m-d H:i:s'),
                'end_date'      => $expiry_date
            ]);
            
        }
        
        return back()->withErrors('You have successfully enroled into this course with PREMIUM FEATURES.');
        
    }


    public function updateToPremium(Request $request, $id)
    {

        // return $request->all();

        $paymentGateway = new \App\Http\Controllers\ShurjoPay;

        return $paymentGateway->returnData( $request->input('spdata') );
    
        if( ! Course::find($id) ) return back()->withErrors('Requested course was not found in system.');
        
        if( premium_enroled($id) ) return back()->withErrors('You are already enroled into this course.');
        
        $expiry_date = $this->expiry_date();
        
        $free_enroled = free_enroled( $id );

        return $free_enroled;
        
        if( $free_enroled )
        {
            
            $free_enroled->update([
                'is_free' => 0,
                'is_premium' => 1,
                'start_date'    => date('Y-m-d H:i:s'),
                'end_date'      => $expiry_date
            ]);
            
        } else{
            
            CourseUser::create([
                'user_id'       => auth()->user()->id,
                'course_id'     => $id,
                'is_active'     => 1,
                'is_free'       => 0,
                'is_premium'    => 1,
                'start_date'    => date('Y-m-d H:i:s'),
                'end_date'      => $expiry_date
            ]);
            
        }
        
        return back()->withErrors('You have successfully enroled into this course with PREMIUM FEATURES.');
    
    }
    
    
    public function selectExam($id)
    {
        
        $course = Course::find($id);
        
        if( ! $course ) return back()->withErrors('Requested course was not found in system.');
        
        if( ! free_enroled( $id ) && ! premium_enroled($id) ) return back()->withErrors('Please enrole first to proceed to exams.');
        
        $exams = $course->exams()->latest()->paginate(10);
        
        return view('student.select-exams', compact('course', 'exams') );
        
    }
    
    
    public function attempts($id)
    {
        
        $exam = Exam::find($id);
        
        $course = $exam ? $exam->course : [];
        
        if( ! $course ) return back()->withErrors('Requested course was not found in system.');
        
        $attempts = $exam->attempts()->where('student_id', auth()->user()->id )->paginate(30);
        // return $attempts;
        return view('student.attempts', compact('course','attempts') );
        
    }
    
}
