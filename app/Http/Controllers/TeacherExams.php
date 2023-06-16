<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Course;
use App\User;
use App\Question;

class TeacherExams extends Controller
{
    
    public function studentAttempts($course_id, $student_id)
    {
        
        $course = Course::find( $course_id );
        
        $student = User::students()->where('id', $student_id)->first();
        
        if( ! $course || ! $student ) return back()->withErrors('Course or Student was not found');
        
        $exams = $course->exams()->pluck('exams.id');
        
        $attempts = $exams ? \App\Attempt::wherein('exam_id', $exams)->where('student_id', $student_id)->paginate(30) : [];
        // return $attempts;
        return view('teacher.student-attempts', compact('student', 'course', 'attempts') );
        
    }

    public function studentAttemptDetail($attempt_id)
    {
        
        $attempt = \App\Attempt::find($attempt_id);

        $student = $attempt ? $attempt->student : [];
        
        $question_ids =  $attempt->answers()->groupBy('question_id')->pluck('question_id');
        
        $questions = \App\Question::whereIn('id', $question_ids)->select('id', 'name', 'section')->get();
        
        $exam = $attempt->exam;
        // return $attempt;
        return view('teacher.exam-result', compact('attempt','questions', 'exam', 'student') );
    
    }

    public function explanation( $attempt_id, $question_id )
    {

        $attempt = \App\Attempt::find($attempt_id);

        $answers = $attempt ? $attempt->answers()->where('question_id', $question_id)->get() : [];

        $question = Question::find($question_id);

        // $comments = $attempt->comments()->notReply()-get();

        $comments = \App\AnswerComment::where('attempt_id', $attempt_id)->where('question_id', $question_id)->notReply()->get();
        // return $comments;
        return view('teacher.question-explanation', compact('question', 'answers', 'attempt', 'comments') );
        
    }


    public function updateMark(Request $request, $answer_id)
    {

        $this->validate($request,[ 'mark' => 'required|integer' ]);

        $given_answer = \App\Answer::find($answer_id);
        
        if( ! $given_answer ) return back()->withErrors('Requested answer was not found');

        $correct_answer = \App\Option::where('qref', $given_answer->qref)->where('is_correct', 1)->first();

        if( ! $correct_answer ) return back()->withErrors('Reference answer was not found');
        
        if( $request->input('mark') > $correct_answer->marks ) return back()->withErrors('Please award a mark no more that question\'s mark');

        $given_answer->update(['achieved_mark' => $request->input('mark')]);

        
        return back()->withErrors('mark has been updated successfully.');
    
    }


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
