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
                    EDIT PROFILE
                </h1>
                {!! errors( $errors ) !!}
                {!! Form::open(['role'=>'form', 'class'=>'form', 'url'=>action('MyProfile@update'), 'enctype'=>'multipart/form-data']) !!}
                
                <div class="field has-addons">
                    <div class="control">
                        <span class="button is-info">First Name</span>
                    </div>
                    <div class="control">
                        {!! Form::text('firstname', auth()->user()->firstname, ['class'=>'input']) !!}
                    </div>
                </div>
                
                <div class="field has-addons">
                    <div class="control">
                        <span class="button is-info">Last Name</span>
                    </div>
                    <div class="control">
                        {!! Form::text('lastname', auth()->user()->lastname, ['class'=>'input']) !!}
                    </div>
                </div>
                
                <div class="field has-addons">
                    <div class="control">
                        <span class="button is-info">Email</span>
                    </div>
                    <div class="control">
                        {!! Form::text('email', auth()->user()->email, ['class'=> 'input']) !!}
                    </div>
                </div>
                
                <div class="field has-addons">
                    <div class="control">
                        <span class="button is-info">Contact</span>
                    </div>
                    <div class="control">
                        {!! Form::text('contact', auth()->user()->contact , ['class'=>'input']) !!}
                    </div>
                </div>
                
                <div class="field has-addons">
                    <div class="control">
                        <span class="button is-info">Country</span>
                    </div>
                    <div class="control is-expanded">
                        {!! Form::select('country', \App\Country::pluck('name', 'id'), auth()->user()->country_id , ['class'=>'select']) !!}
                    </div>
                </div>
                
                <div class="field has-addons">
                    <div class="control">
                        <span class="button is-info">Address</span>
                    </div>
                    <div class="control">
                        {!! Form::text('address', auth()->user()->address , ['class'=>'input']) !!}
                    </div>
                </div>
                
                <div class="field has-addons">
                    <div class="control">
                        <span class="button is-info">Photo</span>
                    </div>
                    <div class="control">
                        {!! Form::file('picture', ['class'=>'input']) !!}
                    </div>
                </div>

                <div class="field">
                    <div class="control">
                        {!! Form::submit('Update', ['class'=>'button is-info is-fullwidth']) !!}
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
            
        </div>
        
    </main>

</article>


@stop
