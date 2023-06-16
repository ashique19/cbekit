@extends('admin.layout')
@section('title')Dashboard - {{ settings()->application_name }} @stop

@section('main')

<article class="columns is-multiline">

    <aside class="column is-12-desktop is-12-mobile">
        
        <h1 class="title is-3">
            <span class="has-text-info">STUDENTS:</span> ({{ $users->count() > 0 ? $users->total() : 0 }})
        </h1>
        
        {!! errors( $errors ) !!}
        
    </aside>
    
    <main class="column is-12-desktop is-12-mobile">
        
        <table class="table is-fullwidth is-narrow is-responsive ">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Type</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Country</th>
                    <th>Date</th>
                    <th></th>
                    <th></th>
                </tr> 
            </thead>
            <tbody class="font-size-12">
                @if( $users->count() > 0 )
                @foreach( $users as $user )
                
                <th>
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->roles ? $user->roles->name : "" }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->contact }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->address }}</td>
                        <td>{{ $user->country ? $user->country->name : "" }}</td>
                        <td>{{ $user->created_at ? $user->created_at->format('Y-M-d H:i') : "" }}</td>
                        <td>
                            <button 
                                type="button" 
                                class="button is-small is-danger"
                                data-toggle="popover"
                                data-trigger="click"
                                data-placement="left"
                                data-html="true"
                                data-content='
                                <div class="box">
                                    <h4 class="subtitle is-4">Are you sure?</h4>
                                    <p class="has-text-centered">
                                        <a class="button is-small is-danger" href="{{ action('AdminUsers@deactivateUser', str_random(40).$user->id.str_random(20)  ) }}">YES</a>
                                    </p>
                                </div>
                                '
                            >De-activate</button>
                        </td>
                        <td>
                            <button type="button" edit-user-modal="{{ $user->id }}" class="button is-small is-warning">Edit Data</button>
                        </td>
                    </tr>
                </th>
                
                @endforeach
                @endif
            </tbody>
        </table>
        
    </main>
    
    <aside class="column is-12-desktop is-12-mobile">
        
        {!! $users->render() !!}
        
    </aside>

</article>


    
<div class="modal" id="edit-user-modal">
    <div class="modal-background"></div>
    <div class="modal-content">
        
        
        
    </div>
    <button class="modal-close is-large" aria-label="close" edit-user-modal ></button>
</div>


@section('js')   

<script>
    
$(document).ready(function(){
    
    $('[edit-user-modal]').click(function(e){
        
        e.preventDefault();
        
        let id = $(this).attr('edit-user-modal');
        
        if( $('#edit-user-modal').hasClass('is-active') ){
            
            $('#edit-user-modal').removeClass('is-active').find('.modal-content').empty();
            
        } else{
            
            $('#edit-user-modal').addClass('is-active')
                                 .find('.modal-content')
                                 .html(`<span class="button transparent-border is-loading margin-100"></span>`)
                                 .load('/admin/user/user-edit-by-admin/'+id );
            
        }
        
    })
    
})
    
</script>

@stop


@stop
        