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
    
    <h1 class="heading">Change Password</h1>
    
    @include('clients.partials.client-nav')
    <div class="col-sm-9">
        
        @if($errors->any())
        <ul>
        @foreach($errors->all() as $error)
            <li>{{$error}}</li>
        @endforeach
        </ul>
        @endif
        
        <div class="row">
            {!! Form::open(['role'=>'form', 'class'=>'form', 'url'=>action('MyProfile@updatePassword'), 'enctype'=>'multipart/form-data']) !!}
            <li class="list-group-item"><span class="profile-details-heading">Old Password:</span> {!! Form::password('oldpass', ['class'=>'form-control', 'required'=>'required', 'min'=> 4]) !!}</li>
            <li class="list-group-item"><span class="profile-details-heading">New Password:</span> {!! Form::password('newpass', ['class'=>'form-control', 'required'=>'required', 'min'=> 4]) !!}</li>
            <li class="list-group-item"><span class="profile-details-heading">Repeat Password:</span> {!! Form::password('repeatpass', ['class'=> 'form-control', 'required'=>'required', 'min'=> 4]) !!} </li>                                
            <li class="list-group-item"><center><strong>{!! Form::submit('Update', ['class'=>'btn white-bg pink-border']) !!}</strong></center></li>
            {!! Form::close() !!}
        </div>
        
    </div>
</div>

@stop
        