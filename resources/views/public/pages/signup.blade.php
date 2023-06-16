@extends('public.layouts.layout')
@section('title'){{settings()->application_name}}- Signup for free. @stop
@section('main')

<section class="box margin-top-30 transparent-bg is-shadowless">

<section class="columns is-multiline">
    <aside class="column is-12-desktop is-12-mobile">
        <h1 class="title is-2 white-text font-weight-100">
            <a href="{{ route('login') }}" class="tag pull-right">Already have an account? Login</a>
        </h1>
            
    </aside>
    <article class="column is-4-desktop is-offset-4-desktop is-12-mobile margin-top-20">
        
        {!! errors($errors) !!}
        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
            <div class="panel">
                
                <div class="panel-heading padding-0 border-width-0" role="tab" id="headingOne">
                    <h4 class="panel-title">
                        <a class="button is-info is-fullwidth collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Sign up as Student
                        </a>
                    </h4>
                </div>
                <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                    <div class="panel-body black-bg">
                        {!! Form::open(['url'=>action('AccessController@postSignup'), 'method'=>'post', 'class'=> 'columns is-multiline is-mobile']) !!}
                        
                        {!! Form::hidden('role', 3) !!}
                        
                        <div class="column is-6-desktop is-12-mobile">
                            <div class="field">
                                <div class="control">
                                    {!! Form::text('firstname', old('firstname'), ['class'=>'input', 'placeholder'=>'First name', 'required'=>'']) !!}
                                </div>
                            </div>
                        </div>
                        
                        <div class="column is-6-desktop is-12-mobile">
                            <div class="field">
                                <div class="control">
                                    {!! Form::text('lastname', old('lastname'), ['class'=>'input', 'placeholder'=>'Last name', 'required'=>'']) !!}
                                </div>
                            </div>
                        </div>
                        
                        <div class="column is-6-desktop is-12-mobile">
                            <div class="field">
                                <div class="control">
                                    {!! Form::email('email', old('email'), ['class'=>'input', 'placeholder'=>'Email', 'required'=>'']) !!}
                                </div>
                            </div>
                        </div>
                        
                        <div class="column is-6-desktop is-12-mobile">
                            <div class="field">
                                <div class="control">
                                    <div class="select">
                                        {!! Form::select('country_id', \App\Country::pluck('name','id'), old('country') ?: 18, ['placeholder'=> '-Country-', 'class'=>'form-control', 'required'=>'']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="column is-6-desktop is-12-mobile">
                            <div class="field">
                                <div class="control">
                                    {!! Form::text('address', old('address'), ['class'=>'input', 'placeholder'=>'Address', 'required'=>'']) !!}
                                </div>
                            </div>
                        </div>
                        
                        <div class="column is-6-desktop is-12-mobile">
                            <div class="field">
                                <div class="control">
                                    {!! Form::text('contact', old('contact'), ['class'=>'input', 'placeholder'=>'Phone no.', 'required'=>'']) !!}
                                </div>
                            </div>
                        </div>
                        
                        <div class="column is-12 is-mobile">
                            <div class="field">
                                <div class="control">
                                    {!! Form::password('password', ['class'=>'input', 'placeholder'=>'Password', 'min'=> 8, 'required'=>'']) !!}
                                </div>
                            </div>
                        </div>
                        
                        <div class="column is-12 is-mobile">
                            <div class="field is-grouped is-grouped-centered">
                                <p class="control">
                                    <button class="button is-info" type="submit">Create Free Account</button>
                                </p>
                            </div>
                        </div>
                        
                        <div class="column is-12 is-mobile">
                            <div class="field is-grouped is-grouped-centered">
                                <p class="control">
                                    <p class="text-center">
                                        <a href="#" class="btn btn-xs has-text-white" data-toggle="modal" data-target="#resend-verification-email">Resend Verification Email</a>
                                    </p>
                                </p>
                            </div>
                        </div>
                
                        
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
            
            <div class="panel panel-default">
                <div class="panel-heading padding-0 border-width-0" role="tab" id="headingTwo">
                    <h4 class="panel-title">
                        <a class="button is-info is-fullwidth collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            Sign up as Teacher
                        </a>
                    </h4>
                </div>
                <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                    <div class="panel-body black-bg">
                        {!! Form::open(['url'=>action('AccessController@postSignup'), 'method'=>'post', 'class'=> 'columns is-multiline is-mobile']) !!}
                        
                        {!! Form::hidden('role', 4) !!}
                        
                        <div class="column is-6-desktop is-12-mobile">
                            <div class="field">
                                <div class="control">
                                    {!! Form::text('firstname', old('firstname'), ['class'=>'input', 'placeholder'=>'First name', 'required'=>'']) !!}
                                </div>
                            </div>
                        </div>
                        
                        <div class="column is-6-desktop is-12-mobile">
                            <div class="field">
                                <div class="control">
                                    {!! Form::text('lastname', old('lastname'), ['class'=>'input', 'placeholder'=>'Last name', 'required'=>'']) !!}
                                </div>
                            </div>
                        </div>
                        
                        <div class="column is-6-desktop is-12-mobile">
                            <div class="field">
                                <div class="control">
                                    {!! Form::email('email', old('email'), ['class'=>'input', 'placeholder'=>'Email', 'required'=>'']) !!}
                                </div>
                            </div>
                        </div>
                        
                        <div class="column is-6-desktop is-12-mobile">
                            <div class="field">
                                <div class="control">
                                    <div class="select">
                                        {!! Form::select('country_id', \App\Country::pluck('name','id'), old('country') ?: 18, ['placeholder'=> '-Country-', 'class'=>'form-control', 'required'=>'']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="column is-6-desktop is-12-mobile">
                            <div class="field">
                                <div class="control">
                                    {!! Form::text('address', old('address'), ['class'=>'input', 'placeholder'=>'Address', 'required'=>'']) !!}
                                </div>
                            </div>
                        </div>
                        
                        <div class="column is-6-desktop is-12-mobile">
                            <div class="field">
                                <div class="control">
                                    {!! Form::text('contact', old('contact'), ['class'=>'input', 'placeholder'=>'Phone no.', 'required'=>'']) !!}
                                </div>
                            </div>
                        </div>
                        
                        <div class="column is-12 is-mobile">
                            <div class="field">
                                <div class="control">
                                    {!! Form::password('password', ['class'=>'input', 'placeholder'=>'Password', 'min'=> 8, 'required'=>'']) !!}
                                </div>
                            </div>
                        </div>
                        
                        <div class="column is-12 is-mobile">
                            <div class="field is-grouped is-grouped-centered">
                                <p class="control">
                                    <button class="button is-info" type="submit">Create Free Account</button>
                                </p>
                            </div>
                        </div>
                        
                        <div class="column is-12 is-mobile">
                            <div class="field is-grouped is-grouped-centered">
                                <p class="control">
                                    <p class="text-center">
                                        <a href="#" class="btn btn-xs has-text-white" data-toggle="modal" data-target="#resend-verification-email">Resend Verification Email</a>
                                    </p>
                                </p>
                            </div>
                        </div>
                
                        
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading padding-0 border-width-0" role="tab" id="headingThree">
                    <h4 class="panel-title">
                        <a class="button is-info is-fullwidth collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        Sign up as Institute
                        </a>
                    </h4>
                </div>
                <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
                    <div class="panel-body black-bg">
                        {!! Form::open(['url'=>action('AccessController@postSignup'), 'method'=>'post', 'class'=> 'columns is-multiline is-mobile']) !!}
                        
                        {!! Form::hidden('role', 5) !!}
                        
                        <div class="column is-12-desktop is-12-mobile">
                            <div class="field">
                                <div class="control">
                                    {!! Form::text('institute_name', old('institute_name'), ['class'=>'input', 'placeholder'=>'Institute name', 'required'=>'']) !!}
                                </div>
                            </div>
                        </div>
                        
                        <div class="column is-6-desktop is-12-mobile">
                            <div class="field">
                                <div class="control">
                                    {!! Form::text('firstname', old('firstname'), ['class'=>'input', 'placeholder'=>'Admin First name', 'required'=>'']) !!}
                                </div>
                            </div>
                        </div>
                        
                        <div class="column is-6-desktop is-12-mobile">
                            <div class="field">
                                <div class="control">
                                    {!! Form::text('lastname', old('lastname'), ['class'=>'input', 'placeholder'=>'Admin Last name', 'required'=>'']) !!}
                                </div>
                            </div>
                        </div>
                        
                        <div class="column is-6-desktop is-12-mobile">
                            <div class="field">
                                <div class="control">
                                    {!! Form::email('email', old('email'), ['class'=>'input', 'placeholder'=>'Login Email', 'required'=>'']) !!}
                                </div>
                            </div>
                        </div>
                        
                        <div class="column is-6-desktop is-12-mobile">
                            <div class="field">
                                <div class="control">
                                    <div class="select">
                                        {!! Form::select('country_id', \App\Country::pluck('name','id'), old('country') ?: 18, ['placeholder'=> '-Country-', 'class'=>'form-control', 'required'=>'']) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="column is-6-desktop is-12-mobile">
                            <div class="field">
                                <div class="control">
                                    {!! Form::text('address', old('address'), ['class'=>'input', 'placeholder'=>'Address', 'required'=>'']) !!}
                                </div>
                            </div>
                        </div>
                        
                        <div class="column is-6-desktop is-12-mobile">
                            <div class="field">
                                <div class="control">
                                    {!! Form::text('contact', old('contact'), ['class'=>'input', 'placeholder'=>'Phone no.', 'required'=>'']) !!}
                                </div>
                            </div>
                        </div>
                        
                        <div class="column is-12 is-mobile">
                            <div class="field">
                                <div class="control">
                                    {!! Form::password('password', ['class'=>'input', 'placeholder'=>'Password', 'min'=> 8, 'required'=>'']) !!}
                                </div>
                            </div>
                        </div>
                        
                        <div class="column is-12 is-mobile">
                            <div class="field is-grouped is-grouped-centered">
                                <p class="control">
                                    <button class="button is-info" type="submit">Create Free Account</button>
                                </p>
                            </div>
                        </div>
                        
                        <div class="column is-12 is-mobile">
                            <div class="field is-grouped is-grouped-centered">
                                <p class="control">
                                    <p class="text-center">
                                        <a href="#" class="btn btn-xs has-text-white" data-toggle="modal" data-target="#resend-verification-email">Resend Verification Email</a>
                                    </p>
                                </p>
                            </div>
                        </div>
                
                        
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
            
        </div>
        

    </article>
</section>

</section>

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
    
@stop
    

@stop