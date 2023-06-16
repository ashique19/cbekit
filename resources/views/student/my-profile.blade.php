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
    
    <h1 class="heading">My Profile</h1>
    
    @include('clients.partials.client-nav')
    
    <div class="col-sm-9">
        
        <table class="table table-responsive client-profile-table">
            <thead>
                <tr>
                    <th class="white-bg" width="150"><img src="{{auth()->user()->user_photo}}" alt="auth()->user()->name" class="img-responsive img-rounded"></th>
                    <th class="white-bg"><h3>{{auth()->user()->name}} | Profile</h3></th>
                </tr>
            </thead>
            <tbody>
                <tr> <td><h5>Email</h5></td>            <td>{{auth()->user()->email}}</td> </tr>
                <tr> <td><h5>Contact</h5></td>          <td>{{auth()->user()->contact}}</td> </tr>
                <tr> <td><h5>Address</h5></td>          <td>{{auth()->user()->address}}</td> </tr>
                <tr> <td><h5>City</h5></td>             <td>{{auth()->user()->city}}</td> </tr>
                <tr> <td><h5>State</h5></td>            <td>{{auth()->user()->state}}</td> </tr>
                <tr> <td><h5>Postcode</h5></td>         <td>{{auth()->user()->postcode}}</td> </tr>
                <tr> <td><h5>Country</h5></td>          <td>{{auth()->user()->country ? auth()->user()->country->name : ""}}</td> </tr>
                <tr> <td><h5>Account Balance</h5></td>  <td>{{auth()->user()->balance}}</td> </tr>
                <tr>
                    <td></td>
                    <td>
                        <a href="{{action('Clients@editProfile')}}" class="btn white-bg pink-border">Edit Profile</a>
                        <a href="{{action('Clients@changePassword')}}" class="btn white-bg green-border">Change Password</a>
                    </td>
                </tr>
            </tbody>
        </table>
        
    </div>
</div>

@stop
        