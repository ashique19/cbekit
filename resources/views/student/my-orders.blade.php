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
    
    <h1 class="heading">My Orders</h1>
    
    @include('clients.partials.client-nav')
    <div class="col-sm-9">
        
        <table class="table table-responsive scroll text-center">
            <thead>
                <tr>
                    <th class="white-bg green-border pink-text text-center" width="100">Ordered date</th>
                    <th class="white-bg green-border pink-text text-center">Products</th>
                    <th class="white-bg green-border pink-text text-center" width="70">Payable (Tk)</th>
                    <th class="white-bg green-border pink-text text-center" width="70">Paid</th>
                    <th class="white-bg green-border pink-text text-center" width="70">Status</th>
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
                    <td>{{yn($order->is_paid)}}</td>
                    <td>@if($order->order_status){{$order->order_status->name}} @endif</td>
                    <td class="text-center">
                        <div class="btn-group">
                            <a href="{{action('Clients@showMyOrder', $order->id)}}" class="btn btn-sm green-border green-text">View</a>
                            
                            @if($order->order_status_id < 3)
                            <!--<a href="{{action('Clients@editMyOrder', $order->id)}}" class="btn btn-sm green-border green-text">Edit</a>-->
                            @endif
                            
                            @if($order->is_paid == 0 && $order->gateway_id != 3)
                            <form action="{{ env('AAMARPAY_LIVE_URL') }}" method="post">
                                <input type="hidden" name="ecomid" value="{{ env('AAMARPAY_ECOMID') }}">
                                <input type="hidden" name="client_id" value="{{ $order->id }}">
                                <input type="hidden" name="amount" value="{{$order->net_value}}" >
                                <input type="hidden" name="currency" value="BDT" >
                                <input type="hidden" name="client_name" value="{{$order->buyer_firstname}} {{$order->buyer_lastname}}">
                                <input type="hidden" name="client_email" value="{{$order->buyer_email}}" >
                                <input type="hidden" name="client_add1" value="{{$order->buyer_address_line_1}}">
                                <input type="hidden" name="client_add2" value="{{$order->buyer_address_line_2}}">
                                <input type="hidden" name="client_city" value="{{$order->buyer_city}}">
                                <input type="hidden" name="client_state" value="{{$order->buyer_state}}">
                                <input type="hidden" name="client_postcode" value="{{$order->buyer_postcode}}">
                                <input type="hidden" name="client_country" value="Bangladesh">
                                <input type="hidden" name="client_phone" value="{{$order->buyer_phone}}">
                                <input type="hidden" name="client_fax" value="">
                                <input type="hidden" name="details" value="No. of Products: {{$order->no_of_products}}">
                                <input type="hidden" name="successurl" value="{{ action('Orders@success') }}">
                                <input type="hidden" name="failurl" value = "{{ action('Orders@failed') }}">
                                <input type="hidden" name="cancelurl" value = "{{ action('Orders@cancel') }}">
                                <button type="submit" class='btn btn-sm pink-border green-text white-bg' name="pay">Pay Now</button>
                            </form>
                            
                            @endif
                            
                        </div>
                        
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
        