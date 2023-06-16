<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Course;
use App\User;
use App\Question;

class StudentExams extends Controller
{

    public function comment(Request $request, $attempt_id, $question_id)
    {
    
        $comment = \App\AnswerComment::create([
            'name' => $request->input('comment'),
            'attempt_id' => $attempt_id,
            'question_id' => $question_id,
            'is_reply' => $request->input('is_reply'),
            'answer_comment_id' => $request->has('comment_id') ? $request->input('comment_id') : null
        ]);

        if( $comment ) return back()->withErrors('Comment has been saved.');

        return back()->withErrors('Failed to save comment.');
    
    }

}
