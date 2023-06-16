@extends('public.layouts.layout')
@section('title')User Dashboard - Glamtics.com - Biggest Online Fashion Shop at Bangladesh @stop

@section('meta')
    <meta name="title" content="User Dashboard - Glamtics.com - Biggest Online Fashion Shop at Bangladesh">
    <meta name="description" content="User Dashboard for Glamtics.com Offers Online Fashion shopping from different countries in Bangladesh. Buy Fashion wear, Ornaments, Cosmetics, Designs & more. Free Shipping, 7 Day Returns & Cash on Delivery countrywide.">
    <meta name="keywords" content="Online Fashion Shopping Bangladesh: Fashion, Cosmetics, Ornaments">
@stop

@section('main')

@include('clients.partials.page-banner')

<div class="col-sm-10 col-sm-offset-1">
    
    <h1 class="heading">Edit Profile</h1>
    
    @include('clients.partials.client-nav')
    
    <div class="col-sm-9">

        <ul class="list-group">
            @if($errors->any())
    
                <ul>
                    @foreach($errors->all() as $error)
                    
                        <li>{{$error}}</li>
                    
                    @endforeach
                </ul>
            
            @endif

            {!! Form::open(['role'=>'form', 'class'=>'form', 'url'=>action('Clients@updateProfile'), 'enctype'=>'multipart/form-data']) !!}
            <li class="list-group-item"><span class="profile-details-heading">First Name:</span> {!! Form::text('firstname', auth()->user()->firstname, ['class'=>'form-control']) !!}</li>
            <li class="list-group-item"><span class="profile-details-heading">Last Name:</span> {!! Form::text('lastname', auth()->user()->lastname, ['class'=>'form-control']) !!}</li>
            <li class="list-group-item"><span class="profile-details-heading">Email:</span> {!! Form::text('email', auth()->user()->email, ['class'=> 'form-control']) !!} </li>                                
            <li class="list-group-item"><span class="profile-details-heading">Contact:</span> {!! Form::text('contact', auth()->user()->contact , ['class'=>'form-control', 'placeholder'=> 'Enter your mobile no.']) !!} </li>
            <li class="list-group-item"><span class="profile-details-heading">Present Address:</span> {!! Form::text('address', auth()->user()->address , ['class'=>'form-control']) !!} </li>
            <li class="list-group-item"><span class="profile-details-heading">City:</span> {!! Form::text('city', auth()->user()->city , ['class'=>'form-control', 'placeholder'=> 'e.g. Dhaka, Khulna, Chittagong etc.']) !!} </li>
            <li class="list-group-item"><span class="profile-details-heading">State:</span> {!! Form::text('state', auth()->user()->state , ['class'=>'form-control', 'placeholder'=> 'e.g. Dhaka, Khulna, Chittagong etc.']) !!} </li>
            <li class="list-group-item"><span class="profile-details-heading">Country:</span> {!! Form::select('country_id', \App\Country::lists('name', 'id'), auth()->user()->country_id , ['class'=>'form-control', 'placeholder'=> '-Select-']) !!} </li>
            <li class="list-group-item"><span class="profile-details-heading">Postcode:</span> {!! Form::text('postcode', auth()->user()->postcode , ['class'=>'form-control']) !!} </li>
            <li class="list-group-item"><span class="profile-details-heading">Profile Image:</span> {!! Form::file('picture', ['class'=>'form-control']) !!} </li>
            <li class="list-group-item"><center><strong>{!! Form::submit('Update', ['class'=>'btn white-bg pink-border']) !!}</strong></center></li>
            {!! Form::close() !!}
        </ul>
        
    </div>
</div>

@stop
        