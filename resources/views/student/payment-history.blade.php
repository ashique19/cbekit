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
    
    <h1 class="heading">Payment History</h1>
    
    @include('clients.partials.client-nav')
    <div class="col-sm-9">
        
        <table class="table table-responsive scroll text-center">
            <thead>
                <tr>
                    <th class="white-bg green-border pink-text text-center" width="100">Ordered date</th>
                    <th class="white-bg green-border pink-text text-center">Products</th>
                    <th class="white-bg green-border pink-text text-center" width="70">Amount (Tk)</th>
                    <th class="white-bg green-border pink-text text-center" width="70">Gateway</th>
                    <th class="white-bg green-border pink-text text-center" width="120">Options</th>
                </tr>
            </thead>
            <tbody>
                @if( count($orders) > 0 )
                @foreach($orders as $order)
                <tr>
                    <td>{{$order->created_at->format('M d, y')}}</td>
                    <td>{{implode( $order->order_products()->lists('name')->toArray() , ', ')}}</td>
                    <td>{{$order->net_value}}</td>
                    <td>@if($order->gateway){{$order->gateway->name}} @endif</td>
                    <td class="text-center">
                        <a href="{{action('Clients@showMyOrder', $order->id)}}" class="btn btn-sm green-border green-text">View</a>
                    </td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
        {!! $orders->render() !!}
        
        
    </div>
</div>

@stop
        