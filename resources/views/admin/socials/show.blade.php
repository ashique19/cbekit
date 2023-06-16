
@extends('admin.layout')

@section('title') Social @stop

@section('main')

<h1><center>Social</center></h1>

<section class="col-xs-12">
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

@if($social)
<section class="col-xs-12">
    <table class="table table-bordered table-striped table-actions">
        <tdead>
            <tr>
                <td width="200">Title</td>
                <td>Details</td>
            </tr>
        </tdead>
        <tbody>
                <tr>
                    <td>Id</td>
                    <td>{{$social->id}}</td>
                </tr>
                
                <tr>
                    <td>Name</td>
                    <td>{{$social->name}}</td>
                </tr>
                
                <tr>
                    <td>Created at</td>
                    <td>{{$social->created_at}}</td>
                </tr>
                
                <tr>
                    <td>Updated at</td>
                    <td>{{$social->updated_at}}</td>
                </tr>
                
            <tr>
                <td>
                    <a href="{{action('Socials@edit', $social->id)}}" class="btn btn-info btn-sm">edit</a>                
                </td>
                <td>
                    {!! Form::open(['url'=>action('Socials@destroy', $social->id), 'method'=>'DELETE']) !!}
                    {!! Form::hidden('id',$social->id) !!}
                    <button class=" btn btn-primary btn-sm "> <i class="fa fa-trash-o"></i> </button>
                    {!! Form::close() !!}
                </td>
            </tr>
        </tbody>
    </table>
</section>
@else

    <h3>No data found.</h3>

@endif

@stop
        