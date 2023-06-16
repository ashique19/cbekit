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
    
    <h1 class="heading">My Referrals</h1>
    
    @include('clients.partials.client-nav')
    <div class="col-sm-9">
        
        @if($errors->any())
        <ul>
        @foreach($errors->all() as $error)
            <li>{{$error}}</li>
        @endforeach
        </ul>
        @endif
        
        <li class="list-group-item">You could earn discount/point by referring your friend.</li>
        <li class="list-group-item">While referring someone, tell them to enter your email address as referee.</li>
        
        @if( count($referrals) > 0 )
            <li class="list-group-item text-center"><b>My Referrals</b></li>
            @foreach($referrals as $referral)
            <li class="list-group-item"><span class="profile-details-heading">Name:</span> <img src="{{url($referral->user_photo)}}" width="50" height="50" class="img-thumbnail img-circle">{{$referral->name}} <span class="badge badge-primary pull-right">Joined at: {{$referral->created_at->format('Y-m-d')}}</span></li>
            @endforeach
        @else
            <li class="list-group-item text-center"><b>You have not referred anyone yet.</b></li>
        @endif
        
    </div>
</div>

@stop
        