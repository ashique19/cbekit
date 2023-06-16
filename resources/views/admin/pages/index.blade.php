@extends('admin.layout')

@section('main')

<section class="hero is-fullheight is-white is-bold">
    <div class="hero-body">
        <div class="container">
            
            <section class="columns is-multiline">
                
                <div class="column is-12">
                    <h1 class="title has-text-primary is-1">
                        PAGE @if($pages) : {{$pages->total()}} @endif
                    </h1>
                </div>
                
                <div class="column is-12 columns is-multiline">

                    {!! Form::open(['class'=>'column is-12 columns is-multiline', 'method' =>'post', 'url'=> action('Pages@searchIndex')]) !!} 
                        <div class="column is-4-desktop is-12-mobile">
                            {!! Form::label('name', 'Name: ') !!}
                            {!! Form::text('name', old('name') , ['class'=>'form-control']) !!}
                        </div>
                            
                        <div class="column is-4-desktop is-12-mobile">
                            {!! Form::label('from', 'From: ') !!}
                            {!! Form::text('from', old('from') , ['class'=>'form-control datepicker']) !!}
                        </div>
                        
                        <div class="column is-4-desktop is-12-mobile">
                            {!! Form::label('to', 'To: ') !!}
                            {!! Form::text('to', old('to') , ['class'=>'form-control datepicker']) !!}
                        </div>
                        
                        <div class="column is-12 has-text-centered">
                            {!! Form::submit('Search', ['class'=>'button is-info']) !!}
                            <a href="{{ action('Pages@create') }}" class="button is-primary">Create</a>
                        </div>
                        
                    {!! Form::close() !!}
                
                </div>
                
                <div class="column is-12">
                    {!! errors($errors) !!}
                </div>
                
                <div class="column is-12">
                    
                    <table class="table">
                        <thead>
                            <tr>
                				<th>Id</th>
                				<th>Name</th>
                                <th width="75">Modify</th>
                                <th width="75">Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($pages)
                                @foreach($pages as $page)
                                    <tr>
                						<td>{{$page->id}}</td>
                						<td>
                						    <a href="{{action('Pages@show', $page->id)}}" class="link" title="show page in detail">{{$page->name}}</a>
                						</td>
                                        <td>
                                            <a href="{{action('Pages@edit', $page['id'])}}" class="button is-small is-warning" title="Edit page"><span class="fa fa-edit"></span></a>
                                        </td>
                                        <td>
                                            {!! Form::open(['method'=>'delete', 'url'=> action('Pages@destroy', $page->id) ]) !!}
                                            {!! Form::hidden('id', $page->id ) !!}
                                            <button href="{{action('Pages@edit',[$page->id])}}" class="button is-small is-danger" title="Delete page ">
                                                <span class="fa fa-times"></span>
                                            </button>
                                            {!! Form::close() !!}
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                    {!! $pages->render() !!}
                </div>
                
            </section>
            
        </div>
    </div>
</section>

@stop
