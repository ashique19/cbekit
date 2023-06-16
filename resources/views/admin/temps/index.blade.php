@extends('admin.layout')

@section('title')Temp - {{ settings()->application_name }} @stop

@section('main')

<h1 class="page-title">Temps @if( $temps ) : {{ $temps->total() }} @endif</h1>


<section class="col-sm-10 col-sm-offset-1 col-xs-12">
    
    {!! Form::open(['class'=>'form form-inline', 'method' =>'post', 'url'=> action('Temps@searchIndex')]) !!} 
        <div class="form-group col-sm-3 col-xs-6 padding-5">
            {!! Form::label('id', 'Id: ') !!}
            {!! Form::text('id', old('id') , ['class'=>'form-control']) !!}
        </div>
            
        <div class="form-group col-sm-3 col-xs-6 padding-5">
            {!! Form::label('name', 'Name: ') !!}
            {!! Form::text('name', old('name') , ['class'=>'form-control']) !!}
        </div>
            
        <div class="form-group col-sm-3 col-xs-6 padding-5">
            {!! Form::label('role_id', 'Role: ') !!}
            {!! Form::select('role_id', \App\Role::pluck('name', 'id'), old('role_id') , ['class'=>'form-control select2']) !!}
        </div>
            
        <div class="form-group col-sm-3 col-xs-6 padding-5">
            {!! Form::label('is_active', 'Is active: ') !!}
            {!! Form::select('is_active', [ ''=>'-Select-','1'=>'Yes', '0'=>'No'], old('is_active') , ['class'=>'form-control']) !!}
        </div>
            
        <div class="form-group col-sm-3 col-xs-6 padding-5">
            {!! Form::label('temp_link', 'Temp link: ') !!}
            {!! Form::text('temp_link', old('temp_link') , ['class'=>'form-control']) !!}
        </div>
            
        <div class="form-group col-sm-3 col-xs-6 padding-5">
            {!! Form::label('created_by', 'Created by: ') !!}
            {!! Form::select('created_by', [], 'null' , ['class'=>'form-control user-search']) !!}
        </div>
            
        <div class="form-group col-sm-3 col-xs-6 padding-5">
            {!! Form::label('updated_by', 'Updated by: ') !!}
            {!! Form::select('updated_by', [], 'null' , ['class'=>'form-control user-search']) !!}
        </div>
            
        <div class="form-group col-sm-3 col-xs-6 padding-5">
            {!! Form::label('published_date', 'Published date: ') !!}
            {!! Form::text('published_date', old('published_date') , ['class'=>'form-control datepicker']) !!}
        </div>
            
        <div class="form-group col-sm-3 col-xs-6 padding-5">
            {!! Form::label('reviewed_date', 'Reviewed date: ') !!}
            {!! Form::text('reviewed_date', old('reviewed_date') , ['class'=>'form-control datepicker']) !!}
        </div>
            
        <div class="form-group col-sm-3 col-xs-6">
            {!! Form::label('from', 'From: ') !!}
            {!! Form::text('from', old('from') , ['class'=>'form-control datepicker']) !!}
        </div>
        
        <div class="form-group col-sm-3 col-xs-6">
            {!! Form::label('to', 'To: ') !!}
            {!! Form::text('to', old('to') , ['class'=>'form-control datepicker']) !!}
        </div>
        
        <div class="form-group col-xs-12 text-center">
            {!! Form::submit('search', ['class'=>'btn btn-info']) !!}
        </div>
        
    {!! Form::close() !!}
    
    <hr>
</section>


<div class="col-sm-10 col-sm-offset-1 col-xs-12">
    
    {!! errors($errors) !!}
    
</div>

<section class="col-sm-10 col-sm-offset-1 col-xs-12">
    
    <a href="{{action('Temps@create')}}" class="btn btn-default pull-right btn-lg blue-border blue-text">Add new</a>

</section>
        
<section class="col-sm-10 col-sm-offset-1 col-xs-12">
    
    <table class="table table-responsive">
        <thead>
            <tr>
				<th class="blue-bg white-text">Id</th>
				<th class="blue-bg white-text">Name</th>
				<th class="blue-bg white-text">Role</th>
				<th class="blue-bg white-text">Active</th>
				<th class="blue-bg white-text">Thumb</th>
				<th class="blue-bg white-text">Published date</th>
				<th class="blue-bg white-text">Reviewed date</th>
				<th class="blue-bg white-text">Last Modified</th>
                <th class="blue-bg white-text" width="50">More</th>
                <th class="blue-bg white-text" width="50"><i class="fa fa-trash-o fa-2x"></i></th>
            </tr>
        </thead>
        <tbody>
            @if($temps)
                @foreach($temps as $temp)
                    <tr>
						<td>{{$temp->id}}</td>
						<td>{{$temp->name}}</td>
						<td>@if($temp->role_id) {{$temp->role_id->name}} @endif</td>
						<td>{{ yn($temp->is_active) }}</td>
						<td><a href="{{$temp->thumb_image}}" class="btn btn-default btn-xs">{!! thumb($temp->thumb_image) !!}</a></td>
						<td>{{$temp->published_date->format('Y-M-d')}}</td>
						<td>{{$temp->reviewed_date->format('Y-M-d')}}</td>
						<td>{{$temp->updated_at->format('Y-M-d')}}</td>
                        <td>
                            <button type="button" 
                                    class="btn btn-default" 
                                    data-container="body" 
                                    data-toggle="popover" 
                                    data-placement="bottom"
                                    data-html="true"
                                    data-content="
                                        {!! views('Temps', $temp->id, '<span class=\'fa fa-expand\'></span>', ['class'=>'btn btn-default btn-rounded btn-block']) !!}
                                        {!! edits('Temps', $temp['id'], '<span class=\'fa fa-pencil\'></span>', ['class'=>'btn btn-default btn-rounded btn-block']) !!}
                                    ">
                                <i class="fa fa-gear"></i>
                            </button>
                        </td>
                        <td>
                            <a  tabindex="0" 
                                class="btn btn-lg btn-danger" 
                                role="button" 
                                data-toggle="popover" 
                                data-trigger="focus" 
                                data-html="true"
                                title="Delete" 
                                data-content="
                                <h4>Are you sure?</h4>
                                {!! deletes('Temps', $temp['id'], 'YES', ['class'=>'btn btn-default btn-rounded btn-block']) !!}
                                <button class='btn btn-default btn-rounded btn-block'>NO</button>
                                ">
                                <i class='fa fa-trash-o fa-2x'></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
    {!! $temps->render() !!}
</section>
        

@stop