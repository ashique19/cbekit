
@extends('admin.layout')

@section('title') Country @stop

@section('main')

<h1><center>Country</center></h1>

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

@if($country)
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
                    <td>{{$country->id}}</td>
                </tr>
                
                <tr>
                    <td>Code</td>
                    <td>{{$country->code}}</td>
                </tr>
                
                <tr>
                    <td>Name</td>
                    <td>{{$country->name}}</td>
                </tr>
                
                <tr>
                    <td>Created at</td>
                    <td>{{$country->created_at}}</td>
                </tr>
                
                <tr>
                    <td>Updated at</td>
                    <td>{{$country->updated_at}}</td>
                </tr>
                
            <tr>
                <td>
                    <a href="{{action('Countries@edit', $country->id)}}" class="btn btn-info btn-sm">edit</a>                
                </td>
                <td>
                    {!! Form::open(['url'=>action('Countries@destroy', $country->id), 'method'=>'DELETE']) !!}
                    {!! Form::hidden('id',$country->id) !!}
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
        