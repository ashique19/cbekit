
@extends('admin.layout')

@section('title') Gateway @stop

@section('main')

<h1><center>Gateways @if($gateways) : {{$gateways->total()}} @endif</center></h1>

<section class="col-xs-12">
    
    {!! Form::open(['class'=>'form form-inline', 'method' =>'post', 'url'=> action('Gateways@searchIndex')]) !!} 
        <div class="form-group">
            {!! Form::label('name', 'Name: ') !!}
            {!! Form::text('name', old('name') , ['class'=>'form-control']) !!}
        </div>
            
        <div class="form-group">
            {!! Form::label('charge', 'Charge: ') !!}
            {!! Form::text('charge', old('charge') , ['class'=>'form-control']) !!}
        </div>
            
        <div class="form-group">
            {!! Form::label('is_active', 'Is active: ') !!}
            {!! Form::select('is_active', [ ''=>'-Select-','1'=>'Yes', '0'=>'No'], old('is_active') , ['class'=>'form-control']) !!}
        </div>
            
        <div class="form-group">
            {!! Form::label('from', 'From: ') !!}
            {!! Form::text('from', old('from') , ['class'=>'form-control datepicker']) !!}
        </div>
        
        <div class="form-group">
            {!! Form::label('to', 'To: ') !!}
            {!! Form::text('to', old('to') , ['class'=>'form-control datepicker']) !!}
        </div>

        {!! Form::submit('search', ['class'=>'btn btn-info']) !!}
        
    {!! Form::close() !!}
    
    <hr>
</section>

<section class="col-sm-11">
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

<section class="col-sm-11">

    <table class="table table-responsive">
        <thead>
            <tr>
				<th>Id</th>
				<th>Name</th>
				<th>Charge</th>
				<th>Is active</th>
				<th>Created at</th>
				<th>Updated at</th>
                <th>Show</th>
                <th>Modify</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            @if($gateways)
                @foreach($gateways as $gateway)
                    <tr>
						<td>{{$gateway->id}}</td>
						<td>{{$gateway->name}}</td>
						<td>{{$gateway->charge}}</td>
						<td>@if($gateway->is_active == 1) Yes @elseif($gateway->is_active == 0) No @else $gateway->is_active @endif</td>
						<td>{{$gateway->created_at}}</td>
						<td>{{$gateway->updated_at}}</td>
                        <td>
                            <a href="{{action('Gateways@show', $gateway->id)}}" class="btn btn-default btn-sm btn-rounded" title="Edit role"><span class="fa fa-pencil"></span></a>
                        </td>
                        <td>
                            <a href="{{action('Gateways@edit', $gateway['id'])}}" class="btn btn-default btn-sm btn-rounded" title="Edit role"><span class="fa fa-pencil"></span></a>
                        </td>
                        <td>
                            {!! Form::open(['method'=>'delete', 'url'=> action('Gateways@destroy', $gateway->id) ]) !!}
                            {!! Form::hidden('id', $gateway->id ) !!}
                            <button href="{{action('Gateways@edit',[$gateway->id])}}" class="btn btn-danger btn-sm btn-rounded" title="Delete gateway ">
                                <span class="fa fa-times"></span>
                            </button>
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
    {!! $gateways->render() !!}
</section>

@stop
        