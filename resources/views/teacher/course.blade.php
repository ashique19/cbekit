@extends('public.layouts.layout')
@section('title')Course - {{ settings()->application_name }} @stop

@section('main')

<article class="columns is-multiline">

    @include('teacher.partials.course-nav')
    
    <main class="column is-10-desktop is-12-mobile">
        
        <h1 class="title is-1">
            <span class="has-text-info">{{ $course->name }}</span>
        </h1>
        <h2 class="subtitle is-2 white-text slim-gray-bottom-border">{{ $course->alter_name }}</h2>
        
        <div class="tile is-ancestor">
            <div class="tile is-3">
                <a href="{{ action('TeacherCourses@exams', $course->id) }}" class="thumbnail padding-20">
                    <p>
                        <span class="font-size-52 blue-text">E</span>XAM SESSION
                    </p>
                    <p><hr class="margin-top-10 margin-bottom-15"></p>
                    <p class="small">
                        Create or Edit
                    </p>
                </a>
            </div>
            <div class="tile is-3">
                <a href="{{ action('MyStudents@course', $course->id) }}" target="_blank" class="thumbnail padding-20">
                    <p>
                        <span class="font-size-52 blue-text">S</span>TUDENTS
                    </p>
                    <p><hr class="margin-top-10 margin-bottom-15"></p>
                    <p class="small">
                        Add new / see Existing
                    </p>
                </a>
            </div>
            <div class="tile is-3">
                <a href="{{ action('TeacherCourses@students', $course->id) }}" target="_blank" class="thumbnail padding-20">
                    <p>
                        <span class="font-size-52 blue-text">R</span>ESULTS
                    </p>
                    <p><hr class="margin-top-10 margin-bottom-15"></p>
                    <p class="small">
                        From all students attempts
                    </p>
                </a>
            </div>
            <div class="tile is-3">
                <a href="{{ action('TeacherQuestions@index', $course->name) }}" target="_blank" class="thumbnail padding-20">
                    <p>
                        <span class="font-size-52 blue-text">Q</span>UESTIONS
                    </p>
                    <p><hr class="margin-top-10 margin-bottom-15"></p>
                    <p class="small">
                        Add new or See existing
                    </p>
                </a>
            </div>
        </div>
        
    </main>

</article>

@stop
        