
@extends('admin.layout')

@section('title') Country @stop

@section('main')

<h1><center>Countries @if($countries) : {{$countries->total()}} @endif</center></h1>

<section class="col-xs-12">
    
    {!! Form::open(['class'=>'form form-inline', 'method' =>'post', 'url'=> action('Countries@searchIndex')]) !!} 
        <div class="form-group">
            {!! Form::label('code', 'Code: ') !!}
            {!! Form::text('code', old('code') , ['class'=>'form-control']) !!}
        </div>
            
        <div class="form-group">
            {!! Form::label('name', 'Name: ') !!}
            {!! Form::text('name', old('name') , ['class'=>'form-control']) !!}
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
				<th>Code</th>
				<th>Name</th>
				<th>Created at</th>
				<th>Updated at</th>
                <th>Show</th>
                <th>Modify</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            @if($countries)
                @foreach($countries as $country)
                    <tr>
						<td>{{$country->id}}</td>
						<td>{{$country->code}}</td>
						<td>{{$country->name}}</td>
						<td>{{$country->created_at}}</td>
						<td>{{$country->updated_at}}</td>
                        <td>
                            <a href="{{action('Countries@show', $country->id)}}" class="btn btn-default btn-sm btn-rounded" title="Edit role"><span class="fa fa-pencil"></span></a>
                        </td>
                        <td>
                            <a href="{{action('Countries@edit', $country['id'])}}" class="btn btn-default btn-sm btn-rounded" title="Edit role"><span class="fa fa-pencil"></span></a>
                        </td>
                        <td>
                            {!! Form::open(['method'=>'delete', 'url'=> action('Countries@destroy', $country->id) ]) !!}
                            {!! Form::hidden('id', $country->id ) !!}
                            <button href="{{action('Countries@edit',[$country->id])}}" class="btn btn-danger btn-sm btn-rounded" title="Delete country ">
                                <span class="fa fa-times"></span>
                            </button>
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
    {!! $countries->render() !!}
</section>

@stop
        