<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\questionsStoreRequest;
use App\Question;
use App\Option;
use App\Exam;

class Questions extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        return view('admin.questions.index', ['questions'=> Question::latest()->paginate(40)]);
        
    }
        
    /**
     * Searches the listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function searchIndex(Request $request)
    {
    
        $search = array_filter($request->all());
        unset($search['_token']);
        
        $result	=	new Question;
      
        ($request->input('from'))  ? $result = $result->where('created_at', '>', $request->input('from').' 00:00:00') : false;
        ($request->input('to'))    ? $result = $result->where('created_at', '<', $request->input('to').' 23:59:59') : false;
    
		($request->input('id'))	?	$result = $result->where('id', $request->input('id')) : false;
		($request->input('name'))	?	$result = $result->where('name', 'like', '%'.$request->input('name').'%') : false;
		($request->input('section'))	?	$result = $result->where('section', 'like', '%'.$request->input('section').'%') : false;
		($request->input('exam_id'))	?	$result = $result->where('exam_id', $request->input('exam_id')) : false;
        
        return view('admin.questions.index', ['questions'=> $result->latest()->paginate(40)]);
        
    }
    
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        return view('admin.questions.create' );
            
    }
        
        

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(questionsStoreRequest $request)
    {
        
        
        $save_success = Question::create($request->all());
        
        
        if($save_success)
        {
        
            return back()->withErrors('Data has been stored successfully.');
        
        } else{
            
            return back()->withInput()->withErrors('Failed to store data. Please check data and retry.');
            
        }
    
    }
    
    
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    
        $question = Question::find($id); 
        // return $question;
        return view('admin.questions.edit', compact('question') );
        
    }
        
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // return $request->all();
        $exam = Exam::find( $id );
        // $marks_each_ans = $request->input('marks_each_ans');
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
        
        if( ! $exam ) return 0;
        
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
            'exam_id' => $exam->id,
            'course_id' => $exam->course_id
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
        
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        
        $question = Question::find($id);
        
        
        if($question)
        {
    
            if( $question->delete() )
            {
            
                return redirect()->action('Questions@index')->withErrors('Data has been deleted successfully.');
            
            } else{
                
                return back()->withErrors('Failed to delete data. Please retry later.');
                
            }
        
        } else{
            
            return back()->withErrors('No data was found to delete. Please refresh the page and retry.');
            
        }
        
        
    }
        
        
        
    public function explanation( $attempt_id, $question_id )
    {

        $attempt = \App\Attempt::find($attempt_id);

        $answers = $attempt ? $attempt->answers()->where('question_id', $question_id)->get() : [];

        $question = Question::find($question_id);
        // return $answers;
        $comments = \App\AnswerComment::where('attempt_id', $attempt_id)->where('question_id', $question_id)->notReply()->get();

        return view('student.question-explanation', compact('question', 'answers', 'comments', 'attempt') );
        
    }

}