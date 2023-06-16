<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Parser extends Controller
{
    
    use \App\Http\Traits\Parsers\Model,
        \App\Http\Traits\Parsers\Controller,
        \App\Http\Traits\Parsers\Request,
        \App\Http\Traits\Parsers\ViewCreate,
        \App\Http\Traits\Parsers\ViewIndex,
        \App\Http\Traits\Parsers\ViewEdit,
        \App\Http\Traits\Parsers\ViewShow;
    
    private $type;
    private $table;
    private $columns;
    private $hasMany;
    private $model;
    private $controller;
    private $request;
    
    
    public function __construct($type, $table, $columns, $hasMany)
    {
        
        $this->type         = $type;
        
        $this->table        = $table;
        
        $this->columns      = $columns;
        
        $this->hasMany      = $hasMany;
        
        $this->model        = ucfirst(str_singular($table));
        
        $this->controller   = str_plural($this->model);
        
        $this->request      = strtolower($table)."StoreRequest";
        
    }
    
    
    /**
     * Execute parser
    */
    public function make()
    {
        
        $method_to_call = strtolower( str_replace('-', '_', $this->type) );
        
        if( $method_to_call == 'crud' )
        {
            
            call_user_func( array( $this , 'model') );
            call_user_func( array( $this , 'controller') );
            call_user_func( array( $this , 'request') );
            call_user_func( array( $this , 'view_create') );
            call_user_func( array( $this , 'view_index') );
            call_user_func( array( $this , 'view_edit') );
            call_user_func( array( $this , 'view_show') );
            
        } else{
        
            return call_user_func( array( $this , $method_to_call) );
        
        }
                
    }
    
}
