@extends('public.layouts.layout')
@section('title')Dashboard - {{ settings()->application_name }} @stop

@section('main')

<article class="columns is-multiline">

    @include('student.partials.course-nav')
    
    <main class="column is-10-desktop is-12-mobile columns is-multiline">
        <article class="column is-12-desktop is-12-mobile">
            <h1 class="title is-1 white-text">
                <span class="has-text-info">I</span>nvitations
            </h1>
        </article>

        
        <article class="box column is-12-desktop is-12-mobile">
            @if( $invitations->count()  > 0 )
            <table class="table is-bordered is-striped">
                <thead>
                    <tr>
                        <th>From</th>
                        <th>Course</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                @foreach( $invitations as $invitation )
                <tr>
                    <td>{{ $invitation->teacher ? $invitation->teacher->name : '' }}</td>
                    <td>{{ $invitation->course ? $invitation->course->name : '' }}</td>
                    <td>
                        @if( $invitation->is_accepted == 1 )
                        Accepted
                        @endif
                        @if( $invitation->is_accepted == 0 )
                        <a href="{{ action('Students@acceptInvitation', $invitation->id) }}" class="button is-small is-success is-outlined">Accept</a>
                        <a href="{{ action('Students@deleteInvitation', $invitation->id) }}" class="button is-small is-success is-outlined">Delete</a>
                        @endif
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
            {!! $invitations->links() !!}
            @else
            <h3 class="subtitle is-4">You don't have any invitations yet. Invitation from teachers will appear here.</h3>
            @endif

        </article>

        
        
        
    </main>

</article>


@stop
        