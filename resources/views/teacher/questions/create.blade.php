@extends('public.layouts.layout')

@section('css')
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.css" type="text/css" />
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/tinymce/4.8.3/skins/lightgray/content.min.css">
<link rel="stylesheet" href="/public/css/jquery-nightowl-1.2.css">

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

<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.min.js"></script>
<script src="/public/js/jquery-nightowl-1.2.js"></script>
<script src="/public/js/tinymce.min.js"></script>
<script type="text/javascript" src="/public/js/exam-question-entry.js" ></script>


@stop

@section('title')Exam - {{ settings()->application_name }} @stop

@section('main')

<article class="columns is-multiline">

    @include('teacher.partials.course-nav')
    
    <main class="column is-10-desktop is-12-mobile columns is-multiline flex-align-start">
        

        {!! Form::open([ 'url'=> action('TeacherQuestions@store', $course->name), 'method'=> 'POST', 'class'=> 'column is-12-desktop is-12-mobile padding-0 columns is-multiline add-question', 'q_id' => \App\Question::count() ]) !!}
        
        <div class="column is-12-desktop is-12-mobile text-right padding-right-0 margin-left-10 padding-left-0 margin-top-40">
            <h3 class="text-left subtitle is-2 white-text">Create Question</h3>
            <p class="message red-text"></p>
        </div>
        
        <div class="column is-3-desktop is-12-mobile padding-0 margin-left-10 margin-bottom-10">
            <div class="box">
                <h4 class="font-weight-600 subtitle is-6">Section</h4>
                <button class="button is-small">
                    <input required type="radio" name="section" value="a">
                    &nbsp; A
                </button>
                <button class="button is-small">
                    <input required type="radio" name="section" value="b" >
                    &nbsp; B (Single Part)
                </button>
                <button type="button" class="is-small button" data-toggle="modal" data-target="#multipart">
                    Multi Part (Section B,C)
                </button>
            </div>
        </div>

        <div class="column is-4-desktop is-12-mobile margin-left-10 padding-0 margin-bottom-10">
            <div class="box">
                <p>
                    <h4 class="font-weight-600 subtitle is-6">Marking type</h4>
                </p>
                <p>
                    <label for="marks">
                        <input type="radio" name="marking" value="partial" > 
                        <span class="font-weight-100">Partial</span> 
                        <a href="#" data-toggle="modal" data-target="#marking-detail-modal" class="tag is-link font-weight-100">
                            <i class="fa fa-question-circle font-size-12"></i> &nbsp; learn more 
                        </a>
                    </label>
                </p>
                <p>
                    <label for="marks">
                        <input type="radio" name="marking" value="full" checked> 
                        <span class="font-weight-100">Full or None</span> 
                        <a href="#" data-toggle="modal" data-target="#marking-detail-modal" class="tag is-link font-weight-100">
                            <i class="fa fa-question-circle font-size-12"></i> &nbsp; learn more
                        </a>
                    </label>
                </p>
            </div>
        </div>
        
        <div class="column is-4-desktop is-12-mobile margin-left-10 padding-0 margin-bottom-10">
            <div class="box">
                <p>
                    <input name="name" value="" class="input is-primary is-small" type="text" placeholder="Name of the question" required>
                </p>
                <p class="margin-top-5">
                    <label for="marks" class="total-marks button is-small is-fullwidth">Marks:</label>
                </p>
                <button class="button is-info is-fullwidth" type="submit">Save Question</button>
            </div>
        </div>
        
        <div class="column is-12 editor-container white-bg black-text margin-left-10 padding-bottom-40 margin-right-10">
            
            <textarea name="detail" class="textarea air" placeholder="Question block" rows="10"  ></textarea>
            
        </div>
    
        <div class="column is-12 offwhite-bg black-text margin-left-10 padding-bottom-40 margin-right-10 margin-top-30">
            
            <textarea name="explanation" class="textarea summernote" placeholder="Question Explanation" rows="10" ></textarea>
            
        </div>
    
        <div class="column is-12-desktop is-12-mobile margin-top-30 has-text-centered margin-bottom-30">
            
            <!-- <button class="button is-large is-info" type="submit">Save Question</button> -->
            
        </div>
        
        {!! Form::close() !!}
        
    </main>
    
</article>

@section('bodyScope')

    
    @include('teacher.partials.question-entry-multipart-B-modal')

    <div class="modal fade bs-example-modal-sm" id="q-options" tabindex="-1" role="dialog" style="z-index: 1043;">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content width-100-percent padding-20">
                <section class="columns is-multiline">
                    
                        <div class="column is-12-desktop is-12-mobile padding-30" id="marker-container">
                                
                            <div class="field has-addons" data-toggle="tooltip" data-title="Enter digits only">
                                <p class="button">
                                    Target: <span id="mark-target"></span>
                                </p>
                                <p class="control">
                                    <input class="input" type="text" placeholder="Mark" id="mark-input">
                                </p>
                                <p class="control">
                                    <button type="button" class="button" id="update-mark">
                                    Update
                                    </button>
                                </p>
                            </div>

                        </div>

                </section>
            </div>
        </div>
    </div>

    <div class="modal fade bs-example-modal-sm" id="marking-detail-modal" tabindex="-1" role="dialog" style="z-index: 1043;">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content width-100-percent padding-20">
                <section class="columns is-multiline">
                    
                        <div class="column is-12-desktop is-12-mobile padding-30">
                                
                            <h4 class="subtitle is-4">What is marking type ?</h4>

                            <p>Here you can mention if you want allow <b>partial</b> or <b>full</b> marking.</p>
                            <br>

                            <p>
                                <b>What is partial marking?</b>
                                <br>
                                Partial marking is when you award mark for a partially correct answer. 
                                For example, think of multiple choice question where there are 2 correct choices.
                                In partial marking, Student will earn some mark even if they choose one correct option.
                            </p>
                            <br>

                            <p>
                                <b>What is full marking?</b>
                                <br>
                                Full marking is when you award mark if all correct answers are choosen.
                                For example, think for a multiple choice question where there are 2 correct choices.
                                In full marking, student will earn mark only if they choose both correct choices. Student wont be awarded any mark if they choose 1 correct answer only.
                            </p>

                        </div>

                </section>
            </div>
        </div>
    </div>
    
@stop



@stop
        