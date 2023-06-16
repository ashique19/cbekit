
@extends('admin.layout')

@section('title') Blogslide @stop

@section('main')

<h1 class="page-title"><center>Blogslide</center></h1>


@if($errors->any())
<section class="row panel-body">
    <h4>Please check:</h4>
    
    <ul>
        @foreach($errors->all() as $error)
        
            <li>{{$error}}</li>
        
        @endforeach
    </ul>
    <hr>
</section>  
@endif


@if($blogslide)
<section class="row panel-body">
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
                    <td>{{$blogslide->id}}</td>
                </tr>
                
                <tr>
                    <td>Name</td>
                    <td>{{$blogslide->name}}</td>
                </tr>
                
                <tr>
                    <td>Subtitle</td>
                    <td>{{$blogslide->subtitle}}</td>
                </tr>
                
                <tr>
                    <td>Slide photo</td>
                    <td><a href="{{$blogslide->slide_photo}}" class="btn btn-default btn-rounded btn-xs"><span class="fa fa-download"></span></a></td>
                </tr>
                
                <tr>
                    <td>Blog</td>
                    <td>@if($blogslide->blog) {{$blogslide->blog->name}} @endif</td>
                </tr>
                
                <tr>
                    <td>Created at</td>
                    <td>{{$blogslide->created_at}}</td>
                </tr>
                
                <tr>
                    <td>Updated at</td>
                    <td>{{$blogslide->updated_at}}</td>
                </tr>
                
            <tr>
                <td>
                    {!! edits('Blogslides', $blogslide->id, 'edit', ['class'=>'btn btn-warning btn-rounded']) !!}
                            
                </td>
                <td>
                    {!! deletes('Blogslides', $blogslide->id, '<span class=\'fa fa-times\'></span>', ['class'=>'btn btn-danger btn-rounded']) !!}
                </td>
            </tr>
        </tbody>
    </table>
</section>

@else

    <h3>No data found.</h3>

@endif

@stop
        