@extends('public.layouts.layout')
@section('title')Dashboard - {{ settings()->application_name }} @stop

@section('main')

<article class="columns is-multiline">

    @include('teacher.partials.course-nav')
    
    <main class="column is-10-desktop is-12-mobile">
        
        <h1 class="title is-1">
            <span class="has-text-info">C</span>omputer
            <span class="has-text-info">B</span>ased
            <span class="has-text-info">E</span>xam
            <span class="is-pulled-right tag has-text-info">Teachers Panel</span>
        </h1>
        <h2 class="subtitle is-4 has-text-uppercase">
            <span class="black-text">on ACCA syllabus</span>
        </h2>
        
        <div class="box transparent-bg">
            <h4 class="subtitle is-4 black-text">{{ settings()->application_name }} is proud to have you as a teacher. <br>We follow your responsible foot steps.</h4>
        </div>
        
        
    </main>

</article>


@stop
        