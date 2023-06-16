
@extends('admin.layout')

@section('title') Gateway @stop

@section('main')

<h1><center>Gateway</center></h1>

<section class="col-xs-12">
@if($errors->any())

    <h4>Please check:</h4>
    
    <ul>
        @foreach($errors->all() as $error)
        
            <li>{{$error}}</li>
        
        @endforeach
    </ul>
    <hr>
    
@endif
</section>

@if($gateway)
<section class="col-xs-12">
    <table class="table table-bordered table-striped table-actions">
        <tdead>
            <tr>
                <td width="200">Title</td>
                <td>Details</td>
            </tr>
        </tdead>
        <tbody>
                <tr>
                    <td>Id</td>
                    <td>{{$gateway->id}}</td>
                </tr>
                
                <tr>
                    <td>Name</td>
                    <td>{{$gateway->name}}</td>
                </tr>
                
                <tr>
                    <td>Charge</td>
                    <td>{{$gateway->charge}}</td>
                </tr>
                
                <tr>
                    <td>Is active</td>
                    <td>{{$gateway->is_active}}</td>
                </tr>
                
                <tr>
                    <td>Created at</td>
                    <td>{{$gateway->created_at}}</td>
                </tr>
                
                <tr>
                    <td>Updated at</td>
                    <td>{{$gateway->updated_at}}</td>
                </tr>
                
            <tr>
                <td>
                    <a href="{{action('Gateways@edit', $gateway->id)}}" class="btn btn-info btn-sm">edit</a>                
                </td>
                <td>
                    {!! Form::open(['url'=>action('Gateways@destroy', $gateway->id), 'method'=>'DELETE']) !!}
                    {!! Form::hidden('id',$gateway->id) !!}
                    <button class=" btn btn-primary btn-sm "> <i class="fa fa-trash-o"></i> </button>
                    {!! Form::close() !!}
                </td>
            </tr>
        </tbody>
    </table>
</section>
@else

    <h3>No data found.</h3>

@endif

@stop
        