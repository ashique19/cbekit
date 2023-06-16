<?php

namespace App\Http\Traits\Parsers;


Trait Controller{
    
    public function controller()
    {
        
        $start_time  = microtime(true);
        
        $controller  = $this->controller;
        
        $data        = "";
        
        
        $data       .= $this->controller_start();
        
        $data       .= $this->controller_index();
        
        $data       .= $this->controller_search_index();
        
        $data       .= $this->controller_create();
        
        $data       .= $this->controller_show();
        
        $data       .= $this->controller_store();
        
        $data       .= $this->controller_edit();
        
        $data       .= $this->controller_update();
        
        $data       .= $this->controller_delete();
        
        $data       .= $this->controller_end();
        
        
        
        file_write(app_path().'/Http/Controllers/'.$controller.'.php', $data);
        
        $end_time    = microtime(true);        
        
        return "Controller $controller created in ". ($end_time - $start_time) ." s" ;
        
    }
    
    
    private function controller_start()
    {
        
        $request = $this->request;
        
        $controller = $this->controller;
        
        $model = $this->model;
        
        $data = "<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\\$request;
use App\\$model;

class $controller extends Controller
{
    
    use \App\Http\Traits\SingleFile,
        \App\Http\Traits\MultiFiles,
        \App\Http\Traits\SingleImage,
        \App\Http\Traits\MultiImages;
    
    ";

        
        return $data;
        
    }
    
    
    private function controller_end()
    {
        
        $data = "\n\n}";
        
        return $data;
        
    }
    
    
    private function controller_index()
    {
        
        $table = $this->table;
        
        $model = $this->model;
        
        $data = "\n\n
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        return view('admin.$table.index', ['$table'=> $model::latest()->paginate(40)]);
        
    }
        ";
        
        return $data;
        
    }
    
    
    private function controller_search_index()
    {
        
        $model = $this->model;
        
        $table = $this->table;
        
        $data  ="
    /**
     * Searches the listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function searchIndex(Request \$request)
    {
    
        \$search = array_filter(\$request->all());
        unset(\$search['_token']);
        
        \$result\t=\tnew $model;
      
        (\$request->input('from'))  ? \$result = \$result->where('created_at', '>', \$request->input('from').' 00:00:00') : false;
        (\$request->input('to'))    ? \$result = \$result->where('created_at', '<', \$request->input('to').' 23:59:59') : false;
    ";
    
    
    foreach( (array) $this->columns as $column )
    {
        
        if($column != 'created_at' && $column != 'updated_at' && !ends_with($column, '_file') && !ends_with($column, '_files') && !ends_with($column, '_image') && !ends_with($column, '_images') && !ends_with($column, '_link') && !ends_with($column, '_link') && !ends_with($column, '_detail') && !ends_with($column, '_details') && !ends_with($column, '_description'))            
        {
            
            if( substr($column, -3, 3) == '_id' || substr($column, 0, 2) == 'id' || starts_with( $column, 'is_' ))
            {
                
                $data .= "\n\t\t(\$request->input('$column'))\t?\t\$result = \$result->where('$column', \$request->input('$column')) : false;";
                
            } else{
                
                $data .= "\n\t\t(\$request->input('$column'))\t?\t\$result = \$result->where('$column', 'like', '%'.\$request->input('$column').'%') : false;";
                
            }
            
        }
        
    }
    
    $data .="
        
        return view('admin.$table.index', ['$table'=> \$result->latest()->paginate(40)]);
        
    }
    
    ";
        
        return $data;
        
    }
    
    
    private function controller_create()
    {
        
        $table = $this->table;
        
        $data ="

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        return view('admin.$table.create' );
            
    }
        
        ";
        
        return $data;
        
    }
    
    
    private function controller_show()
    {
        
        $table = $this->table;
        
        $instance = str_singular( strtolower( $table ) );
        
        $data ="

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(\$id)
    {
    
        \$$instance = ".$this->model."::find(\$id);
        
        return view('admin.$table.show', compact('$instance') );
            
    }
        
        ";
        
        return $data;
        
    }
    
    
    private function controller_store()
    {
        
        $request = $this->request;
        
        $columns = $this->columns;
        
        $model   = $this->model;
        
        $controller = $this->controller;
        
        $data ="

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  \$request
     * @return \Illuminate\Http\Response
     */
    public function store($request \$request)
    {
        ";
        
        foreach($columns as $column)
        {
            
            if( ends_with($column, '_photo') || ends_with($column, '_image') )
            {
                
                $input_column   = $column."s";
                $folder         = substr($column, 0, strlen($column)-6);
                
                $data .="
                
        \$request['$column'] = \$this->storeImage(\$request, '$input_column', '$folder');\n";
                
            } elseif( ends_with($column, '_images') || ends_with($column, '_photos'))
            {
                
                $input_column   = substr($column, 0, -1);
                $folder         = substr($column, 0, strlen($column)-7);
                
                $data .="
                
        \$request['$column'] = \$this->storeImages(\$request, '$input_column', '$folder');\n";
                
            } elseif(substr($column, -6) == '_files')
            {
                
                $input_column   = substr($column, 0, -1);
                $folder         = substr($column, 0, strlen($column)-6);
                
                $data .="
                
        \$request['$column'] = \$this->storeFiles(\$request, '$input_column', '$folder');\n";
                
            } elseif(substr($column, -5) == '_file')
            {
                
                $input_column   = $column."s";
                $folder         = substr($column, 0, strlen($column)-5);
                
                $data .="
                
        \$request['$column'] = \$this->storeFile(\$request, '$input_column', '$folder');\n";
                
            }
            
        }
        
        $data .="
        
        \$save_success = $model::create(\$request->all());
        
        
        if(\$save_success)
        {
        
            return back()->withErrors('Data has been stored successfully.');
        
        } else{
            
            return back()->withInput()->withErrors('Failed to store data. Please check data and retry.');
            
        }
    
    }
    ";
        
        return $data;
        
    }
    
    
    private function controller_edit()
    {
        
        $model = $this->model;
        
        $table = $this->table;
        
        $data = "
    
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  \$id
     * @return \Illuminate\Http\Response
     */
    public function edit(\$id)
    {
    
        \$".strtolower($model)." = $model::find(\$id); ";
        
        $data.="
        
        return view('admin.$table.edit', compact('".strtolower($model)."') );
        
    }
        ";
        
        return $data;
        
    }
    
    
    private function controller_update()
    {
        
        $request = $this->request;
        
        $model = $this->model;
        
        $controller = $this->controller;
        
        $columns = $this->columns;
        
        $data = "
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  \$request
     * @param  int  \$id
     * @return \Illuminate\Http\Response
     */
    public function update($request \$request, \$id)
    {
    
        \$".strtolower($model)." = $model::find(\$id);
        ";
        
        $instance = "\$".strtolower($model);
        
    foreach($columns as $column)
    {
        
        if( ends_with($column, '_photo') || ends_with($column, '_image') )
        {
            
            $input_name     = $column."s";
            $delete_photo   = $column."_delete";
            $folder         = substr($column, 0, strlen($column)-6);
            
            $data .="
            
        \$request['$column'] = \$this->updateImage(\$request, $instance, '$input_name', '$column', '$folder', '$delete_photo');
        ";
            
        } elseif( ends_with($column, '_images' ) || ends_with($column, '_photos' ) )
        {
            
            $input_column   = $column;
            $delete_photo   = $column."_delete";
            $request_input  = substr($column, 0, -1);
            $folder         = substr($column, 0, strlen($column)-7);
            
            $data .="
            
        \$request['$input_column'] = \$this->updateImages(\$request, $instance, '$input_column', '$column', '$folder', '$delete_photo');
        ";
            
        } elseif(substr($column, -6) == '_files')
        {
            
            $input_column   = $column;
            $delete_files   = $column."_delete";
            $request_input  = substr($column, 0, -1);
            $folder         = substr($column, 0, strlen($column)-6);
            
            $data .="
            
        \$request['$input_column'] = \$this->updateFiles(\$request, $instance, '$input_column', '$column', '$folder', '$delete_files');
        ";
            
        } elseif(substr($column, -5) == '_file')
        {
                
            $input_column   = $column."s";
            $delete_file    = $column."_delete";
            $folder         = substr($column, 0, strlen($column)-5);
            
            $data .="
            
        \$request['$column'] = \$this->updateFile(\$request, $instance, '$input_column', '$column', '$folder', '$delete_file' );
                ";
                
            }
    }
    
        $data .="
        
        \$save_success = $model::find(\$id)->update(\$request->all());
        
        
        if(\$save_success)
        {
        
            return back()->withErrors('Data has been updated successfully.');
        
        } else{
            
            return back()->withInput()->withErrors('Failed to store data. Please check data and retry.');
            
        }
        
    }
        ";
        
    return $data;
        
    }
    
    
    private function controller_delete()
    {
        
        $model = $this->model;
        
        $controller = $this->controller;
        
        $columns = $this->columns;
        
        $data = "
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  \$id
     * @return \Illuminate\Http\Response
     */
    public function destroy(\$id, Request \$request)
    {
        
        \$".strtolower($model)." = $model::find(\$id);
        
        
        if(\$".strtolower($model).")
        {";
    
    $instance = "\$".strtolower($model);
    
    foreach($columns as $column)
    {
        
        if( ends_with($column, '_images') || ends_with($column, '_photos') )
        {
            
        $data .="
        
            \$this->deleteAllImages($instance, '$column');
        ";
        
        } elseif( ends_with($column, '_photo') || ends_with($column, '_image') )
        {
            
            $data .="
            
            \$this->deleteImage($instance, '$column' );
            ";
                    
                    
        
        } elseif( ends_with($column, '_files') )
        {
            
        $input_column   = $column;
        
        $data .="
        
            \$this->deleteAllFiles($instance, '$column');
        ";
        
        } elseif( ends_with($column, '_file') )
        {
            
            $data .="
            
            \$this->deleteFile($instance, '$column');
        ";
                    
                    
        
        }
    
    }
    
    $data .="
    
            if( ".$instance."->delete() )
            {
            
                return redirect()->action('$controller@index')->withErrors('Data has been deleted successfully.');
            
            } else{
                
                return back()->withErrors('Failed to delete data. Please retry later.');
                
            }
        
        } else{
            
            return back()->withErrors('No data was found to delete. Please refresh the page and retry.');
            
        }
        
        
    }
        ";
        
        return $data;
        
    }
    
    
}