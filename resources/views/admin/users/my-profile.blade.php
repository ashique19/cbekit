@extends('public.layouts.layout')
@section('title')Dashboard - {{ settings()->application_name }} @stop

@section('main')

<article class="columns is-multiline">

    @include('student.partials.course-nav')
    
    <main class="column is-10-desktop is-12-mobile columns is-multiline">
        
        <div class="column is-4-desktop is-12-mobile">
                                    
            <div class="panel panel-default">
                <div class="panel-body profile profile-bg" >
                    <div class="profile-image">
                        <img src="{{auth()->user()->user_photo}}" alt="{{auth()->user()->name}}">
                    </div>
                    <div class="profile-data">
                        <div class="profile-data-name">{{auth()->user()->name}}</div>
                        <div class="profile-data-title" style="color: #FFF;">{{auth()->user()->roles->name}}</div>
                    </div>
                </div>        
                <div class="panel-body list-group border-bottom">
                    <a href="{{action('MyProfile@show')}}" class="list-group-item"><span class="fa fa-bar-chart-o"></span> My Profile</a>
                    <a href="{{action('MyProfile@changePassword')}}" class="list-group-item"><span class="fa fa-coffee"></span> Change Password</a>                                
                    <a href="#" class="list-group-item mb-control" data-box="#mb-signout"><span class="fa fa-sign-out"></span> Logout</a>
                </div>
            </div>                            
            
        </div>
        
        <div class="column is-8-desktop is-12-mobile">
            
            <div class="box">
                <h1 class="title is-1">
                    MY PROFILE
                </h1>
                {!! errors( $errors ) !!}
                
                <p>Name: {{auth()->user()->name}}</p>
                <p>Email: {{auth()->user()->email}}</p> 
                <p>User type: {{auth()->user()->roles ? auth()->user()->roles->name : ""}}</p>
                <p>Contact: {{auth()->user()->contact}}</p>
                <p>Address: {{auth()->user()->address}}</p>
                <p>Country: {{auth()->user()->country ? auth()->user()->country->name : ""}}</p>
                <p class="margin-top-40"><a href="{{action('MyProfile@edit')}}" class="button is-info">Edit</a> <a href="{{action('MyProfile@changePassword')}}" class="button is-info">Change Password</a></p>
                
            </div>
            
        </div>
        
    </main>

</article>


@stop