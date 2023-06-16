@extends('public.layouts.layout')
@section('title')Login to {{ settings()->application_name }} @stop
@section('main')

<section class="box margin-top-30 transparent-bg is-shadowless">

<section class="columns is-multiline">

    <div class="column is-4-desktop is-12-mobile is-offset-4-desktop blackish-bg padding-10">
        
        
        <!--<a href="{{action('AccessController@social', 'facebook')}}" class="button is-fullwidth is-info is-outlined margin-bottom-5">-->
        <!--    Log in with Facebook-->
        <!--</a>-->
        
        <!--<a href="{{action('AccessController@social', 'google')}}" class="button is-fullwidth is-info is-outlined margin-bottom-5">-->
        <!--    Log in with Google-->
        <!--</a>-->
        
        <p class="text-center margin-bottom-10 margin-top-10 has-text-white">LOG IN</p>
        
        {!! Form::open(['url'=> action('AccessController@postLogin') ]) !!}
        
        <div class="column is-12 padding-0">
            {!! errors($errors) !!}
        </div>
        
        <div class="column is-12 padding-0 margin-top-5 margin-bottom-5">
            <div class="field has-addons">
                <div class="control">
                    <a class="button is-info">
                    Login ID
                    </a>
                </div>
                <div class="control is-expanded">
                    <input class="input is-info" type="text" placeholder="your username or email" min="5" name="username_or_email" value="{{old('username_or_email')}}" autofocus required />
                </div>
            </div>    
        </div>        
        
        <div class="column is-12 padding-0 margin-bottom-5">
            <div class="field has-addons">
                <div class="control">
                    <a class="button is-info">
                    Password
                    </a>
                </div>
                <div class="control is-expanded">
                    <input class="input is-info" type="password" placeholder="enter password" min="5" name="password" required />
                </div>
            </div>    
        </div>        
        
        
        
        <div class="column is-12 padding-0 margin-bottom-5">
            {!! Form::submit('Log in', ['class'=> 'button is-fullwidth is-white is-outlined']) !!}
        </div>
        
        {!! Form::close() !!}
        
        
        <div class="column is-12 padding-0 margin-bottom-5">
            
            <p class="text-center margin-top-20 margin-bottom-0">
                <a href="{{ route('signup') }}" class="btn btn-xs has-text-white">Sign up</a> | 
                <a href="#" class="btn btn-xs has-text-white" data-toggle="modal" data-target="#resend-verification-email">Resend Verification Email</a> | 
                <a href="#" class="btn btn-xs has-text-white" data-toggle="modal" data-target="#forgot-password">Forgot Password ?</a>
            </p>
            
            <p class="text-center">
                <a class="btn btn-xs has-text-white" href="{{action('StaticPageController@about')}}">About</a> | 
                <a class="btn btn-xs has-text-white" href="{{action('StaticPageController@page', 'privacy-policy')}}">Privacy</a> | 
                <a class="btn btn-xs has-text-white" href="{{action('StaticPageController@contact')}}">Contact Us</a>
            </p>
            
        </div>
                
    </div>
    
    @section('bodyScope')
    
    <div class="modal fade modal-centered" id="resend-verification-email" tabindex="-1" role="dialog" aria-labelledby="resend-verification-email">
        <div class="modal-dialog modal-md" role="document">
            <div class="blue-bg col-xs-12 white-text padding-100">
                
                {!! Form::open(['method'=>'post', 'url'=>action('AccessController@resendVerificationEmail'), 'role'=>'form']) !!}
                
                <div class="modal-header col-xs-12 padding-left-0 padding-right-0">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-uppercase" id="myModalLabel">Resend Verification Email</h4>
                </div>
                
                <div class="modal-body col-xs-12 padding-left-0 padding-right-0">
                    
                    <div class="field has-addons">
                        <div class="control is-expanded">
                            {!! Form::email('email', null, ['class'=>'input is-white', 'placeholder'=>'Enter your email address', 'required'=>'', 'aria-describedby'=> 'resend verification email']) !!}
                        </div>
                        <div class="control">
                            <button class="button is-white is-outlined" type="submit">
                            Submit
                            </button>
                        </div>
                    </div>
                    
                    
                </div>
                
                {!! Form::close() !!}
                
            </div>
        </div>
    </div>
    
    <div class="modal fade modal-centered" id="forgot-password" tabindex="-1" role="dialog" aria-labelledby="forgot-password">
        <div class="modal-dialog modal-md" role="document">
            <div class="green-bg col-xs-12 white-text padding-100">
                
                {!! Form::open(['method'=>'post', 'url'=>action('AccessController@forgotPassword'), 'role'=>'form']) !!}
                
                <div class="modal-header col-xs-12 padding-left-0 padding-right-0">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-uppercase" id="myModalLabel">Retrieve Password</h4>
                </div>
                
                <div class="modal-body col-xs-12 padding-left-0 padding-right-0">
                    
                    <div class="field has-addons">
                        <div class="control is-expanded">
                            {!! Form::email('recovery_email', null, ['class'=>'input is-primary', 'placeholder'=>'Enter your email address', 'required'=>'', 'aria-describedby'=> 'recovery_email']) !!}
                        </div>
                        <div class="control">
                            <button class="button is-primary is-outlined" type="submit">
                            Submit
                            </button>
                        </div>
                    </div>
                    
                    
                </div>
                
                {!! Form::close() !!}
                
            </div>
        </div>
    </div>
    
    @stop
        
</section>


</section>  
@stop
