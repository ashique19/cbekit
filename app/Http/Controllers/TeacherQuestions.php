<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Course;
use App\Question;
use App\Option;
use App\Exam;

class TeacherQuestions extends Controller
{

    public function index($name)
    {
        
        $course = Course::where('name', 'like', $name)->first() ?: Course::find($name);

        if( ! $course ) return back()->withErrors('Requested course was not found');
        
        $questions = $course->questions()->latest()->paginate(50);
        
        return view('teacher.questions.index', compact('course', 'questions') );
    
    }
    
    public function create($name)
    {

        $course = Course::where('name', 'like', $name)->first() ?: Course::find($name);

        if( ! $course ) return back()->withErrors('Course was not found');
    
        return view('teacher.questions.create', compact('course'));
    
    }

    public function store(Request $request, $course_name)
    {

        $course = Course::where('name', 'like', $course_name)->first() ?: Course::find($course_name);

        if( ! $course ) return 0;
        
        $detail = is_array( $request->input('detail') ) ? "" : $request->input('detail');
        $explanation = $request->input('explanation');
        
        if( is_array( $request->input('detail') ) )
        {
            
            if( $request->has('display_helper') )
            {
                
                if( $request->input('display_helper') == 'word-side-by-side' )
                {
                    
                    $detail = '
                    <div class="column is-12 columns is-multiline editor-container padding-5">
                        <div class="column is-6 editor-container white-bg black-text padding-bottom-40 padding-5 detail-1">
                
                            '.$request->input('detail')[0].'
                            
                        </div>
            
                        <div class="column is-6 editor-container white-bg black-text padding-bottom-40 padding-5 detail-2">
                    
                            '.$request->input('detail')[1].'
                            
                        </div>
                    </div>
                    ';
                    
                } elseif( $request->input('display_helper') == 'word-up-and-down' )
                {
                    
                    $detail = '
                    <div class="column is-12 columns is-multiline editor-container padding-5">
                        <div class="column is-12 editor-container white-bg black-text padding-bottom-40 padding-5 margin-bottom-20 detail-3">
                
                            '.$request->input('detail')[0].'
                            
                        </div>
            
                        <div class="column is-12 editor-container white-bg black-text padding-bottom-40 padding-5 detail-4">
                    
                            '.$request->input('detail')[1].'
                            
                        </div>
                    </div>
                    ';
                    
                } elseif( $request->input('display_helper') == 'excel-side-by-side' )
                {
                    
                    $detail = '
                    <div class="column is-12 columns is-multiline editor-container padding-5">
                        <div class="column is-12 editor-container white-bg black-text padding-bottom-40 padding-5 margin-bottom-20 detail-5">
                
                            '.$request->input('detail')[0].'
                            
                        </div>
            
                        <div class="column is-12 editor-container white-bg black-text padding-bottom-40 padding-5 detail-6">
                    
                            '.$request->input('detail')[1].'
                            
                        </div>
                    </div>
                    ';
                    
                }
                
                
                
            }
            
        }
        
        // if( ! $exam ) return 0;
        
        if( $request->input('question_id') != 0 )
        {
            
            Question::where('id', $request->input('question_id'))->delete();
            
        }
        // return $exam;
        $question = Question::create([
            'name' => $request->input('name'),
            'section' => $request->input('section'),
            'exam_detail' => $detail,
            'exam_explanation' => $explanation,
            'marking_type' => $request->input('marking_type'),
            'course_id' => $course->id
        ]);
        // return $question;
        $option_group = (array) $request->input('options');
        // return $option_group;
        $parsed_options = [];
        
        foreach( $option_group as $option )
        {

            $qref = $option['qref'];
            $correct = $option['correct'];
            
            $all_options = array_filter($option, function($v, $k) {
                                return $k != 'correct' && $k != 'qref';
                            }, ARRAY_FILTER_USE_BOTH);

            foreach($all_options as $o)
            {
                
                $parsed_options[] = [
                    'name' => $o,
                    'qref' => $qref,
                    'is_correct' => 0,
                    'marks' => 0,
                    'question_id' => $question->id,
                ];

            }

            foreach($correct as $o)
            {
                
                $parsed_options[] = [
                    'name' => $o['ans'] ?: '',
                    'qref' => $qref,
                    'is_correct' => 1,
                    'marks' => $o['mark'],
                    'question_id' => $question->id,
                ];

            }
            
        }
        
        Option::insert( $parsed_options );
        
        return is_array( $request->input('detail') ) ? back()->withErrors('Question has been saved successfully.') : 1;
        
        return 1;
    
    }

    public function show($course_id_or_name, $question_id)
    {
        
        $course = Course::where('name', 'like', $course_id_or_name)->first() ?: Course::find($course_id_or_name);

        if( ! $course ) return back()->withErrors('Requested course was not found');

        $question = $course->questions()->where([ 'id' =>$question_id])->first();
        
        return view('teacher.questions.show', compact('course', 'question') );
    
    }   

    public function edit($course_id_or_name, $question_id)
    {
        
        $course = Course::where('name', 'like', $course_id_or_name)->first() ?: Course::find($course_id_or_name);

        if( ! $course ) return back()->withErrors('Requested course was not found');

        $question = $course->questions()->where([ 'id' =>$question_id])->first();

        if( ! $question ) return back()->withErrors('Question was not found');

        $options = $question->options()->correct()->get();
        // return $options;
        return view('teacher.questions.edit', compact('course', 'question', 'options') );
    
    }   


    public function update(Request $request, $course_name, $question_id)
    {

        $course = Course::where('name', 'like', $course_name)->first() ?: Course::find($course_name);

        if( ! $course ) return 0;

        $question = Question::find($question_id);

        if( ! $question ) return 0;
        
        $detail = is_array( $request->input('detail') ) ? "" : $request->input('detail');
        $explanation = $request->input('explanation');
        
        if( is_array( $request->input('detail') ) )
        {
            
            if( $request->has('display_helper') )
            {
                
                if( $request->input('display_helper') == 'word-side-by-side' )
                {
                    
                    $detail = '
                    <div class="column is-12 columns is-multiline editor-container padding-5">
                        <div class="column is-6 editor-container white-bg black-text padding-bottom-40 padding-5 detail-1">
                
                            '.$request->input('detail')[0].'
                            
                        </div>
            
                        <div class="column is-6 editor-container white-bg black-text padding-bottom-40 padding-5 detail-2">
                    
                            '.$request->input('detail')[1].'
                            
                        </div>
                    </div>
                    ';
                    
                } elseif( $request->input('display_helper') == 'word-up-and-down' )
                {
                    
                    $detail = '
                    <div class="column is-12 columns is-multiline editor-container padding-5">
                        <div class="column is-12 editor-container white-bg black-text padding-bottom-40 padding-5 margin-bottom-20 detail-3">
                
                            '.$request->input('detail')[0].'
                            
                        </div>
            
                        <div class="column is-12 editor-container white-bg black-text padding-bottom-40 padding-5 detail-4">
                    
                            '.$request->input('detail')[1].'
                            
                        </div>
                    </div>
                    ';
                    
                } elseif( $request->input('display_helper') == 'excel-side-by-side' )
                {
                    
                    $detail = '
                    <div class="column is-12 columns is-multiline editor-container padding-5">
                        <div class="column is-12 editor-container white-bg black-text padding-bottom-40 padding-5 margin-bottom-20 detail-5">
                
                            '.$request->input('detail')[0].'
                            
                        </div>
            
                        <div class="column is-12 editor-container white-bg black-text padding-bottom-40 padding-5 detail-6">
                    
                            '.$request->input('detail')[1].'
                            
                        </div>
                    </div>
                    ';
                    
                }
                
                
                
            }
            
        }
        
        $question->options()->delete();

        $question->update([
            'name' => $request->input('name'),
            'section' => $request->input('section'),
            'exam_detail' => $detail,
            'exam_explanation' => $explanation,
        ]);
        // return $question;
        $option_group = (array) $request->input('options');
        // return $option_group;
        $parsed_options = [];
        
        foreach( $option_group as $option )
        {

            $qref = $option['qref'];
            $correct = $option['correct'];
            
            $all_options = array_filter($option, function($v, $k) {
                                return $k != 'correct' && $k != 'qref';
                            }, ARRAY_FILTER_USE_BOTH);

            foreach($all_options as $o)
            {
                
                $parsed_options[] = [
                    'name' => $o,
                    'qref' => $qref,
                    'is_correct' => 0,
                    'marks' => 0,
                    'question_id' => $question->id,
                ];

            }

            foreach($correct as $o)
            {
                
                $parsed_options[] = [
                    'name' => $o['ans'] ?: '',
                    'qref' => $qref,
                    'is_correct' => 1,
                    'marks' => $o['mark'],
                    'question_id' => $question->id,
                ];

            }
            
        }
        
        Option::insert( $parsed_options );
        
        return is_array( $request->input('detail') ) ? back()->withErrors('Question has been saved successfully.') : 1;
        
        return 1;
    
    }


    public function addToExam($question_id, $exam_id)
    {
        
        $question = Question::find( $question_id );

        $exam = Exam::find( $exam_id );

        if( ! $question || ! $exam ) return ['status' => 'failed', 'message' => 'Question or Exam was not found. Reload the page and retry.'];
        // $exam->questions()->detach($question_id);
        $exam->questions()->syncWithoutDetaching([$question_id]);
        // return $exam->questions;
        if( $exam->questions()->count() >= 50 ) return ['status' => 'failed', 'message' => 'You already reached 50 questions limit in this exam. If you want to add more questions, you need remove some first.'];
        
        return ['status' => 'success', 'message' => 'Question has been added to exam.'];
    
    }


    public function removeFromExam($question_id, $exam_id)
    {

        $question = Question::find( $question_id );

        $exam = Exam::find( $exam_id );

        if( ! $question || ! $exam ) return ['status' => 'failed', 'message' => 'Question or Exam was not found. Reload the page and retry.'];

        $exam->questions()->detach($question_id);
    
        return ['status' => 'success', 'message' => 'Question has been removed from exam.'];
    
    }


}
