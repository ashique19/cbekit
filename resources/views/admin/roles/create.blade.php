@extends('admin.layout')

@section('main')

<h3>Create new role</h3>


{!! Form::open(['action'=>'Roles@store']) !!}

    <div class="form-group">
        {!! Form::label('rolename','Name: ') !!}
        {!! Form::text('name', null, ['class'=>'form-control']) !!}
    </div>
    
    <div class="form-group">
        {!! Form::label('active','active: ') !!}
        {!! Form::select('active', ['inactive','active'], null, ['class'=>'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::submit('Add role', ['class'=>'form-control btn btn-info']) !!}
    </div>

{!! Form::close() !!}

@if($errors->any())
    
    <ul>
        @foreach($errors->all() as $error)
        
            <li class="btn-danger">{{$error}}</li>
        
        @endforeach
    </ul>

@endif

@stop