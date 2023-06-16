@extends('public.layouts.layout')
@section('title')Course - {{ settings()->application_name }} @stop

@section('main')

<article class="columns is-multiline">

    @include('teacher.partials.course-nav')
    
    <main class="column is-10-desktop is-12-mobile columns is-multiline">

        <div class="column is-12-desktop is-12-mobile">
            
            <h1 class="title is-1">
                <span class="has-text-info">{{ $course->name }}</span>
            </h1>
            <h2 class="subtitle is-2 white-text slim-gray-bottom-border">{{ $course->alter_name }}</h2>
            <p class="small red-text slim-gray-bottom-border">
                <a href="{{ action('TeacherCourses@exams', $course->name) }}" class="button is-small is-info is-outlined"><b class="black-text">E</b>xams</a>
                <a href="{{ action('TeacherCourses@students', $course->name) }}" class="button is-small is-info is-outlined"><b class="black-text">S</b>tudents</a>
                <a href="{{ action('TeacherQuestions@create', $course->name) }}" class="pull-right button is-offwhite is-small">Create &nbsp; <span class="blue-text">Question</span> </a>
            </p>

        </div>

        <div class="column is-12-desktop is-12-mobile padding-bottom-40 padding-top-40">
            
            <h4 class="subtitle is-2">Questions ({!! $questions->total() !!})</h4>
            <table class="table is-bordered is-stripped">
                @if( count( $questions ) > 0 )
                @foreach( $questions as $q )
                <tr>
                    <td>{{ $q->name }}</td>
                    <td>@if( $q->options()->count() > 0 ){{ $q->options()->sum('marks') }} Marks @endif</td>
                    <td>
                        <a href="{{ action('TeacherQuestions@show',[$course->name, $q->id]) }}" class="button is-success is-outlined is-small">
                            <span class="icon is-small">
                            <i class="fa fa-expand"></i>
                            </span>
                            <span>Preview</span>
                        </a>
                    </td>
                    <td>
                        <a href="{{ action('TeacherQuestions@edit',[$course->name, $q->id]) }}" class="button is-dark is-outlined is-small">
                            <span class="icon is-small">
                            <i class="fa fa-edit"></i>
                            </span>
                            <span>Edit</span>
                        </a>
                    </td>
                    <td>
                        {!! Form::open(['url'=> action('Exams@destroy', $q->id), 'method'=> 'DELETE']) !!}
                        <button type="submit" class="button is-danger is-outlined is-small">
                            <span class="icon is-small">
                            <i class="fa fa-trash-o"></i>
                            </span>
                            <span>Delete</span>
                        </button>
                        {!! Form::close() !!}
                    </td>
                </tr>
                @endforeach
                @endif
            </table>
            <div class="section black-text">
                {!! $questions->links() !!}
            </div>
        </div>
        
        
    </main>

</article>

@stop
        