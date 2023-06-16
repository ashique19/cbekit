
@extends('admin.layout')

@section('title') Currency @stop

@section('main')

<h1><center>Currencies @if($currencies) : {{$currencies->total()}} @endif</center></h1>

<section class="col-xs-12">
    
    {!! Form::open(['class'=>'form form-inline', 'method' =>'post', 'url'=> action('Currencies@searchIndex')]) !!} 
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
				<th>Name</th>
				<th>Created at</th>
				<th>Updated at</th>
                <th>Show</th>
                <th>Modify</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            @if($currencies)
                @foreach($currencies as $currency)
                    <tr>
						<td>{{$currency->id}}</td>
						<td>{{$currency->name}}</td>
						<td>{{$currency->created_at}}</td>
						<td>{{$currency->updated_at}}</td>
                        <td>
                            <a href="{{action('Currencies@show', $currency->id)}}" class="btn btn-default btn-sm btn-rounded" title="Edit role"><span class="fa fa-pencil"></span></a>
                        </td>
                        <td>
                            <a href="{{action('Currencies@edit', $currency['id'])}}" class="btn btn-default btn-sm btn-rounded" title="Edit role"><span class="fa fa-pencil"></span></a>
                        </td>
                        <td>
                            {!! Form::open(['method'=>'delete', 'url'=> action('Currencies@destroy', $currency->id) ]) !!}
                            {!! Form::hidden('id', $currency->id ) !!}
                            <button href="{{action('Currencies@edit',[$currency->id])}}" class="btn btn-danger btn-sm btn-rounded" title="Delete currency ">
                                <span class="fa fa-times"></span>
                            </button>
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
    {!! $currencies->render() !!}
</section>

@stop
        