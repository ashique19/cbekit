
@extends('admin.layout')

@section('title') Create new Gateway @stop

@section('main')

<h1><center>Gateways</center></h1>


@if($errors->any())
<section class="col-sm-11">
    <h4>Please check:</h4>
    
    <ul>
        @foreach($errors->all() as $error)
        
            <li>{{$error}}</li>
        
        @endforeach
    </ul>
    <hr>
</section>    
@endif


<section class="col-sm-11">

<h3>Create Gateway</h3>


{!! Form::open( ['url'=> action('Gateways@store'), 'class'=>'form form-horizontal', 'enctype'=>'multipart/form-data' ]) !!}

    
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
        {!! Form::submit('Save Gateway', ['class'=>'form-control btn btn-info']) !!}
    </div>

{!! Form::close() !!}


</section>

@stop
        