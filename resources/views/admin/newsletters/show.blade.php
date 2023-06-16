
@extends('admin.layout')

@section('title') Newsletter @stop

@section('main')

<h1 class="page-title"><center>Newsletter</center></h1>

{!! errors($errors) !!}

@if($newsletter)
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
                    <td>{{$newsletter->id}}</td>
                </tr>
                
                <tr>
                    <td>Name</td>
                    <td>{{$newsletter->name}}</td>
                </tr>
                
                <tr>
                    <td>Details</td>
                    <td>{{$newsletter->details}}</td>
                </tr>
                
                <tr>
                    <td>Created at</td>
                    <td>{{$newsletter->created_at}}</td>
                </tr>
                
                <tr>
                    <td>Updated at</td>
                    <td>{{$newsletter->updated_at}}</td>
                </tr>
                
            <tr>
                <td>
                    {!! edits('Newsletters', $newsletter->id, 'edit', ['class'=>'btn btn-warning btn-rounded']) !!}
                            
                </td>
                <td>
                    {!! deletes('Newsletters', $newsletter->id, '<span class=\'fa fa-times\'></span>', ['class'=>'btn btn-danger btn-rounded']) !!}
                </td>
            </tr>
        </tbody>
    </table>
</section>

@else

    <h3>No data found.</h3>

@endif

@stop
        