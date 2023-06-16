@extends('public.layouts.layout')
@section('title')
{{settings()->application_name}}- Pricing
@stop

@section('meta')
<meta name="title" content="{{settings()->application_name}} pricing">
<meta name="description" content="{{settings()->application_name}} pricing">
<meta name="keywords" content="{{settings()->application_name}}, pricing">
@stop

@section('main')


<div class="box margin-top-20">
    <section class="columns is-multiline margin-top-20 margin-bottom-20">

    <div class="column is-12-desktop is-12-mobile margin-bottom-20">
        <p>
            Most features are always <b>FREE</b> at <b>CBE KIT</b>. You can sign up for free and start utilizing them immediately at no cost. 
            <br>
            However, continuous development and maintanance cost of such a big system is not small. Therefore we charge our premium users at minimum price.
        </p>
    </div>
        
    <div class="column is-3-desktop is-5-mobile right-border">
        <h1 class="title is-2 has-text-info font-weight-100">PRICING <br>For <br>Premium Accounts</h1>
    </div>
    <div class="column is-6-desktop is-7-mobile is-offset-1-desktop">
        <p class="is-size-5 margin-bottom-20">
            Students:
            <br>
            <small>$9.99 USD per Paper per Year</small> <a href="#students" class="tag">Learn More</a>
        </p>
        
        <hr>
        <p class="is-size-5 margin-bottom-20">
            Teachers:
            <br>
            <small>$9.99 USD per Paper per Year</small> <a href="#teachers" class="tag">Learn More</a>
        </p>
        
        <hr>
        <p class="is-size-5 margin-bottom-20">
            Institutes:
            <br>
            <small>Starting from $99.99 per Year</small> <a href="#institutes" class="tag">Learn More</a>
        </p>
        
        <hr>
        
        <p>
            <a href="{{ route('signup') }}" class="button is-info is-small margin-right-20">Start with Free Account</a> 
        </p>
    </div>
    
    </section>
</div>

<div class="box margin-top-20">
    <section class="columns is-multiline margin-top-20 margin-bottom-20">


    <div class="column is-12-desktop is-12-mobile">
        <h3 class="subtitle is-4 text-center has-text-info" id="students">STUDENTS</h3>
    </div>
    <div class="column is-12-desktop is-12-mobile">
        
        <table class="table is-fullwidth is-bordered is-striped">
            <thead>
                <tr>
                    <th></th>
                    <th>FREE</th>
                    <th>PREMIUM</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Access to MCQ</td>
                    <td>Yes</td>
                    <td>Yes</td>
                </tr>
                <tr>
                    <td>Access to MTQ</td>
                    <td>Yes</td>
                    <td>Yes</td>
                </tr>
                <tr>
                    <td>Max allowed exam sessions each month</td>
                    <td>30</td>
                    <td>Unlimited</td>
                </tr>
                <tr>
                    <td>Manual review by teacher</td>
                    <td>No</td>
                    <td>Yes</td>
                </tr>
            </tbody>
        </table>
        <p class="text-right">
            <a href="{{ route('signup') }}" class="button is-info is-small">Sign up</a>
        </p>
    </div>

    
    </section>
</div>

<div class="box margin-top-20">
    <section class="columns is-multiline margin-top-20 margin-bottom-20">


    <div class="column is-4-desktop is-12-mobile is-offset-4-desktop">
        <h3 class="subtitle is-4 text-center has-text-info" id="teachers">TEACHERS</h3>
    </div>
    <div class="column is-12-desktop is-12-mobile">
        
        <table class="table is-fullwidth is-bordered is-striped">
            <thead>
                <tr>
                    <th></th>
                    <th>FREE</th>
                    <th>PREMIUM</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Upload own questions</td>
                    <td>Yes</td>
                    <td>Yes</td>
                </tr>
                <tr>
                    <td>Mark own students</td>
                    <td>Yes</td>
                    <td>Yes</td>
                </tr>
                <tr>
                    <td>Create own exam sessions</td>
                    <td>Yes</td>
                    <td>Yes</td>
                </tr>
                <tr>
                    <td>Keep uploaded questions private to you only</td>
                    <td>No</td>
                    <td>Yes</td>
                </tr>
            </tbody>
        </table>
        <p class="text-right">
            <a href="{{ route('signup') }}" class="button is-info is-small">Sign up</a>
        </p>
    </div>

    
    </section>
</div>

<div class="box margin-top-20">
    <section class="columns is-multiline margin-top-20 margin-bottom-20">


    <div class="column is-4-desktop is-12-mobile is-offset-4-desktop">
        <h3 class="subtitle is-4 text-center has-text-info" id="institutes">INSTITUTES</h3>
        <p class="has-text-centered margin-top-20"><a href="{{ action('StaticPageController@contact') }}">Contact us</a> for premium account for institutes</p>
    </div>
    
    </section>
</div>

@stop
        