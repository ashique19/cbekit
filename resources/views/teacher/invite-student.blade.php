@extends('public.layouts.layout')
@section('title')Course - {{ settings()->application_name }} @stop

@section('main')

<article class="columns is-multiline">

    @include('teacher.partials.course-nav')
    
    <main class="column is-10-desktop is-12-mobile columns is-multiline">

        <div class="column is-12-desktop is-12-mobile">
            
            <h1 class="title is-1">
                <span class="has-text-info"><a href="{{ action('TeacherCourses@index', $course->name) }}">{{ $course->name }}</a> > Invite Students</span>
            </h1>
            <h2 class="subtitle is-2 white-text slim-gray-bottom-border">{{ $course->alter_name }}</h2>
            
            <a href="{{ action('MyStudents@course', $course->id) }}" class="button is-info is-small is-outlined is-pulled-right" >
                <i class="fa fa-angle-left margin-right-5 font-size-18"></i>
                My Students
            </a>
            <div class="dropdown is-hoverable">
                <div class="dropdown-trigger">
                    <button class="button is-success is-outlined is-small" aria-haspopup="true" aria-controls="dropdown-menu4">
                        <span>PENDING INVITES</span>
                        <span class="icon is-small">
                            <i class="fa fa-angle-down" aria-hidden="true"></i>
                        </span>
                    </button>
                </div>
                <div class="dropdown-menu" id="dropdown-menu4" role="menu">
                    <div class="dropdown-content">
                    <a href="{{ action('MyStudents@pendingInvitesSent', $course->id) }}" class="dropdown-item">
                        Sent
                    </a>
                    <hr class="dropdown-divider">
                    <a href="{{ action('MyStudents@pendingInvitesReceived', $course->id) }}" class="dropdown-item">
                        Received
                    </a>
                    </div>
                </div>
            </div>

        </div>

        <div class="column is-12-desktop is-12-mobile">
            <h4 class="subtitle is-4">Search for student:</h4>
            {!! Form::open(['url'=> action('MyStudents@postInviteStudent', $course->id), 'method'=>'POST' ]) !!}
            
            <div class="field has-addons">
                <div class="control">
                    <input class="input" type="text" name="email" placeholder="Enter Student Email">
                </div>
                <div class="control">
                    <button type="submit" class="button is-info">
                    Search
                    </button>
                </div>
            </div>

            {!! Form::close() !!}

            {!! errors($errors) !!}

            @if($student)
            <div class="box margin-top-20">
                <p>
                    Name: {{ $student->name }}
                    <br>
                    Email: {{ $student->email }}
                </p>
                <p>
                    <a href="{{ action('MyStudents@addStudent', [$course->id, $student->id] ) }}" class="button is-info">Invite</a>
                </p>
            </div>
            @endif

            <ul class="margin-top-20">
                <li>*** Only CBEKIT registered students will appear in search result.</li>
            </ul>
        </div>

        
        
    </main>

</article>


@stop
        