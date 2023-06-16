<?php

namespace App\Http\Traits\Parsers;

Trait ViewIndex
{
    
    public function view_index()
    {
        
        $start_time = microtime(true);
        
        $table = $this->table;
        
        
        $data    = "";
        
        $data   .= $this->view_index_start();
        
        $data   .= $this->view_index_search();
        
        $data   .= $this->view_index_errors();
        
        $data   .= $this->view_index_create_button();
        
        $data   .= $this->view_index_list_table();
        
        $data   .= $this->view_index_end();
        
        
        file_write(base_path().'/resources/views/admin/'.$table.'/index.blade.php', $data);
        
        $end_time = microtime(true);
        
        return "index created in ". ($end_time - $start_time);
        
    }
    
    
    private function view_index_start()
    {
        
        $table      = $this->table;
        
        $model      = $this->model;
        
        $controller = $this->controller;
        
        
        $data ="@extends('admin.layout')

@section('title')".str_replace('_',' ',$model)." - {{ settings()->application_name }} @stop

@section('main')

<main class=\"column is-12-desktop is-12-mobile padding-top-10 padding-bottom-20 columns is-multiline\" >

    <section class=\"column is-12 padding-0 margin-bottom-20\">
        <h1 class=\"title is-3\">
            ".str_replace('_',' ',$controller)." 
            <button type=\"button\" class=\"button is-info is-small is-pulled-right\" data-toggle=\"collapse\" data-target=\"#search\" >
                <i class=\"fas fa-search\"></i>
            </button>
            <span class=\"button is-small is-white is-pulled-right\">@if( \$".$table." ) {{ \$".$table."->total() }} ".str_replace('_',' ',$controller)." found @endif</span>
        </h1>
    </section>
    
";
        
        
        return $data;
        
    }
    
    
    private function view_index_end()
    {
        
        $data = "</main>\n\n@stop";
        
        return $data;
        
    }
    
    
    private function view_index_search()
    {
        
        $controller = $this->controller;
        
        $model = $this->model;
        
        $data = "
    <section class=\"column is-12 padding-0 collapse fade\" id=\"search\">
    
    {!! Form::open(['method' =>'post', 'url'=> action('$controller@searchIndex'), 'class'=>'columns is-multiline']) !!} ";
        ;
        
    foreach( (array) $this->columns as $column)
    {
    
        if( $column != 'created_at' && $column != 'updated_at' && !ends_with($column, ['_photo', 'photos', 'image', '_images', '_files', '_file', '_detail', '_details', '_description'] ) ){
            
            if( ends_with($column, '_id')){
                
                $data .= "
        <div class=\"field has-addons column is-3-desktop is-12-mobile\">
            <div class=\"control\">
                <button type=\"button\" class=\"button is-info\">".str_replace('_',' ',ucfirst($column))."</button>
            </div>
            <div class=\"control is-expanded\">
                <div class=\"select is-fullwidth\">
                    {!! Form::select('$column', \App\\$model::pluck('name', 'id'), old('$column') , ['class'=>'select2']) !!}
                </div>
            </div>
        </div>
            ";
                
            } elseif(substr($column, 0, 3) == 'is_'){
                
            $data .= "
        <div class=\"field has-addons column is-3-desktop is-12-mobile\">
            <div class=\"control\">
                <button type=\"button\" class=\"button is-info\">".str_replace('_',' ',ucfirst($column))."</button>
            </div>
            <div class=\"control is-expanded\">
                <div class=\"select is-fullwidth\">
                    {!! Form::select('$column', [ ''=>'-Select-','1'=>'Yes', '0'=>'No'], old('$column')) !!}
                </div>
            </div>
        </div>
            ";
            
            }  elseif( ends_with($column, '_date') ){
                
            $data .= "
        <div class=\"field has-addons column is-3-desktop is-12-mobile\">
            <div class=\"control\">
                <a class=\"button is-info\">
                ".str_replace('_',' ',ucfirst($column))."
                </a>
            </div>
            <div class=\"control\">
                {!! Form::text('$column', old('$column') , ['class'=>'input datepicker']) !!}
            </div>
        </div>
        
            ";
            
            } elseif( ends_with($column, '_time') ){
                
            $data .= "
        <div class=\"field has-addons column is-3-desktop is-12-mobile\">
            <div class=\"control\">
                <a class=\"button is-info\">
                ".str_replace('_',' ',ucfirst($column))."
                </a>
            </div>
            <div class=\"control\">
                {!! Form::text('$column', old('$column') , ['class'=>'input timepicker']) !!}
            </div>
        </div>
            ";
            
            } elseif( $column == 'created_by' || $column == 'updated_by' ){
                
            $data .= "
        <div class=\"field has-addons column is-3-desktop is-12-mobile\">
            <div class=\"control\">
                <button type=\"button\" class=\"button is-primary\">".str_replace('_',' ',ucfirst($column))."</button>
            </div>
            <div class=\"control is-expanded\">
                <div class=\"select is-fullwidth\">
                    {!! Form::select('$column', [], 'null' , ['class'=>'user-search']) !!}
                </div>
            </div>
        </div>
            ";    
                
            } else{
                
            $data .= "
        <div class=\"field has-addons column is-3-desktop is-12-mobile\">
            <div class=\"control\">
                <a class=\"button is-info\">
                ".str_replace('_',' ',ucfirst($column))."
                </a>
            </div>
            <div class=\"control\">
                {!! Form::text('$column', old('$column') , ['class'=>'input']) !!}
            </div>
        </div>
            ";
            
            } 
            
            
        }
        
    }
        
        $data .="
        <div class=\"field has-addons column is-3-desktop is-12-mobile\">
            <div class=\"control\">
                <a class=\"button is-info\">From</a>
            </div>
            <div class=\"control\">
                {!! Form::text('from', old('from') , ['class'=>'input datepicker']) !!}
            </div>
        </div>
        
        <div class=\"field has-addons column is-3-desktop is-12-mobile\">
            <div class=\"control\">
                <a class=\"button is-info\">To</a>
            </div>
            <div class=\"control\">
                {!! Form::text('to', old('to') , ['class'=>'input datepicker']) !!}
            </div>
        </div>

        <div class=\"field is-horizontal column is-12\">
            <div class=\"field-body\">
                <div class=\"field\">
                    <div class=\"control has-text-centered\">
                        <button class=\"button is-info\" type=\"submit\">Search</button>
                    </div>
                </div>
            </div>
        </div>
        
    {!! Form::close() !!}
    
    </section>

";
        
        return $data;
        
    }
    
    
    private function view_index_errors()
    {
        
        $data = "
    <section class=\"column is-12 padding-0\">{!! errors(\$errors) !!}</section>
";
        
        return $data;
        
    }
    
    
    private function view_index_create_button()
    {
        
        $controller = $this->controller;
        
        $data = "
    <section class=\"column is-12 padding-0\">
        
        <a href=\"{{action('$controller@create')}}\" class=\"is-white is-small has-text-dark is-pulled-right padding-top-5 padding-bottom-5 font-size-12\">
            <i class=\"fas fa-plus margin-right-5\"></i> add new
        </a>
    
    </section>
        ";
        
        return $data;
        
    }
    
    
    private function view_index_list_table()
    {
        
        $columns    = $this->columns;
        
        $controller = $this->controller;
        
        $table      = $this->table;
        
        $tr         = str_singular( strtolower( $table ) );
        
        
        $data = "
    <section class=\"column is-12 padding-0\">
    
    <table class=\"table is-bordered is-striped\">
        <thead>
            <tr>"; 
            
            foreach( (array) $columns as $column)
            {
                
                if( ends_with($column, '_id') )
                {
                    
                    $data .= "\n\t\t\t\t<th class=\"offwhite-bg font-weight-700\">".str_replace('_', ' ', substr( ucfirst($column), 0, strlen($column) -3))."</th>";
                    
                } else{
                    
                    if( !ends_with($column, ['_images', '_file', '_files', '_link', '_detail', '_details', '_description']) && $column != 'created_by' && $column != 'updated_by' && $column != 'created_at' )
                    {
                        
                        if( $column == 'updated_at' )
                        {
                            
                    $data .= "\n\t\t\t\t<th class=\"offwhite-bg font-weight-700\">Last Modified</th>";
                            
                        } elseif( starts_with($column, 'is_') ){
                            
                    $data .= "\n\t\t\t\t<th class=\"offwhite-bg font-weight-700\">". ucfirst(substr($column, 3)) ."</th>";
                            
                        } elseif( ends_with($column, ['_image', '_photo']) ){
                            
                    $data .= "\n\t\t\t\t<th class=\"offwhite-bg font-weight-700\">". ucfirst(substr($column, 0, -6)) ."</th>";
                            
                        } else {
                    
                    $data .= "\n\t\t\t\t<th class=\"offwhite-bg font-weight-700\">".str_replace('_', ' ', ucfirst($column) )."</th>";
                            
                        }
                    
                    }
                }
                
            }
            
            $data .="
                <th class=\"offwhite-bg font-weight-700\" width=\"50\">More</th>
                <th class=\"offwhite-bg font-weight-700\" width=\"50\"></th>
            </tr>
        </thead>
        <tbody>
            @if(\$".$table.")
                @foreach(\$".$table." as \$".$tr.")
                    <tr>";
                    
                    foreach( (array) $columns as $td)
                    {
                        
                        if( !ends_with($td, ['_images', '_file', '_files', '_link', '_detail', '_details', '_description']) && $td != 'created_by' && $td != 'updated_by' && $td != 'created_at' )
                        {
                            
                            if(substr($td, 0, 3) == 'is_'){
                            
                                $data .= "\n\t\t\t\t\t\t<td>{{ yn(\$".$tr."->".$td.") }}</td>";
                                
                            } elseif( ends_with($td, ['_photo', '_image']) ){
                            
                                $data .= "\n\t\t\t\t\t\t<td><a href=\"{{\$".$tr."->".$td."}}\" class=\"button is-small is-dark\">{!! thumb(\$".$tr."->".$td.") !!}</a></td>";
                                
                            } elseif( ends_with( $td, ['_at', '_date']) ){
                            
                                $data .= "\n\t\t\t\t\t\t<td>{{\$".$tr."->".$td."->format('Y-M-d')}}</td>";
                                
                            }  elseif( $td == 'updated_at' ){
                            
                                $data .= "\n\t\t\t\t\t\t<td>{{\$".$tr."->".$td."->format('Y-M-d')}}</td>";
                                
                            } elseif( ends_with($td, '_id') ){

                            $model_name  = str_singular($td);
                            $data .= "\n\t\t\t\t\t\t<td>@if(\$".$tr."->".$model_name.") {{\$".$tr."->".$model_name."->name}} @endif</td>";
                            
                            } else{
                            
                                $data .= "\n\t\t\t\t\t\t<td>{{\$".$tr."->".$td."}}</td>";
                                
                            }
                            
                        }
                        
                    }
                
                $data .="
                        <td>
                            <button type=\"button\" 
                                    class=\"button is-small is-warning\" 
                                    data-container=\"body\" 
                                    data-toggle=\"popover\" 
                                    data-placement=\"top\"
                                    data-trigger=\"focus\"
                                    data-html=\"true\"
                                    data-content='
                                        {!! views(\"$controller\", \$".$tr."->id, 'Show', [\"class\"=>\"button is-small is-dark\"]) !!}
                                        {!! edits(\"$controller\", \$".$tr."[\"id\"], 'Modify', [\"class\"=>\"button is-small is-info\"]) !!}
                                    '>
                                <i class=\"fas fa-cogs\"></i>
                            </button>
                        </td>
                        <td>
                            <a  tabindex=\"0\" 
                                class=\"button is-small is-danger\" 
                                role=\"button\" 
                                data-toggle=\"popover\" 
                                data-trigger=\"focus\" 
                                data-html=\"true\"
                                data-placement=\"left\"
                                data-content='
                                    <div class=\"box\">
                                        <h4>Remove permanently?</h4>
                                        <span class=\"buttons\">
                                            {!! deletes(\"$controller\", $".$tr."[\"id\"], \"YES\", [\"class\"=>\"button is-small is-danger\"]) !!}
                                            <button class=\"button is-small is-success\">NO</button>
                                        </span>
                                    </div>
                                '>
                                <i class='fas fa-trash'></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
    {!! \$".$table."->render() !!}
    </section>
        ";
        
        return $data;
        
    }
    
}