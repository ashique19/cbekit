@extends('admin.layout')

@section('main')

<section class="container">

<h3>Actions for Role</h3>


{!! Form::open( ['url'=> action('Roles@postPermissions') ]) !!}

    @if($actions)
        {!! Form::hidden('role_id', $role) !!}
        @foreach($actions as $action)
        
            @if( in_array($action->id, $permitted_actions) )
            
                <div class="form-group">
                    {!! Form::label('permissions[]', $action->name) !!}
                    {!! Form::checkbox('permissions[]', $action->id, ['class'=>'form-control']) !!}
                </div>
            
            @else
    
                <div class="form-group">
                    {!! Form::label('permissions[]', $action->name) !!}
                    {!! Form::checkbox('permissions[]', $action->id, null) !!}
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