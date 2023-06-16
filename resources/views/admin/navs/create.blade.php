@extends('admin.layout')

@section('main')


<h1><center>Create new Nav</center></h1>

@if($errors->any())
    
    <ul>
        @foreach($errors->all() as $error)
        
            <li class="btn-danger">{{$error}}</li>
        
        @endforeach
    </ul>

@endif

{!! Form::open(['action'=>'Navs@store', 'class'=>'col-md-6 col-sm-10 col-md-offset-3 col-sm-offset-1']) !!}

    <div class="form-group">
        {!! Form::label('navname','Name: ') !!}
        {!! Form::text('name', null, ['class'=>'form-control', 'placeholder'=>'Enter nav name']) !!}
    </div>
    
    <div class="form-group">
        {!! Form::label('route','Route: ') !!}
        {!! Form::text('route', null, ['class'=>'form-control', 'placeholder'=>'Enter route (optional)']) !!}
    </div>
    
    <div class="form-group">
        {!! Form::label('icon','Icon: ') !!}
        {!! Form::text('icon', 'fa fa-tachometer', ['class'=>'form-control', 'placeholder'=>'Enter route icon (optional)']) !!}
    </div>
    
    <div class="form-group">
        {!! Form::label('type','Type: ') !!}
        {!! Form::select('type', ['parent','child'], 0, ['class'=>'form-control']) !!}
    </div>
    
    <div class="form-group">
        {!! Form::label('parent', 'Parent nav: ') !!}
        {!! Form::select('parent', $parents, 0, ['class'=> 'form-control']) !!}
    </div>
    
    <div class="form-group">
        {!! Form::label('active','Active: ') !!}
        {!! Form::select('active', ['inactive','active'], 1, ['class'=>'form-control', 'placeholder'=>'enter nav name']) !!}
    </div>
    
    <div class="form-group">
        {!! Form::label('location','Location: ') !!}
        {!! Form::select('location', [1=>'left', 2=>'top'], 1, ['class'=>'form-control', 'title'=>'Where should this nav go?']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('is_public','Is Public: ') !!}
        {!! Form::select('is_public', [ 0=>'no', 1=>'yes'], 1, ['class'=>'form-control', 'title'=>'Is this a public nav?']) !!}
    </div>

    <div class="form-group">
        {!! Form::submit('Add Nav', ['class'=>'form-control btn btn-info']) !!}
    </div>

{!! Form::close() !!}



@stop