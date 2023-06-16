
@extends('admin.layout')

@section('title') Create new Newsletter @stop

@section('main')

<h1 class="page-title blue-bg white-text"><center>Newsletters</center></h1>

{!! errors($errors) !!}

<section class="col-sm-6 col-sm-offset-3">

<h3>Create Newsletter</h3>


{!! Form::open( ['url'=> action('Newsletters@store'), 'enctype'=>'multipart/form-data' ]) !!}

    
        <div class="form-group">
            {!! Form::label('name', 'Name: ') !!}
            {!! Form::text('name', old('name') , ['class'=>'form-control']) !!}
        </div>
            
        <div class="form-group">
            {!! Form::label('details', 'Details: ') !!}
            {!! Form::text('details', old('details') , ['class'=>'form-control']) !!}
        </div>
            
    <div class="form-group">
        {!! Form::submit('Save Newsletter', ['class'=>'form-control btn btn-info']) !!}
    </div>

{!! Form::close() !!}


</section>

@stop
        