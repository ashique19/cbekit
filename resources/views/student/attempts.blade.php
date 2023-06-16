@extends('public.layouts.layout')
@section('title')Course - {{ settings()->application_name }} @stop

@section('main')

<article class="columns is-multiline">

    @include('student.partials.course-nav')
    
    <main class="column is-10-desktop is-12-mobile">
        
        @if( $course )
        
        <h1 class="title is-1">
            <span class="has-text-info">{{ $course->name }}</span>
        </h1>
        <h2 class="subtitle is-2 white-text">{{ count( $attempts ) }} Attempts</h2>
        
        <table class="table is-bordered is-striped is-hoverable">
            <thead>
                <tr>
                    <th>Date</th>
                    <th width="100">Achieved Marks</th>
                    <th width="100">Duration</th>
                    <th width="100">Detail</th>
                </tr>
            </thead>
            <tbody>
                @if( count($attempts) > 0 )
                @foreach( $attempts as $attempt )
                <tr>
                    <td>{{ $attempt->created_at->format('Y F-d') }}</td>
                    <td>{{ $attempt->achieved_mark }}</td>
                    <td>{{ round( $attempt->elapsed_second / 60 ) }} Minutes</td>
                    <td>
                        <a href="{{ action( 'Exams@result', $attempt->id ) }}" class="button is-warning is-small">Detail</a>
                    </td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
        
        @if( count($attempts) > 0 )
        {!! $attempts->links() !!}
        @endif
        
        @endif
        
    </main>

</article>


@stop
        