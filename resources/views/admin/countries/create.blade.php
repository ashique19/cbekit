
@extends('admin.layout')

@section('title') Create new Country @stop

@section('main')

<h1><center>Countries</center></h1>


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

<h3>Create Country</h3>


{!! Form::open( ['url'=> action('Countries@store'), 'class'=>'form form-horizontal', 'enctype'=>'multipart/form-data' ]) !!}

    
        <div class="form-group">
            {!! Form::label('code', 'Code: ') !!}
            {!! Form::text('code', old('code') , ['class'=>'form-control']) !!}
        </div>
            
        <div class="form-group">
            {!! Form::label('name', 'Name: ') !!}
            {!! Form::text('name', old('name') , ['class'=>'form-control']) !!}
        </div>
            
    <div class="form-group">
        {!! Form::submit('Save Country', ['class'=>'form-control btn btn-info']) !!}
    </div>

{!! Form::close() !!}


</section>

@stop
        