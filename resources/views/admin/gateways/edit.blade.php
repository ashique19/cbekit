
@extends('admin.layout')

@section('title') Edit Gateways @stop

@section('main')

<h1><center>Modify Gateway</center></h1>

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

<section class="col-sm-11">

{!! Form::open( ['method'=>'patch', 'url'=> action('Gateways@update', $gateway->id), 'enctype'=>'multipart/form-data' ]) !!}

    
            <div class="form-group">
                {!! Form::label('name', 'Name: ') !!}
                {!! Form::text('name', $gateway->name , ['class'=>'form-control']) !!}
            </div>
                
            <div class="form-group">
                {!! Form::label('charge', 'Charge: ') !!}
                {!! Form::text('charge', $gateway->charge , ['class'=>'form-control']) !!}
            </div>
                
            <div class="form-group">
                {!! Form::label('is_active', 'Is active: ') !!}
                {!! Form::select('is_active', [ ''=>'-Select-','1'=>'Yes', '0'=>'No'], $gateway->is_active , ['class'=>'form-control']) !!}
            </div>
            
    <div class="form-group">
        {!! Form::submit('Update Gateway', ['class'=>'form-control btn btn-info']) !!}
    </div>

{!! Form::close() !!}


</section>

@stop
        