@extends('public.layouts.layout')
@section('title')Course - {{ settings()->application_name }} @stop

@section('main')

<article class="columns is-multiline">

    @include('teacher.partials.course-nav')
    
    <main class="column is-10-desktop is-12-mobile columns is-multiline">

        <div class="column is-12-desktop is-12-mobile">
            
            <h1 class="title is-1">
                <span class="has-text-info"><a href="{{ action('TeacherCourses@index', $course->name) }}">{{ $course->name }}</a> > PENDING INVITES (RECEIVED)</span>
            </h1>
            <h2 class="subtitle is-2 white-text slim-gray-bottom-border">{{ $course->alter_name }}</h2>
            
            <a href="{{ action('MyStudents@inviteStudent', $course->id) }}" class="button is-info is-outlined" >
                <i class="fa fa-plus margin-right-5 font-size-18"></i>
                INVITE STUDENTS
            </a>
            
            <div class="dropdown is-hoverable">
                <div class="dropdown-trigger">
                    <button class="button is-success is-outlined" aria-haspopup="true" aria-controls="dropdown-menu4">
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

            <h4 class="subtitle is-4">Pending invites (Received)</h4>
            @if( $invitations->count() > 0 )
            <table class="table is-bordered">
                <tbody>
                    @foreach( $invitations as $invitation )
                    <tr>
                        <td>{{ $invitation->student->name }}</td>
                        <td>
                            <a href="" class="button is-small is-outlined is-danger">
                                <i class="fa fa-trash-o"></i> &nbsp; Remove invite
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {!! $invitations->links() !!}
            @else
            <h2 class="subtitle is-3">You don't have any pending invitaions in this list.
            
            @endif
        </div>

        
        
    </main>

</article>


@stop
        