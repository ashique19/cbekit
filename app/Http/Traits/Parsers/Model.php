<?php

namespace App\Http\Traits\Parsers;

Trait Model
{
    
    public function model()
    {
        
        $start_time = microtime(true);
        
        $table      = $this->table;
        
        $columns    = $this->columns;
        
        $model      = $this->model;
        
        $data       = "";
        
        
        $data      .= "<?php \n\nnamespace App; \n\nuse Illuminate\Database\Eloquent\Model;";
        
        $data      .= "\n\nclass $model extends Model \n{";
        
        $data      .= "\n\n\tprotected \$table = \"$table\";";
        
        $data      .= "\n\n\tprotected \$fillable = [\n\t\t'".implode("', \n\t\t'",$columns)."'\n\t];";
        
        $data      .= $this->model_casts();
        
        $data      .= $this->model_dates();
        
        $data      .= $this->model_belongs_to();
        
        $data      .= $this->model_scope();
        
        $data      .= $this->hasMany();
        
        $data      .= $this->model_created_updated_by();
        
        $data      .= $this->model_boot();
        
        $data      .= "\n\n}";
        
        
        file_write(app_path().'/'.$model.'.php', $data);
        
        $end_time   = microtime(true);
        
        $elapsed_time = $end_time - $start_time;
        
        return "Model $model created in $elapsed_time s";
        
    }
    
    
    private function model_casts()
    {
        
        $images_or_files = "\n\n\n\t/**\n\t* Arrays will be stored as json in database and retrieved and parsed as array\n\t*/";
        
        $images_or_files .= "\n\tprotected \$casts = [";
        
        foreach( (array) $this->columns as $column)
        {
            
            if(substr($column, -7) == '_images' || substr($column, -6) == '_files')
            {
                
                $images_or_files .= "\n\t\t'$column'=> 'array',";
                
            }
        }
        
        $images_or_files .= "\n\t];";
        
        return $images_or_files;
        
    }
    
    
    private function model_dates()
    {
        
        $dates = "";
        
        $date_columns = array_filter( array_map(function($column){ return (substr($column, -5) == '_date' || substr($column, -3) == '_at') ? $column : false; }, (array) $this->columns ) );
            
        $dates = count( $date_columns ) > 0 ? "'".implode("', '", $date_columns)."'" : ""; 
            
        return strlen($dates) > 2 ? "\n\n\n\t/**\n\t* Dates will be parsed as Carbon instance\n\t*/\n\tprotected \$dates = [$dates];\n" : "";
        
    }
    
    
    private function model_belongs_to()
    {
        
        $data = "";
        
        foreach( (array) $this->columns as $column)
        {
            
            if(substr($column, -3, 3) == '_id')
            {
                
                $model = ucfirst(str_singular(substr($column, 0, strlen($column)-3)));
                    
                    $data .= "\n\n\n\t/*\n\t* $column belongs to \App\\$model \n\t*/";
                    
                    $data .= "\n\tpublic function $model()\n\t{\n\n\t\treturn \$this->belongsTo('\App\\$model');\n\n\t}";
            }
        }
        
        return $data;
        
    }
    
    
    private function model_scope()
    {
        
        $data = "";
        
        foreach( (array) $this->columns as $column)
        {
            
            if(substr($column, 0, 3) == 'is_')
            {
                
                $scope = studly_case(substr($column, 3));
                
                $data .="\n\n\n\t/**\n\t* @$column : 0 = no, 1 = yes \n\t*/";
                
                $data .="\n\tpublic function scope$scope(\$query)\n\t{\n\n\t\treturn \$query->where('$column', 1);\n\n\t}";
                
            }
        }
        
        return $data;
        
    }
    
    
    private function model_boot_creating_link()
    {
        
        $link = "";
        
        foreach( (array) $this->columns as $column)
        {
            
            if( substr($column, -4) == 'link' )
            {
                
                if(array_search('created_by', (array) $this->columns) != false)
                {
                
            $link .="
            /**
             * 
             * Prepare unique link for the blog
             * 
             */
            \$item = new self();
            
            \$link = str_slug(\$model->name);
            
            \$model->link = \$item->where('link', 'like', \$link)->first() ? \$link.'-'.(\$item->where('link', 'like', \$link.'%')->count()+1) : \$link;
            
            ";
                
                }
                
            }
            
        }
        
        return $link;
        
    }
    
    
    private function model_created_updated_by()
    {
        
        $data = "";
        
        foreach( (array) $this->columns as $column)
        {
            
            if($column == 'created_by')
            {
                    
                    $data .= "\n\n\n\tpublic function createdBy()\n\t{\n\n\t\treturn \$this->belongsTo('\App\User', 'created_by');\n\n\t}";
            }
            
            if($column == 'updated_by')
            {
                
                $data .="\n\n\n\tpublic function updatedBy()\n\t{\n\n\t\treturn \$this->belongsTo('\App\User', 'updated_by');\n\n\t}";
            }
        }
        
        return $data;
        
    }
    
    
    private function model_boot()
    {
        
        $link = $this->model_boot_creating_link();
        
        $created_updated_by = $this->model_created_updated_by();
        
        $model = $this->model;
        
        
        $data = "\n\n\n\tpublic static function boot()\n\t{\n\n\t\tparent::boot();\n\n\t\tstatic::creating(function(\$model)\n\t\t{
            ";
        
        if( strlen($created_updated_by) > 10 )
        {
            
        $data .="\n\t\t\tif(auth()->user())\n\t\t\t{\n\n\t\t\t\t\$model->created_by = auth()->user()->id;\n\n\t\t\t\t\$model->updated_by = auth()->user()->id;\n\n\t\t\t}
        ";
        
        }
        
        $data .= "\n$link
                
        });
            
        ";
        
        if( strlen($created_updated_by) > 10 )
        {
            
        $data .= "
        
        static::updating(function(\$model)
        {
    
            if(auth()->user())
            {
                
                \$model->updated_by = auth()->user()->id;
                
            }
            
        });
            
        ";
        
        }
        
        
        $data .= "\n\n\t}
        
        ";
        
        return $data;
        
    }
    
    
    private function hasMany()
    {
        
        $data = "";
        
        if( count( $this->hasMany ) > 0 )
        {
            
            foreach($this->hasMany as $hasMany)
            {
                
                $model = ucfirst( str_singular( $hasMany ) );
                
                $data .= "\n\n
    /**
    * ".$this->table." has many $hasMany
    */
    public function $hasMany()
    {
        
        return \$this->hasMany('\App\\$model');
        
    }
                ";
                
            }
            
        }
        
        return $data;
        
    }
    
    
    
}