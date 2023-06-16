@extends('admin.layout')

@section('main')

<h3>Role</h3>

<table class="table">
    <thead>
        <tr>
            <th>Serial</th>
            <th>Name</th>
            <th>Modify</th>
        </tr>
    </thead>
    <tbody>
        @if($role)
            <tr>
                <td>{{$role['id']}}</td>
                <td>{{$role['name']}}</td>
                <td>
                    <a href="{{action('Roles@edit',[$role['id']])}}" class="btn btn-default btn-sm btn-rounded" title="Edit role"><span class="fa fa-pencil"></span></a>
                    <a href="{{action('Roles@edit',[$role['id']])}}" class="btn btn-default btn-sm btn-rounded" title="Edit permission"><i class="fa fa-random"></i></a>
                    <a href="{{action('Roles@edit',[$role['id']])}}" class="btn btn-danger btn-sm btn-rounded" title="Delete role"><span class="fa fa-times"></span></a>
                </td>
            </tr>
        @endif
    </tbody>
</table>

@stop