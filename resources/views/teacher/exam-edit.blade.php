@extends('public.layouts.layout')

@section('css')
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.css" type="text/css" />
<style>
[qref]:hover, [expand-handle]:hover{
    -webkit-box-shadow: 0px 0px 2px 2px rgba(0,0,0,0.75);
    -moz-box-shadow: 0px 0px 2px 2px rgba(0,0,0,0.75);
    box-shadow: 0px 0px 2px 2px rgba(0,0,0,0.75);
}
</style>
@stop

@section('js')
<script type="text/javascript" src="/public/js/jquery-ui.min.js" ></script>

@stop

@section('title')Exam - {{ settings()->application_name }} @stop

@section('main')

<article class="columns is-multiline">

    @include('teacher.partials.course-nav')
    
    <main class="column is-10-desktop is-12-mobile columns is-multiline flex-align-start">
        
        <div class="column is-12-desktop is-12-mobile padding-left-0 padding-right-0 margin-bottom-10">
            <h1 class="title is-1 has-text-info slim-gray-bottom-border ">
                Exam ( {{ $course->name }} )
            </h1>
            
            {!! Form::open(['url'=> action('Exams@update', $exam->id), 'method'=> 'PATCH', 'class'=> 'column is-12 columns is-multiline blackish-bg margin-5 padding-left-0 padding-right-0']) !!}
            
            <div class="column is-12 padding-top-0 padding-bottom-0 padding-left-20">
                <span class="font-weight-600 white-text">EDIT / <a href="{{ action('TeacherCourses@index', $course->name) }}" class="link has-text-warning">back to exams</a></span>
            </div>
            
            <div class="column is-3-desktop is-12-mobile">
                <div class="field is-horizontal">
                    <div class="field-label">
                        <label class="label white-text margin-top-5">Name</label>
                    </div>
                    <div class="field-body">
                        <div class="field">
                            <div class="control">
                                <input class="input" type="text" name="name" placeholder="Name the exam" value="{{ $exam->name }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="column is-3-desktop is-12-mobile">
                <div class="field is-horizontal">
                    <div class="field-label">
                        <label class="label white-text margin-top-5">Duration (min)</label>
                    </div>
                    <div class="field-body">
                        <div class="field">
                            <div class="control">
                                <input class="input" type="text" name="exam_duration_minutes" placeholder="Duration (Minutes)" value="{{ $exam->exam_duration_minutes }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="column is-4-desktop is-12-mobile">
                <div class="field is-horizontal">
                    <div class="field-body">
                        <div class="field">
                            <div class="control">
                                <label class="checkbox  padding-left-20">
                                    <input type="checkbox" value="1" name="is_free" @if($exam->is_free == 1) checked @endif />
                                    Free
                                </label>
                            </div>
                        </div>
                        <div class="field">
                            <div class="control">
                                <label class="checkbox">
                                    <input type="checkbox" value="1" name="is_premium" @if($exam->is_premium == 1) checked @endif />
                                    Premium
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="column is-2-desktop is-12-mobile">
                <div class="field is-horizontal">
                    <div class="field-body">
                        <div class="field">
                            <div class="control">
                                <button class="button is-info" type="submit" >Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            {!! Form::close() !!}
            
        </div>

        <div class="column is-12-desktop is-12-mobile box">
            <h4 class="subtitle is-4">How it works</h4>
            <p>
                <b>"Questions in this exam" -</b> is the list of questions which will be visible to students during exam session.
                <br>
                - You can add up to 50 questions to one exam session.
                <br>
                - Click the right arrow to remove a question from this exam session.
                <br>
                - Removing a question from exam means, the question is sent back to "Question bank". Removing a question from exam wont delete the question itself.
            </p>
            <p class="margin-top-20">
                <b>"Question bank" -</b> is the list of all published questions for this course.
                <br>
                - Click the left arrow to add a question to this exam session.
            </p>
        </div>

        <div class="column is-6-desktop is-12-mobile flex-align-start">
            <h4 class="subtitle is-4">Questions in this exam</h4>
            <table class="table is-bordered" id="exam-question-list">
                <tbody>
                    @if($exam_questions->count() > 0)
                    @foreach( $exam_questions as $q )
                    <tr>
                        <td><a href="{{ action('TeacherQuestions@show',[$course->id, $q->q_id]) }}" target="_blank">{{ $q->name }}</a></td>
                        <td>{{ $q->section }}</td>
                        <td>
                            <button class="button is-small is-success" add-target="{{ action('TeacherQuestions@addToExam', [$q->q_id, $exam->id]) }}" remove-target="{{ action('TeacherQuestions@removeFromExam', [$q->q_id, $exam->id]) }}" data-toggle="tooltip" data-placement="right" title="Remove this question from exam">
                                <i class="fa fa-angle-right font-size-12"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>
        
        <div class="column is-6-desktop is-12-mobile flex-align-start">
            <h4 class="subtitle is-4">Questions bank</h4>
            <table class="table is-bordered" id="all-question-list">
                <tbody>
                    @if($course_questions->count() > 0)
                    @foreach( $course_questions as $q )
                    <tr>
                        <td>
                            <button class="button is-small is-success"  add-target="{{ action('TeacherQuestions@addToExam', [$q->id, $exam->id]) }}" remove-target="{{ action('TeacherQuestions@removeFromExam', [$q->id, $exam->id]) }}" data-toggle="tooltip" data-placement="right" title="Add this question to exam">
                                <i class="fa fa-angle-left font-size-12"></i>
                            </button>
                        </td>
                        <td><a href="{{ action('TeacherQuestions@show',[$course->id, $q->id]) }}" target="_blank">{{ $q->name }}</a></td>
                        <td>{{ $q->section }}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <td colspan="3">{!! $course_questions->links() !!}</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
        
    </main>
    
</article>

@section('bodyScope')

<div class="modal" id="message-modal">
    <div class="modal-background"></div>
    <div class="modal-content">
        <section class="box">

        </section>
    </div>
    <button class="modal-close is-large" aria-label="close" data-dismiss="modal"></button>
</div>

<script>
$(document).ready(function(){

    $(document).on('click', '#all-question-list button', function(e){
        e.preventDefault();
        let button = $(this),
            target = button.attr('add-target'),
            modal  = $('#message-modal'),
            msg_box = $('#message-modal .box');

        msg_box.empty();

        button.addClass('is-loading');

        $.get(target, function(data){
            if( data.status == 'success' ){

                let add_target = button.attr('add-target'),
                    remove_target = button.attr('remove-target'),
                    name = button.parents('tr').find('td:eq(1)').text(),
                    section = button.parents('tr').find('td:eq(2)').text(),
                    href = button.parents('tr').find('a').attr('href');

                let tr = `
                <tr>
                    <td><a href="${href}" target="_blank">${name}</a></td>
                    <td>${section}</td>
                    <td>
                        <button class="button is-small is-success" add-target="${add_target}" remove-target="${remove_target}" data-toggle="tooltip" data-placement="right" title="Remove this question from exam">
                            <i class="fa fa-angle-right font-size-12"></i>
                        </button>
                    </td>
                </tr>
                `;
                button.parents('tr').remove();
                $('#exam-question-list tbody').append(tr);

            } else{
                modal.modal('show');
                msg_box.html(`<p class="red-text">${data.message}</p>`);
            }
            button.removeClass('is-loading');
        }).fail(function(){
            modal.modal('show');
            msg_box.html(`<p class="red-text">Failed to process request. Please contact support if issue persists.</p>`);
            button.removeClass('is-loading');
        });
    })
    
    $(document).on('click', '#exam-question-list button', function(e){
        e.preventDefault();
        let button = $(this),
            target = button.attr('remove-target'),
            modal  = $('#message-modal'),
            msg_box = $('#message-modal .box');

        msg_box.empty();

        button.addClass('is-loading');

        $.get(target, function(data){
            if( data.status == 'success' ){

                button.removeClass('is-loading');

                let add_target = button.attr('add-target'),
                    remove_target = button.attr('remove-target'),
                    name = button.parents('tr').find('td:eq(0)').text(),
                    section = button.parents('tr').find('td:eq(1)').text(),
                    href = button.parents('tr').find('a').attr('href');

                let tr = `
                <tr>
                    <td>
                        <button class="button is-small is-success" add-target="${add_target}" remove-target="${remove_target}" data-toggle="tooltip" data-placement="right" title="Remove this question from exam">
                            <i class="fa fa-angle-left font-size-12"></i>
                        </button>
                    </td>
                    <td><a href="${href}" target="_blank">${name}</a></td>
                    <td>${section}</td>
                </tr>
                `;

                button.parents('tr').remove();
                $('#all-question-list tbody').prepend(tr);

            } else{
                modal.modal('show');
                msg_box.html(`<p class="red-text">${data.message}</p>`);
            }
            button.removeClass('is-loading');
        }).fail(function(){
            modal.modal('show');
            msg_box.html(`<p class="red-text">Failed to process request. Please contact support if issue persists.</p>`);
            button.removeClass('is-loading');
        });
    })

})
</script>


    
@stop



@stop
        