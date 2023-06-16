@extends('admin.layout')

@section('main')



<article class="columns is-multiline">

    <aside class="column is-12-desktop is-12-mobile">
        
        <h1 class="title is-3">
            <span class="has-text-info">USERS:</span> ({{ $users->count() > 0 ? $users->total() : 0 }})
            <button type="button" class="is-pulled-right button is-small is-outlined" data-toggle="collapse" data-target="#search" aria-expanded="false" aria-controls="search">
                <i class="fa fa-search font-size-14"></i>
            </button>
        </h1>
        
        {!! errors( $errors ) !!}
        
    </aside>
    
    <div class="collapse" id="search">
        
        <section class="column is-12-desktop is-12-mobile is-12-tablet">
            {!! Form::open(['method'=> 'POST', 'url'=> action('Users@postSearch'), 'class'=> 'columns is-multiline box' ]) !!}
            
            <div class="field has-addons column is-3-desktop is-4-tablet is-12-mobile">
                <div class="control">
                    <a class="button is-info">
                    Name
                    </a>
                </div>
                <div class="control">
                    {!! Form::text('name', null, ['class'=> 'input']  ) !!}
                </div>
            </div>
            
            <div class="field has-addons column is-3-desktop is-4-tablet is-12-mobile">
                <div class="control">
                    <a class="button is-info">
                    Role
                    </a>
                </div>
                <div class="control  is-expanded">
                    <div class="select  is-fullwidth">
                    {!! Form::select('role', \App\Role::pluck('name', 'id'), null, ['placeholder'=> '-Select-']  ) !!}
                    </div>
                </div>
            </div>
            
            <div class="field has-addons column is-3-desktop is-4-tablet is-12-mobile">
                <div class="control">
                    <a class="button is-info">
                    Email
                    </a>
                </div>
                <div class="control">
                    {!! Form::text('email', null, ['class'=> 'input']  ) !!}
                </div>
            </div>
            
            <div class="field has-addons column is-3-desktop is-4-tablet is-12-mobile">
                <div class="control">
                    <a class="button is-info">
                    Phone
                    </a>
                </div>
                <div class="control">
                    {!! Form::text('phone', null, ['class'=> 'input']  ) !!}
                </div>
            </div>
            
            <div class="field has-addons column is-3-desktop is-4-tablet is-12-mobile">
                <div class="control">
                    <a class="button is-info">
                    Address
                    </a>
                </div>
                <div class="control">
                    {!! Form::text('address', null, ['class'=> 'input']  ) !!}
                </div>
            </div>
            
            <div class="field has-addons column is-3-desktop is-4-tablet is-12-mobile">
                <div class="control">
                    <a class="button is-info">
                    Country
                    </a>
                </div>
                <div class="control is-expanded">
                    <div class="select is-fullwidth">
                    {!! Form::select('country_id', \App\Country::pluck('name', 'id'), null, ['class'=> 'select2']  ) !!}
                    </div>
                </div>
            </div>
            
            <div class="field column is-12-desktop is-12-tablet is-12-mobile">
                <div class="control has-text-centered">
                    {!! Form::submit('Search', ['class'=> 'button is-info']) !!}
                </div>
            </div>
            
            {!! Form::close() !!}
        </section>
        
    </div>
    
    <main class="column is-12-desktop is-12-tablet is-12-mobile">
        
        <table class="table is-narrow is-fullwidth">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Role</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Phone</th>
                    <th>View</th>
                    <th>Modify</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                @if($users)
                    @foreach($users as $user)
                        
                        <tr>
                            <td>{{$user->name}}</td>
                            <td>@if($user->roles){{$user->roles->name}} @endif</td>
                            <td>{{$user->email}}</td>
                            <td>{{$user->address}}</td>
                            <td>{{$user->contact}}</td>
                            <td><a href="{{action('Users@show', $user->id)}}" class="button is-info is-small"><i class="fa fa-expand"></i></a></td>
                            <td>
                                <a href="{{action('Users@edit', $user->id)}}" class="button is-dark is-small"><i class="fa fa-edit"></i></a>
                            </td>
                            <td>
                                {!! Form::open(['url'=>action('Users@destroy', $user->id), 'method'=>'DELETE']) !!}
                                {!! Form::hidden('id',$user->id) !!}
                                <button class="button is-small is-danger"> <i class="fa fa-trash-o"></i> </button>
                                {!! Form::close() !!}
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
        
        {!! $users->render() !!}
        
    </main>
    
</article>




@stop