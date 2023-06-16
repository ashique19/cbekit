@extends('public.layouts.layout')
@section('title')Course - {{ settings()->application_name }} @stop

@section('prefetch')
<link rel="prefetch" href="/public/css/jquery-ui.min.css" >
<link rel="prefetch" href="//code.jquery.com/ui/1.12.1/jquery-ui.js" >
<link rel="prefetch" href="//cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.css" >
<link rel="prefetch" href="/public/css/jquery-ui.min.css" >
<link rel="prefetch" href="//cdnjs.cloudflare.com/ajax/libs/tinymce/4.8.3/skins/lightgray/content.min.css" >
<link rel="prefetch" href="/public/css/jquery-nightowl-1.2.css" >
<link rel="prefetch" href="/public/js/jquery-ui.min.js" >
<link rel="prefetch" href="/public/js/jquery-nightowl-1.2.js" >
<link rel="prefetch" href="/public/js/tinymce.min.js" >
<link rel="prefetch" href="/public/js/spreadsheet.js" >
<link rel="prefetch" href="/public/js/excel.js" >
<link rel="prefetch" href="//cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote.min.js" >
@stop

@section('main')

<article class="columns is-multiline">

    @include('student.partials.course-nav')
    
    <main class="column is-10-desktop is-12-mobile">
        
        @if( $course )
        
        <h1 class="title is-1 has-text-info">
            {{ $course->name }}
        </h1>
        <h2 class="subtitle is-2 white-text">
            {{ $course->alter_name }}
            <a href="{{ action('StudentCourses@index', $course->name) }}" class="button is-small is-pulled-right is-default">Back to Course Detail</a>
        </h2>
        
        @if( count( $exams ) > 0 )
        
        <table class="table is-bordered is-striped is-hoverable is-fullwidth">
            <thead>
                <tr>
                    <th>Name</th>
                    <th width="150">Free/Premium</th>
                    <th width="150">Last Updated</th>
                    <th width="150">Start</th>
                    <th width="150">Results</th>
                </tr>
            </thead>
            <tbody>
                @foreach( $exams as $exam )
                <tr>
                    <td>{{ $exam->name }}</td>
                    <td>{{ $exam->is_free == 1 ? 'Free' : ( $exam->is_premium == 1 ? 'Premium' : '' ) }}</td>
                    <td>{{ $exam->updated_at->format('Y-M-d') }}</td>
                    <td>
                        @if( $exam->is_free == 1 )
                        <a href="{{ action('Exams@start', $exam->id) }}" class="button is-primary is-outlined">Start Exam</a>
                        @elseif( $exam->is_premium == 1 && premium_enroled( $course->id ) )
                        <a href="{{ action('Exams@start', $exam->id) }}" class="button is-primary is-outlined">Start Exam</a>
                        @endif
                    </td>
                    <td>
                        <a href="{{ action('StudentCourses@attempts', $exam->id) }}" class="button is-success is-outlined">{{ $exam->attempts()->where('student_id', auth()->user()->id )->count() }} Attempts</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        @else
        
        <h3 class="subtitle is-4">
            Sorry, There are no active exams for this course yet. Come again soon for update.
        </h3>
        
        @endif
        
        <!--<div class="buttons">-->
            
        <!--    <a href="{{ action('Exams@start', $course->id) }}" class="button is-large white-bg red-text">Start Exam</a>-->
            
        <!--</div>-->
        
        @endif
        
    </main>

</article>


@stop
        