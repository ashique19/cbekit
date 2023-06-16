
@extends('admin.layout')

@section('title') Permission @stop

@section('main')

<h1><center>Permissions @if($permissions) : {{$permissions->total()}} @endif</center></h1>

<section class="col-xs-12">
    
    {!! Form::open(['class'=>'form form-inline', 'method' =>'post', 'url'=> action('Permissions@searchIndex')]) !!} 
        <div class="form-group">
            {!! Form::label('name', 'Name: ') !!}
            {!! Form::text('name', old('name') , ['class'=>'form-control']) !!}
        </div>
            
        <div class="form-group">
            {!! Form::label('from', 'From: ') !!}
            {!! Form::text('from', old('from') , ['class'=>'form-control datepicker']) !!}
        </div>
        
        <div class="form-group">
            {!! Form::label('to', 'To: ') !!}
            {!! Form::text('to', old('to') , ['class'=>'form-control datepicker']) !!}
        </div>

        {!! Form::submit('search', ['class'=>'btn btn-info']) !!}
        
    {!! Form::close() !!}
    
    <hr>
</section>

<secion class="col-xs-12">
    {!! Form::open(['url'=>action('Permissions@autoUpdate'), 'method'=>'POST', 'role'=>'form']) !!}
        <button class="badge badge-primary" type="submit">Update Action list</button>
    {!! Form::close() !!}
</secion>

<section class="col-sm-11">
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

    <table class="table table-responsive">
        <thead>
            <tr>
				<th>Id</th>
				<th>Name</th>
				<th>Created at</th>
				<th>Updated at</th>
                <th>Show</th>
                <th>Modify</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            @if($permissions)
                @foreach($permissions as $permission)
                    <tr>
						<td>{{$permission->id}}</td>
						<td>{{$permission->name}}</td>
						<td>{{$permission->created_at}}</td>
						<td>{{$permission->updated_at}}</td>
                        <td>
                            {!! views('permissions',$permission->id, '<span class=\'fa fa-expand\'></span>', ['class'=>'btn btn-default btn-sm btn-rounded']) !!}
                        </td>
                        <td>
                            {!! edits('permissions', $permission['id'], '<span class=\'fa fa-pencil\'></span>', ['class'=>'btn btn-default btn-sm btn-rounded']) !!}
                        </td>
                        <td>
                            {!! deletes('permissions', $permission['id'], '<span class=\'fa fa-times\'></span>', ['class'=>'btn btn-default btn-sm btn-rounded']) !!}
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
    {!! $permissions->render() !!}
</section>

@stop
        