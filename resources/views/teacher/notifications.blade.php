@extends('public.layouts.layout')
@section('title')Dashboard - {{ settings()->application_name }} @stop

@section('main')

<article class="columns is-multiline">

    @include('student.partials.course-nav')
    
    <main class="column is-10-desktop is-12-mobile columns is-multiline">
        <article class="column is-12-desktop is-12-mobile">
            <h1 class="title is-1 white-text">
                <span class="has-text-info">N</span>otifications
            </h1>
        </article>

        
        <article class="box column is-12-desktop is-12-mobile">
            @if( $notifications->count()  > 0 )
            @foreach( $notifications as $notification )
            <p>
                <a href="{{ $notification->link }}">{{ $notification->name }}</a>
            </p>
            @endforeach
            {!! $notifications->links() !!}
            @else
            <h3 class="subtitle is-4">You don't have any notifications yet. All your notificatons will appear here.</h3>
            @endif

        </article>

        
        
        
    </main>

</article>


@stop
        