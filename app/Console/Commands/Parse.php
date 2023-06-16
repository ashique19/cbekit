<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Parse extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse 
                                { table : Database table name}
                                { type : Accepted values - model, controller, request, view_index, view_create, view_edit, view_show, views, view_all_in_one, crud} 
                                { --columns="" : If column list is given, only given columns will be parsed, otherwise all columns of the table.}
                                { --hasMany="" : hasMany methods seperated by comma. e.g. roles,pages,newsletters.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Advanced Laravel CRUD type parser';
    
    
    private $type = "";
    
    private $table = "";
    
    private $columns = [];
    
    private $hasMany = [];
    
    
    /**
     * List columns to work on
     * 
     * @columns = name of columns ( ',' separated)
     * 
     * if no column names are given, all table columns will be selected
    */
    private function columns($columns = '')
    {
        
        $columns = explode(',' , $columns);
        
        foreach( $columns as $column )
        {
            
            strlen( str_replace( '"', '',cleanString( $column ) ) ) > 0 ? $this->columns[] = str_replace( '"', '',cleanString( $column ) ) : false;
            
        }
        
        $table_columns  = \Schema::getColumnListing(strtolower($this->table));
        
        $this->columns = count( $this->columns ) > 0 ? array_intersect( $this->columns, $table_columns ) : $table_columns;
        
    }
    
    
    
    private function hasMany( $hasManys = '' )
    {
        
        $hasManys = explode(',' , $hasManys);
        
        foreach( $hasManys as $hasMany )
        {
            
            strlen( str_replace( '"', '', cleanString( $hasMany ) ) ) > 0 ? $this->hasMany[] = str_replace( '"', '',cleanString( $hasMany ) ) : false;
            
        }
        
        
    }
    
    
    
    private function make()
    {
        
        $parser = new \App\Http\Controllers\Parser($this->type, $this->table, $this->columns, $this->hasMany);
        
        return $parser->make();
        
    }

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        
        $start = microtime(true);
        
        $this->type = strtolower( $this->argument('type') );
        
        $this->table = strtolower( $this->argument('table') );
        
        $this->columns( $this->option('columns') );
        
        $this->hasMany( $this->option('hasMany') );
        
        $end = microtime(true);
        
        $this->info( $this->make()."
            \n\nFull process elapsed time ". ($end - $start)." s. 
            Route::get('".$this->table."/search', '".ucfirst( strtolower( $this->table ) )."@search');
            Route::post('".$this->table."/search', '".ucfirst( strtolower( $this->table ) )."@searchIndex');
            Route::resource('".$this->table."', '".ucfirst( strtolower( $this->table ) )."');" );
        
    }
}
