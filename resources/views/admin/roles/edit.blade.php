@extends('admin.layout')

@section('main')

<section class="container">

<h3>Modify role</h3>


{!! Form::open( ['method'=>'patch', 'url'=> action('Roles@update', ['id'=>$role->id]) ]) !!}

    <div class="form-group">
        {!! Form::label('rolename','Name: ') !!}
        {!! Form::text('name', $role->name , ['class'=>'form-control']) !!}
    </div>
    
    <div class="form-group">
        {!! Form::label('active','active: ') !!}
        {!! Form::select('active', ['inactive','active'], $role->active , ['class'=>'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::submit('Add role', ['class'=>'form-control btn btn-info']) !!}
    </div>

{!! Form::close() !!}

@if($errors->any())
    <hr>
    <ul class="container">
        @foreach($errors->all() as $error)
        
            <li>{{$error}}</li>
        
        @endforeach
    </ul>

@endif

</section>

@stop