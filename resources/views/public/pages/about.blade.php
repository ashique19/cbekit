@extends('public.layouts.layout')
@section('title')
{{settings()->application_name}} - About us 
@stop

@section('meta')
    <meta name="title" content="About US">
    <meta name="description" content="About {{settings()->application_name}}">
    <meta name="keywords" content="About {{settings()->application_name}}, About">
@stop

@section('main')

<div class="box">

<section class="columns is-multiline">
    
    <div class="column is-3-desktop is-12-mobile right-border">
        <h1 class="title is-1 has-text-info font-weight-100">ABOUT US</h1>
    </div>
    
    <div class="column is-8-desktop is-12-mobile is-offset-1-desktop">
        
        <div class="content">
            <p>
                CBEKIT (Computer Based Exam Kit) is the first digital version of exam kit for ACCA powered by Signature Technologies Ltd. It is designed as an innovative solution to fulfill question practice needs in exam like platform for students. Launched in 2018, CBEKIT offers both on demand and session CBE question practice solution with some exclusive features like one to one interaction with expert tutors, unique result and personal performance dashboard, chapter-wise practice test with Mock Tests etc.
            </p>
            <p>
                We believe in a motto of “Technology leading the Change”. Our objective is to deliver excellent student experience thus make them more capable and expert in ACCA exam handling. Our Content & Quality assurance team are relentless to make content up-to-date and exam standard. Quality contents are added every day to enrich question banks for each paper.
            </p>
            <p>
                Follow us on Facebook to stay updated about our latest offers and promotions.
            </p>
            <p class="font-weight-700">
                Best of luck for your ACCA exams!
            </p>
        </div>
        
    </div>
</section>

</div>

@stop
        