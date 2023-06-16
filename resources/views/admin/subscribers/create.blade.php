
@extends('admin.layout')

@section('title') Create new Subscriber @stop

@section('main')

<h1 class="page-title blue-bg white-text"><center>Subscribers</center></h1>

{!! errors($errors) !!}

<section class="col-sm-6 col-sm-offset-3">

<h3>Create Subscriber</h3>


{!! Form::open( ['url'=> action('Subscribers@store'), 'enctype'=>'multipart/form-data' ]) !!}

    
        <div class="form-group">
            {!! Form::label('name', 'Name: ') !!}
            {!! Form::text('name', old('name') , ['class'=>'form-control']) !!}
        </div>
            
        <div class="form-group">
            {!! Form::label('email', 'Email: ') !!}
            {!! Form::text('email', old('email') , ['class'=>'form-control']) !!}
        </div>
            
    <div class="form-group">
        {!! Form::submit('Save Subscriber', ['class'=>'form-control btn btn-info']) !!}
    </div>

{!! Form::close() !!}


</section>

@stop
        