@extends('admin.layout')

@section('main')

<section class="container">

<h3>Permissions for Role</h3>


{!! Form::open( ['url'=> action('Roles@postPermission') ]) !!}

    @if($navs)
        {!! Form::hidden('role_id', $role) !!}
        @foreach($navs as $nav)
        
            @if( in_array($nav->id, $permitted_navs) )
            
                <div class="form-group">
                    {!! Form::label('permissions[]', $nav->name) !!}
                    {!! Form::checkbox('permissions[]', $nav->id, ['class'=>'form-control']) !!}
                </div>
            
            @else
    
                <div class="form-group">
                    {!! Form::label('permissions[]', $nav->name) !!}
                    {!! Form::checkbox('permissions[]', $nav->id, null) !!}
                </div>
            
            @endif
    
        
        @endforeach
    
    @endif
    
    <div class="form-group">
        
    </div>

    <div class="form-group">
        {!! Form::submit('Update Permissions', ['class'=>'form-control btn btn-info']) !!}
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