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
                
        @if($order)
        <!-- PAGE CONTENT WRAPPER -->
        <div class="col-md-12">
            
            <div class="panel panel-default">
                <div class="panel-body">                            
                    <!-- INVOICE -->
                    <div class="invoice for-print">
                        
                        <div class="row">
                            <table class="table" width="100%">
                                <tr width="100%">
                                    <h2>{{settings()->application_name}} INVOICE <b>#{{$order->id}}</b></h2>
                                </tr>
                                <tr width="100%">
                                    <td width="33.33%">
                                        <div class="invoice-address">
                                            <h5>From</h5>
                                            <h6>{{$order->buyer_firstname}} {{$order->buyer_lastname}}</h6>
                                            <p>{{$order->buyer_address_line_1}} {{$order->buyer_address_line_2}}, {{$order->buyer_city}} {{$order->buyer_state}}, {{$order->buyer_postcode}}, @if($order->buyerCountry){{$order->buyerCountry->name}} @endif</p>
                                            <p>Email: {{$order->buyer_email}}</p>
                                            <p>Phone: {{$order->buyer_phone}}</p>
                                            <p>Note: {{$order->note}}</p>
                                        </div>
                                    </td>
                                    <td width="33.33%">
                                        <div class="invoice-address">
                                            <h5>To</h5>
                                            <h6>{{$order->receiver_firstname}} {{$order->receiver_lastname}}</h6>
                                            <p>{{$order->receiver_address_line_1}} {{$order->receiver_address_line_2}}, {{$order->receiver_city}} {{$order->receiver_state}}, {{$order->receiver_postcode}}, @if($order->receiverCountry){{$order->receiverCountry->name}} @endif</p>
                                            <p>Email: {{$order->receiver_email}}</p>
                                            <p>Phone: {{$order->receiver_phone}}</p>
                                            <p>Shipping via: {{$order->shipping->name}}</p>
                                        </div> 
                                    </td>
                                    <td width="33.33%">
                                        <div class="invoice-address">
                                            <h5>Processed by</h5>
                                            <h6>{{settings()->application_name}}</h6>
                                            <p>Web: {{$_SERVER['SERVER_NAME']}}</p>
                                            <p>Company: {{settings()->business_name}}</p>
                                            <p>{{settings()->address}}, {{settings()->city}}, {{settings()->postcode}}</p>
                                            <p>Phone: {{settings()->helpline}}</p>
                                        </div> 
                                    </td>
                                </tr>
                            </table>
                        </div>
                        
                        <div class="row">
        
                                <div class="invoice-address">
                                    <h5>Invoice summary</h5>
                                    <table class="table table-striped">
                                        <tr>
                                            <td><center>Invoice no.</center></td>
                                            <td><center>Invoice date</center></td>
                                            <td><center>Dispatch date</center></td>
                                            <td><center>Delivery date</center></td>
                                            <td><center>Total</center></td>
                                        </tr>
                                        <tr>
                                            <td><center>#{{$order->id}}</center></td>
                                            <td><center>{{$order->created_at->format('Y-M-d H:i')}}</center></td>
                                            <td><center>{{$order->dispatch_date->format("Y-M-d H:i")}}</center></td>
                                            <td><center>{{$order->delivery_date->format("Y-M-d")}} {{$order->delivery_time}}</center></td>
                                            <td><center>BDT {{$order->net_value}}</center></td>
                                        </tr>
                                    </table>
        
                                </div>                                        
        
                            </div>
                        
                        <div class="table-invoice">
                            <table class="table">
                                <tr>
                                    <th>Item</th>
                                    <th>Description</th>
                                    <th class="text-center">Unit Price</th>
                                    <th class="text-center">Quantity</th>
                                    <th class="text-center">Total</th>
                                </tr>
                                @if($order->order_products()->count() > 0)
                                    @foreach($order->order_products as $product)
                                        <tr>
                                            <td><b>{{$product->name}}</b></td>
                                            <td>
                                                @if($product->attributes()->count() > 0)
                                                @foreach( $product->attributes as $attribute )
                                                <p>{{$attribute->name}}: {{$attribute->value}} @if($attribute->attribute_photo)<img src="{{$attribute->attribute_photo}}" width="50" /> @endif</p>
                                                @endforeach
                                                @endif
                                            </td>
                                            <td class="text-center">{{$product->price}}</td>
                                            <td class="text-center">{{$product->ordered_quantity}}</td>
                                            <td class="text-center">{{$product->ordered_amount}}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </table>
                        </div>
                        
                        <div class="row">
                            <table class="table">
                                <tr width="100%">
                                    <td width="50%">
                                        <h4>Payment Method</h4>
                                
                                        <div class="paymant-table">
                                            <a href="#" class="active">
                                                <p>{{$order->gateway->name}}</p>
                                            </a>
                                        </div>
                                        
                                        <h4>Shipping via</h4>
                                        
                                        <div class="paymant-table">
                                            <a href="#" class="active">
                                                <p>{{$order->shipping->name}}</p>
                                            </a>
                                        </div>
                                        
                                        <h4>Status</h4>
                                        
                                        <div class="paymant-table">
                                            <a href="#" class="active">
                                                <p>{{$order->order_status->name}}</p>
                                            </a>
                                        </div>
                                        
                                    </td>
                                    <td width="50%">
                                        <h4>Amount Due</h4>
                                
                                        <table class="table table-striped">
                                            <tr>
                                                <td width="200"><b>Sub Total:</b></td><td class="text-right">{{$order->gross_value}}</td>
                                            </tr>
                                            <tr>
                                                <td width="200"><b>Transaction Charge:</b></td><td class="text-right">{{$order->gateway_cost}}</td>
                                            </tr>
                                            <tr>
                                                <td width="200"><b>Shipping Charge:</b></td><td class="text-right">{{$order->shipping_cost}}</td>
                                            </tr>
                                            <tr>
                                                <td width="200"><b>Discount:@if($order->coupon_code)(Coupon:{{$order->coupon_code}}) @endif</b></td><td class="text-right">{{$order->coupon_value + $order->other_discount}}</td>
                                            </tr>
                                            <tr>
                                                <td><b>Paid:</b></td><td class="text-right">{{yn($order->is_paid)}}</td>
                                            </tr>
                                            <tr class="total">
                                                <td><b>Total Amount:</b></td><td class="text-right">{{$order->net_value}}</td>
                                            </tr>
                                        </table>  
                                    </td>
                                </tr>
                                <tr></tr>
                            </table>
                        </div>
                        
                        
                    </div>
                    <!-- END INVOICE -->
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="pull-right push-down-20 btn-group">
                                <!--<a href="{{action('Orders@edit', $order->id)}}" class="btn white-bg pink-border green-text"><span class="fa fa-pencil-square-o"></span>Modify</a>-->
                                <!--<button class="btn white-bg green-border pink-text print"><span class="fa fa-print"></span>Print</button>-->
                                
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
                                    <button type="submit" class='btn pink-border green-text white-bg' name="pay">Pay Now</button>
                                </form>
                                
                                @endif
                                
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        
        </div>
        <!-- END PAGE CONTENT WRAPPER -->  
        
        @else
        
            <h3>No data found.</h3>
        
        @endif

    </div>
    
</div>

@stop
        