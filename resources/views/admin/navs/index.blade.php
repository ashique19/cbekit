@extends('admin.layout')

@section('main')

<h3>Navigation Control</h3>





@if($errors->any())
    <ul>
    @foreach($errors->all() as $error)
        <li>{{$error}}</li>    
    @endforeach
    </ul>
@endif






@if($nav_parents)

    
    
    <ul class="list-group">
        
        @foreach($nav_parents as $parent)
        
            <li class="list-group-item">
                
                <h4  data-toggle="collapse" data-target="#{{$parent->id}}">{{$parent->name}} <a href="#"><i class="fa fa-edit edit_nav"></i></a></h4>
                
                {!! Form::open([ 'method' => 'patch', 'url'=> action('Navs@update', $parent->id) ,'class'=>'form-inline collapse', 'role'=>'form', 'id'=>$parent->id]) !!}
                    {!! Form::hidden('id',$parent->id) !!}
                    
                    {!! Form::text('name',$parent->name, ['class'=>'form-control']) !!}
                    
                    {!! Form::select('type', [0=>'parent', 1=>'children'], $parent->type, ['class'=>'form-control']) !!}
                    
                    {!! Form::text('icon',$parent->icon, ['class'=>'form-control', 'placeholder'=>'enter icon (optional)']) !!}
                    
                    {!! Form::select('parent',$parent_list, null, ['class'=>'form-control']) !!}
                    
                    {!! Form::select('location',[1=>'left', 2=>'top'], $parent->location, ['class'=>'form-control']) !!}
                    
                    {!! Form::select('is_public',[0=>'no', 1=>'yes'], $parent->is_public, ['class'=>'form-control', 'title'=>'is public nav?']) !!}
                    
                    {!! Form::submit('Update', ['class'=>'btn btn-info']) !!}
                {!! Form::close() !!}
                
            </li>
            
            
            <?php
            
                $children = [];
                
                foreach($nav_children as $child){
                    
                    if($child['parent'] == $parent->id)
                    {
                        
                        $children[] = $child;
                        
                    }
                    
                }
                
            
            ?>
            
            
            @if($children)
            
                <ul class="list-group">
            
                    @foreach($children as $child)
                    
                        <li class="list-group-item">
                            
                            <a href="#"  data-toggle="collapse" data-target="#{{$child['id']}}">{{$child['name']}}</a>
                        
                            {!! Form::open([ 'method' => 'patch', 'url'=> action('Navs@update', $parent->id) ,'class'=>'form-inline collapse', 'role'=>'form', 'id'=>$child['id'] ]) !!}
                            {!! Form::hidden('id',$child['id']) !!}
                            {!! Form::text('name',$child->name, ['class'=>'form-control']) !!}
                            {!! Form::text('route',$child->route, ['class'=>'form-control', 'placeholder'=>'enter route (optional)']) !!}
                            {!! Form::text('icon',$child->icon, ['class'=>'form-control', 'placeholder'=>'enter icon (optional)']) !!}
                            {!! Form::select('type', ['parent', 'children'] , 1, ['class'=>'form-control']) !!}
                            {!! Form::select('parent', $parent_list, $child['parent'], ['class'=>'form-control']) !!}
                            {!! Form::select('location',[1=>'left', 2=>'top'], $parent->location, ['class'=>'form-control']) !!}
                            {!! Form::select('is_public',[0=>'no', 1=>'yes'], $parent->is_public, ['class'=>'form-control', 'title'=>'is public nav?']) !!}
                            {!! Form::submit('Update', ['class'=>'btn btn-info']) !!}
                            {!! Form::close() !!}
                        
                        </li>
                    
                    @endforeach
                
                </ul>
            
            @endif
            
            
        
        @endforeach
        
    </ul>
    
    

@endif


@stop