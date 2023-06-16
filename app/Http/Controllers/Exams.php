<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Question;
use App\Answer;
use App\Exam;
use App\Course;
use App\CourseUser;
use App\Attempt;

class Exams extends Controller
{

    
    public function store(Request $request)
    {
        
        $request['is_free'] = $request->input('is_free') ?: 0;
        $request['is_premium'] = $request->input('is_premium') ?: 0;
        
        
        if( strlen( $request->input('name') ) < 2 )
        {
            
            return [
                'stat'=> 'failed',
                'output' => 'Name must have 2 or more characters.'
            ];
            
        }
        
        $exam = Exam::create( $request->all() );
        
        if( $exam )
        {
            
            return [
                'stat' => 'success',
                'output' => action('Exams@edit', $exam->id)
            ];
            
        }
        
    }
    
    
    public function edit($id, Request $request)
    {
        
        $exam = Exam::find($id);

        if( ! $exam ) return back()->withErrors('Exam was not found');
        
        $course = $exam->course;

        if( ! $course ) return back()->withErrors('Course was not found');
        
        $exam_questions = $exam->questions()->select('questions.id as q_id','name','section')->take(50)->get();
        
        $course_questions = $course->questions()->whereNotIn('questions.id', $exam_questions->pluck('q_id')->toArray() )->select('id','name','section')->latest()->paginate(50);

        // return $course_questions;
        return view('teacher.exam-edit', compact('exam', 'course', 'exam_questions', 'course_questions'));
        
    }
    
    
    public function update(Request $request, $id)
    {
        
        $exam = Exam::find($id);
        
        if( $exam )
        {   
            
            $request['is_free'] = $request->input('is_free') ?: 0;
            $request['is_premium'] = $request->input('is_premium') ?: 0;
            
            if( strlen( $request->input('name') ) < 2 )
            {
                
                return back()->withErrors('Name must have 2 or more characters.');
                
            }
            
            if( $exam->update( $request->all() ) )
            {
                
                return back()->withErrors('Exam data has been updated successfully.');
                
            }else{
                
                return back()->withErrors('failed to save data. Please retry later.')->withInput();
                
            }
            
        }
        
        // return $exam;
        
        return back()->withErrors('Exam was not found in system.')->withInput();
        
    }


    public function assets($exam_id)
    {

        $exam = Exam::find($exam_id);
        // return $exam->course;
        if( $exam->course->id < 7 )
        {

            return [
                'css' => [
                    '/public/css/jquery-ui.min.css',
                    '/public/css/front.css',
                ],
                'js' => [
                    '//code.jquery.com/ui/1.12.1/jquery-ui.js'
                ]
            ];
            
        }

        return [
            'css' => [
                '//cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.css',
                '/public/css/jquery-ui.min.css',
                '//cdnjs.cloudflare.com/ajax/libs/tinymce/4.8.3/skins/lightgray/content.min.css',
                '/public/css/jquery-nightowl-1.2.css',
                '/public/css/front.css',
            ],
            'js' => [
                '/public/js/jquery-ui.min.js',
                '/public/js/jquery-nightowl-1.2.js',
                '/public/js/tinymce.min.js',
                '/public/js/spreadsheet.js',
                '/public/js/excel.js',
                '//cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.min.js'
            ]
        ];
        
        
    
    }

    public function instructions($exam_id)
    {

        $exam = Exam::find($exam_id);

        $course = Course::find( $exam->course_id );

        $duration = $exam->exam_duration_minutes;

        if( $exam->course_id < 7 )
        {

            return [
                'header' => view('student.exam.instructions.instruction-1-header', compact('course'))->render(),
                'footer' => view('student.exam.instructions.instruction-1-footer', compact('course'))->render(),
                'bodies' => [
                    view('student.exam.instructions.1', compact('exam', 'course', 'course', 'duration'))->render(),
                    view('student.exam.instructions.2', compact('exam', 'course', 'course', 'duration'))->render(),
                    view('student.exam.instructions.3', compact('exam', 'course', 'course', 'duration'))->render(),
                    view('student.exam.instructions.4', compact('exam', 'course', 'course', 'duration'))->render(),
                    view('student.exam.instructions.5', compact('exam', 'course', 'course', 'duration'))->render(),
                ]
            ];

        }

        return [
            'header' => view('student.exam.instructions.instruction-2-header', compact('course'))->render(),
            'footer' => view('student.exam.instructions.instruction-2-footer', compact('course'))->render(),
            'bodies' => [
                view('student.exam.instructions.6', compact('exam', 'course', 'course', 'duration'))->render(),
                view('student.exam.instructions.7', compact('exam', 'course', 'course', 'duration'))->render(),
                view('student.exam.instructions.8', compact('exam', 'course', 'course', 'duration'))->render(),
                view('student.exam.instructions.9', compact('exam', 'course', 'course', 'duration'))->render(),
                view('student.exam.instructions.10', compact('exam', 'course', 'course', 'duration'))->render(),
                view('student.exam.instructions.11', compact('exam', 'course', 'course', 'duration'))->render(),
            ]
        ];
    
    }
    
    public function questions($exam_id)
    {

        $exam = Exam::find($exam_id);

        $course = Course::find( $exam->course_id );

        $duration = $exam->exam_duration_minutes;

        if( $course->id < 7 ){

            return [
                'header' => view('student.exam.questions.header', compact('exam', 'course', 'duration'))->render(),
                'footer' => view('student.exam.questions.footer', compact('exam', 'course', 'duration'))->render(),
                'before' => view('student.exam.questions.before-question', compact('exam', 'course', 'duration'))->render(),
                'after' => view('student.exam.questions.after-question', compact('exam', 'course', 'duration'))->render(),
                'questions' => $exam->questions()->with('options')->get()
            ];

        }

        return [
            'header' => view('student.exam.questions.header-type-2', compact('exam', 'course', 'duration'))->render(),
            'footer' => view('student.exam.questions.footer-type-2', compact('exam', 'course', 'duration'))->render(),
            'before' => '',
            'after' => '',
            'questions' => $exam->questions()->with('options')->get()
        ];
    
    }
    
    
    public function start($exam_id)
    {
        
        $exam = Exam::find($exam_id);
        
        if( ! $exam ) return back()->withErrors('Sorry! Requesed exam was not found.');
        
        $course = Course::find( $exam->course_id );
        
        if( ! $course ) return back()->withErrors('Course was not found in syllabus.');
        
        if( ! free_enroled($course->id) && ! premium_enroled($course->id) ) return back()->withErrors('You dont seem to be enroled into this course yet. Please enrole first.');
        
        if( $course->id < 7 )
        {
            
            return view('student.exam.f1-f4-init', compact('exam') );
            
        } else{
            
            return view('student.exam.f5-f9-init', compact('exam') );
            // return view('student.exam.f5-f9-init', compact('course', 'exam', 'questions', 'marks', 'duration') );
            
        }
        
        
    }
    
    
    public function destroy( $question_id )
    {
        
        
        if( Question::where('id', $question_id )->delete() ){
            
            return back()->withErrors('Question has been deleted');
            
        }
        
        return back()->withErrors('Failed to delete question. Please contact dev team with scenario detail.');
        
    }
    
    
    public function showHelp($course_id)
    {
        
        $course  = Course::find($course_id);
        
        return view('student.exam.show-help');
        
    }
    
    
    public function done(Request $request, $exam_id)
    {

        // return $request->all();
        
        $exam = Exam::find( $exam_id );
        
        if( ! $exam ) return 0;
        
        $attempt =  Attempt::create([
                        'name' => $exam->name,
                        'student_id' => auth()->user()->id,
                        'exam_id' => $exam_id,
                        'elapsed_second' => $request->input('elapsed_time')
                    ]);
        
        $answers = (array) $request->input('ans');

        // return $answers;
        
        $details = [];
        
        // return $answers;
        if( count( $answers ) > 0 )
        {

            $qrefs = array_map(function($a){ return $a['qref']; }, $answers);

            $options = \App\Option::whereIn('qref', $qrefs)->get();
            
            foreach($answers as $a){

                $o = $options->where('qref', $a['qref'])->first();

                $correct = $options->where('qref', $a['qref'])->where('name', $a['ans'])->where('is_correct', 1)->first();

                $marks = $correct ? $correct->marks : 0;
                
                if( $o )
                {
                    $q = $o->question;

                    $ans = [
                        'name' => $q->name,
                        'qref' => $a['qref'],
                        'qtype' => $a['qtype'],
                        'question_id' => $q->id,
                        'attempt_id' => $attempt->id,
                        'given_answer' => preg_replace('#<script(.*?)>(.*?)</script>#is', '', $a['ans']),
                        'correct_answer' => '',
                        'achieved_mark' => $marks
                    ];

                    Answer::create($ans);

                }

            }

        }
        
        $saved_answers = $attempt->answers;

        foreach( $saved_answers as $ans )
        {

            if( $ans->question->marking_type == 'full' )
            {

                $correct_ans_string = implode( $ans->question->options()->correct()->pluck('name')->toArray(), ',' );

                $given_ans_string = implode( Answer::where('attempt_id', $attempt->id)->where('question_id', $ans->question_id)->pluck('given_answer')->toArray(), ',' );

                if( $correct_ans_string != $given_ans_string )
                {

                    Answer::where('attempt_id', $attempt->id)->where('question_id', $ans->question_id)->update(['achieved_mark' => 0]);

                }

                $marks = $saved_answers->where('qref', $ans->qref)->sum('achieved_mark');

            }

        }
        // return $saved_answers;
        $total_marks = $attempt->answers()->sum('achieved_mark');
        // return $total_marks;
        $attempt->update([ 'achieved_mark' => $total_marks ]);
        // return $attempt->answers;
        return [
            'status' => 'success',
            'result_url' => action('Exams@result', $attempt->id)
        ];
        
    }
    
    
    public function result($attempt_id)
    {
        
        $attempt        = Attempt::where( 'id', $attempt_id )->where('student_id', auth()->user()->id )->first();
        $question_ids   = $attempt->answers()->groupBy('question_id')->pluck('question_id');
        $questions      = \App\Question::whereIn('id', $question_ids)->select('id', 'name', 'section','marking_type')->get();
        $exam           = $attempt->exam;
        $sections       = ['a','b','c'];
        
        // return $attempt->answers;

        return view('student.exam.result', compact('attempt','questions', 'exam', 'sections') );
        
    }
    
    
    public function instruction()
    {
        
        return view('student.exam.instruction');
        
    }
    
}