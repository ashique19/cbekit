<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class RoleCrud extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'role:crud {roles?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make CRUD for role/roles';
    
    protected $table = 'users';
    
    private $columns = [];
    
    private $roles = [];
    
    
    private function file_write($dir, $contents)
    {
        $parts = explode('/', $dir);
        $file = array_pop($parts);
        $dir = '';
        foreach($parts as $part)
            if(!is_dir($dir .= "/$part")) mkdir($dir);
        file_put_contents("$dir/$file", $contents);
    }
    
    
    private function makeController()
    {
        
        if( count($this->roles) > 0 )
        {
            
            foreach( $this->roles as $role )
            {
                
        $table_columns = $this->columns;
        
        $data = "<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\\".$role['request'].";
use App\Http\Controllers\Controller;
use App\\".$role['model'].";

class ".$role['controller']." extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        return view('admin.".$role['name'].".index', ['".$this->table."'=> ".$role['model']."::where('role', ".$role['id'].")->latest()->paginate(20)]);
        
    }
    
    ";
    
    
    $data .="
    /**
     * Searches the listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function searchIndex(Request \$request)
    {
    
        \$search = array_filter(\$request->all());
        unset(\$search['_token']);
        
        \$result =   new ".$role['model'].";
          
                    (\$request->input('from'))  ? \$result = \$result->where('created_at', '>', \$request->input('from').' 00:00:00') : false;
                    (\$request->input('to'))    ? \$result = \$result->where('created_at', '<', \$request->input('to').' 23:59:59') : false;
    ";
    
    foreach( (array) $table_columns as $column )
    {
        
        if($column != 'created_at' && $column != 'updated_at')
        {
            
            if(substr($column, -3, 3) == '_id' || substr($column, 0, 2) == 'id')
            {
                
                $data .= "\n\t\t\t\t\t(\$request->input('$column'))   ? \$result = \$result->where('$column', \$request->input('$column')) : false;";
                
            } else{
                
                $data .= "\n\t\t\t\t\t(\$request->input('$column'))   ? \$result = \$result->where('$column', 'like', '%'.\$request->input('$column').'%') : false;";
                
            }
            
        }
        
    }
    
    
    $data .="
        
        return view('admin.".$role['name'].".index', ['".$this->table."'=> \$result->latest()->paginate(20)]);
        
    }
    
    ";
    
    
    $data .="

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        return view('admin.".$role['name'].".create');
        
    }
    
    ";
    
    
    $data .="

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  \$request
     * @return \Illuminate\Http\Response
     */
    public function store(".$role['request']." \$request)
    {
        
        ";
        
        foreach($table_columns as $column)
        {
            
            if(substr($column, -6) == '_photo' || substr($column, -6) == '_image')
            {
                
                $input_column   = $column."s";
                $folder         = substr($column, 0, strlen($column)-6);
                
                $data .="
        \$request['$column'] = \$this->storeImage(\$request, '$input_column', '$folder' );";
                
            } elseif(substr($column, -7) == '_images')
            {
                
                $input_column   = substr($column, 0, -1);
                $folder         = substr($column, 0, strlen($column)-7);
                
                $data .="
        \$request['$column'] = \$this->storeImages(\$request, '$input_column', '$folder' );";
                
            } elseif(substr($column, -6) == '_files')
            {
                
                $input_column   = substr($column, 0, -1);
                $folder         = substr($column, 0, strlen($column)-7);
                
                $data .="
        \$request['$column'] = \$this->storeFiles(\$request, '$input_column', '$folder');";
                
            } elseif(substr($column, -5) == '_file')
            {
                
                $input_column   = $column."s";
                $folder         = substr($column, 0, strlen($column)-5);
                
                $data .="
        \$request['$column'] = \$this->storeFile(\$request, '$input_column', '$folder' );";
                
            }
            
        }
        
        $data .="
        
        \$save_success = ".$role['model']."::create(\$request->all());
        
        if(\$save_success){";
        
        $data .="
        
            return redirect()->action('".$role['controller']."@index')->withErrors('Data has been stored successfully.');
        
        } else{
            
            return back()->withInput()->withErrors('Failed to store data. Please check data and retry.');
            
        }
    
    }
    ";
    
    
    $data .="
    /**
     * Display the specified resource.
     *
     * @param  int  \$id
     * @return \Illuminate\Http\Response
     */
    public function show(\$id)
    {
    
        \$".strtolower($role['model'])." = ".$role['model']."::find(\$id); ";
        
        $data.="
        
        return view('admin.".$role['name'].".show', compact('".strtolower($role['model'])."') );
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  \$id
     * @return \Illuminate\Http\Response
     */
    public function edit(\$id)
    {
    
        \$".strtolower($role['model'])." = ".$role['model']."::find(\$id); ";
        
        $data.="
        
        return view('admin.".$role['name'].".edit', compact('".strtolower($role['model'])."') );
        
    }";
    
    
    
    $data .="

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  \$request
     * @param  int  \$id
     * @return \Illuminate\Http\Response
     */
    public function update(".$role['request']." \$request, \$id)
    {
        
        \$".strtolower($role['model'])." = ".$role['model']."::find(\$id);";
        
        $instance = "\$".strtolower($role['model']);
        
    foreach($table_columns as $column)
    {
        
        if(substr($column, -6) == '_photo' || substr($column, -6) == '_image')
        {
            
            $input_column   = $column."s";
            $delete_photo   = $column."_delete";
            $folder         = substr($column, 0, strlen($column)-6);
            
            $data .="
            
        if(\$request->has('$delete_photo'))
        {
        
            \$this->deleteImageFromRequest(\$request, \$instance, '$delete_photo', '$column' );
            
        }
        
        \$request['$column'] = \$this->updateImage(\$request, \$instance, '$input_column', '$column', '$folder', '$delete_photo');
        ";
            
        } elseif(substr($column, -7) == '_images')
        {
            
            $input_column   = $column;
            $delete_photo   = $column."_delete";
            $request_input  = substr($column, 0, -1);
            $folder         = substr($column, 0, strlen($column)-7);
            
            $data .="
        
        if(\$request->has('$delete_photo'))
        {
        
            \$images = \$this->deleteImagesFromRequest(\$request, \$instance, '$request_input', '$column');
            
            ".$instance."->update(['$input_column'=> \$images]);
            
        }
        
        \$request['$input_column'] = \$this->updateImages(\$request, \$instance, $request_input, $input_column, $folder, $delete_photo);
        
        ";
            
        } elseif(substr($column, -6) == '_files')
        {
            
            $input_column   = $column;
            $delete_files   = $column."_delete";
            $request_input  = substr($column, 0, -1);
            $folder         = substr($column, 0, strlen($column)-7);
            
            $data .="
        
        \$request['$input_column'] = \$this->updateFiles(\$request, \$instance, $request_input, $input_column, $folder, $delete_files);
        ";
            
        } elseif(substr($column, -5) == '_file')
        {
                
            $input_column   = $column."s";
            $delete_file    = $column."_delete";
            $folder         = substr($column, 0, strlen($column)-5);
            
            $data .="
            
        \$request['$column'] = \$this->updateFile(\$request, \$instance, $input_column, $column, $folder, $delete_file);
        
        ";
                
            }
    }
    
        $data .="
        
        \$save_success = ".$role['model']."::find(\$id)->update(\$request->all());
        
        if(\$save_success)
        {";
        
        
        $data .="
            return redirect()->action('".$role['controller']."@index')->withErrors('Data has been updated successfully.');
        
        } else{
            
            return back()->withInput()->withErrors('Failed to store data. Please check data and retry.');
            
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  \$id
     * @return \Illuminate\Http\Response
     */
    public function destroy(\$id, Request \$request)
    {
        
        \$".strtolower($role['model'])." = ".$role['model']."::find(\$id);
    
        
        if(\$".strtolower($role['model']).")
        {
    ";
    
    foreach($table_columns as $column)
    {
        
        if(substr($column, -7) == '_images')
        {
            
        $input_column   = $column;
        
        $data .="
            \$this->deleteAllImages($instance, '$input_column');
        
        ";
        
        } elseif(substr($column, -6) == '_photo' || substr($column, -6) == '_image')
        {
            
            $data .="
            \$this->deleteImage( $instance, '$column' );
        
            ";
        
        } elseif(substr($column, -6) == '_files')
        {
            
        $input_column   = $column;
        
        $data .="
            \$this->deleteAllFiles( $instance, '$column');
        
        ";
        
        } elseif(substr($column, -5) == '_file')
        {
            
            $data .="
            \$this->deleteFile( $instance, '$column' );
            
            ";
        
        }
    
    }
    
    $data .="
            if(\$".strtolower($role['model'])."->delete())
            {
            
                return redirect()->action('".$role['controller']."@index')->withErrors('Data has been deleted successfully.');
            
            } else{
                
                return back()->withErrors('Failed to delete data. Please retry later.');
                
            }
        
        } else{
            
            return back()->withErrors('Failed to delete data. Please retry later.');
            
        }
        
        
    }
    ";
    
    $data .="
    
}

        ";
        $this->file_write(app_path().'/Http/Controllers/'.$role['controller'].'.php', $data);
        $this->info('Controller created: '.$role['controller']);
        
                
                
            }
            
        }
        
    }
    
    
    private function makeRequest()
    {
        
        if( count($this->roles) > 0 )
        {
            
            foreach( $this->roles as $role )
            {
        
        $data = "<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ".$role['request']." extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            '".implode("'     => '',\n\t\t\t '", (array) $this->columns)."'      => ''
        ];
    }
}

        ";
        $this->file_write(app_path().'/Http/Requests/'.$role['request'].'.php', $data);
        $this->info('Request created: '.$role['request'].'.php');
        
            }
            
        }
    }
    
    
    private function makeView()
    {
        
        if( count($this->roles) > 0 )
        {
            
            foreach( $this->roles as $role )
            {
        
        $model              = $role['model'];
        $controller         = $role['controller'];
        $table              = $this->table;
        $table_columns      = $this->columns;
        $subject_table      = $table;
        $subject_model      = $model;
        $subject_controller = $controller;
        $fname              = strtolower($table);    // fullname with all lowercase
        $sname              = str_singular(strtolower($table),0,-1);   // short name; If the table name is 'users', short name is 'user', If the table name is 'children', short name is 'child', 
        $name_model     = $model;
        
        $index  = "
@extends('admin.layout')

@section('title') ".str_replace('_',' ',$role['name'])." @stop

@section('main')

<h1 class=\"text-center\">".str_replace('_',' ',$controller)." @if(\$".$table.") : {{\$".$table."->total()}} @endif</h1>
";

$index .="
<section class=\"col-sm-8 col-sm-offset-2\">
    
    {!! Form::open(['class'=>'form form-inline text-center', 'method' =>'post', 'url'=> action('$controller@searchIndex')]) !!} ";
        
        
    foreach( (array) $table_columns as $column)
    {
    
        if($column != 'created_at' && $column != 'updated_at' && $column != 'id' && substr($column, -6) != '_photo' && substr($column, -7) != '_images' && substr($column, -6) != '_files' && substr($column, -5) != '_file'){
            
            if(substr($column, -3, 3) == '_id'){
                
                $model_name = ucfirst(substr($column, 0, -3));
                $index .= "
        <div class=\"form-group\">
            {!! Form::label('$column', '".str_replace('_',' ',substr(ucfirst($column), 0, count($column)-4)).": ') !!}
            {!! Form::select('$column', \App\\$model_name::lists('name', 'id'), old('$column') , ['class'=>'form-control select2']) !!}
        </div>
            ";
                
            } elseif(substr($column, 0, 3) == 'is_'){
                
            $index .= "
        <div class=\"form-group\">
            {!! Form::label('$column', '".str_replace('_',' ',ucfirst($column)).": ') !!}
            {!! Form::select('$column', [ ''=>'-Select-','1'=>'Yes', '0'=>'No'], old('$column') , ['class'=>'form-control']) !!}
        </div>
            ";
            
            }  elseif(substr($column, -5, 5) == '_date'){
                
            $index .= "
        <div class=\"form-group\">
            {!! Form::label('$column', '".str_replace('_',' ',ucfirst($column)).": ') !!}
            {!! Form::text('$column', old('$column') , ['class'=>'form-control datepicker']) !!}
        </div>
            ";
            
            } elseif(substr($column, -5, 5) == '_time'){
                
            $index .= "
        <div class=\"form-group\">
            {!! Form::label('$column', '".str_replace('_',' ',ucfirst($column)).": ') !!}
            {!! Form::text('$column', old('$column') , ['class'=>'form-control timepicker']) !!}
        </div>
            ";
            
            } else{
                
            $index .= "
        <div class=\"form-group\">
            {!! Form::label('$column', '".str_replace('_',' ',ucfirst($column)).": ') !!}
            {!! Form::text('$column', old('$column') , ['class'=>'form-control']) !!}
        </div>
            ";
            
            } 
            
            
        }
        
    }
        
        $index .="
        <div class=\"form-group\">
            {!! Form::label('from', 'From: ') !!}
            {!! Form::text('from', old('from') , ['class'=>'form-control datepicker']) !!}
        </div>
        
        <div class=\"form-group\">
            {!! Form::label('to', 'To: ') !!}
            {!! Form::text('to', old('to') , ['class'=>'form-control datepicker']) !!}
        </div>

        {!! Form::submit('search', ['class'=>'btn btn-info']) !!}
        
    {!! Form::close() !!}
    
    <hr>
</section>

";


$index .="{!! errors(\$errors) !!}";

$index .="

<section class=\"col-sm-8 col-sm-offset-2\">
    
    <a href=\"{{action('$controller@create')}}\" class=\"btn btn-default pull-right btn-lg blue-border blue-text\">Add new</a>
    
    <table class=\"table table-responsive\">
        <thead>
            <tr>"; 
            
            foreach( (array) $table_columns as $column)
            {
                
                if(substr($column, -3, 3) == '_id')
                {
                    
                    $index .= "\n\t\t\t\t<th class=\"blue-bg white-text\">".str_replace('_', ' ', substr(ucfirst($column), 0, count($column)-4))."</th>";
                    
                } else{
                    
                    if(substr($column, -7) != '_images' && substr($column, -6) != '_files' && $column != 'created_by' && $column != 'updated_by' && substr($column, -7) != 'details')
                    {
                    
                    $index .= "\n\t\t\t\t<th class=\"blue-bg white-text\">".str_replace('_', ' ', ucfirst($column) )."</th>";
                    
                    }
                }
                
            }
            
            $index .="
                <th class=\"blue-bg white-text\" width=\"50\">Show</th>
                <th class=\"blue-bg white-text\" width=\"50\">Modify</th>
                <th class=\"blue-bg white-text\" width=\"50\">Delete</th>
            </tr>
        </thead>
        <tbody>
            @if(\$".$table.")
                @foreach(\$".$table." as \$".$sname.")
                    <tr>";
                    
                    foreach( (array) $table_columns as $column)
                    {
                        
                        if(substr($column, -3, 3) != '_id' && substr($column, -7) != '_images' && substr($column, -6) != '_files' && $column != 'created_by' && $column != 'updated_by' && substr($column, -7) != 'details')
                        {
                            
                            if(substr($column, 0, 3) == 'is_'){
                            
                                $index .= "\n\t\t\t\t\t\t<td>{{yn(\$".$sname."->".$column.")}}</td>";
                                
                            } elseif(substr($column, -6) == '_photo'){
                            
                                $index .= "\n\t\t\t\t\t\t<td><center><a href=\"{{\$".$sname."->".$column."}}\" class=\"btn btn-default btn-xs\">{!! thumb(\$".$sname."->".$column.") !!}</a></center></td>";
                                
                            } elseif(substr($column, -5) == '_file'){
                            
                                $index .= "\n\t\t\t\t\t\t<td><center><a href=\"{{\$".$sname."->".$column."}}\" class=\"btn btn-default btn-xs btn-rounded\"><span class=\"fa fa-download\"></span></a></center></td>";
                                
                            } else{
                            
                                $index .= "\n\t\t\t\t\t\t<td>{{\$".$sname."->".$column."}}</td>";
                                
                            }
                            
                        } else{
                            
                            if(substr($column, -3, 3) == '_id'){

                            $model_name  = substr($column, 0, count($column) -4);
                            $index .= "\n\t\t\t\t\t\t<td>@if(\$".$sname."->".$model_name.") {{\$".$sname."->".$model_name."->name}} @endif</td>";
                            
                            }
                            
                        }
                        
                    }
                
                $index .="
                        <td>
                            {!! views('$controller', \$".$sname."->id, '<span class=\'fa fa-expand\'></span>', ['class'=>'btn btn-success btn-rounded']) !!}
                        </td>
                        <td>
                            {!! edits('$controller', \$".$sname."['id'], '<span class=\'fa fa-pencil\'></span>', ['class'=>'btn btn-warning btn-rounded']) !!}
                        </td>
                        <td>
                            {!! deletes('$controller', $".$sname."['id'], '<span class=\'fa fa-times\'></span>', ['class'=>'btn btn-danger btn-rounded']) !!}
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
    {!! \$".$table."->render() !!}
</section>
";

$index .="

@stop
        ";


        $create  = "
@extends('admin.layout')

@section('title') Create new ".str_replace('_',' ',$model)." @stop

@section('main')

<h1 class=\"page-title blue-bg white-text text-center\">".str_replace('_',' ',$controller)."</h1>

{!! errors(\$errors) !!}

<section class=\"col-sm-6 col-sm-offset-3 col-xs-12\">

<h3>Create ".str_replace('_',' ',$model)."</h3>


{!! Form::open( ['url'=> action('$controller@store'), 'enctype'=>'multipart/form-data' ]) !!}

    ";
    
    foreach( (array) $table_columns as $column)
    {
    
        if($column != 'created_at' && $column != 'updated_at' && $column != 'id'){
            
            if(substr($column, -3, 3) == '_id')
            {
                
                $model = ucfirst(substr($column, 0, -3));
                $create .= "
        <div class=\"form-group\">
            {!! Form::label('$column', '".str_replace('_',' ',substr(ucfirst($column), 0, count($column)-4)).": ') !!}
            {!! Form::select('$column', \App\\$model::lists('name', 'id'), old('$column') , ['class'=>'form-control select2']) !!}
        </div>
            ";
                
            } elseif(substr($column, 0, 3) == 'is_')
            {
                
            $create .= "
        <div class=\"form-group\">
            {!! Form::label('$column', '".str_replace('_',' ',ucfirst($column)).": ') !!}
            {!! Form::select('$column', [ ''=>'-Select-','1'=>'Yes', '0'=>'No'], old('$column') , ['class'=>'form-control']) !!}
        </div>
            ";
            
            } elseif(substr($column, -5, 5) == '_date')
            {
                
            $create .= "
        <div class=\"form-group\">
            {!! Form::label('$column', '".str_replace('_',' ',ucfirst($column)).": ') !!}
            {!! Form::text('$column', old('$column') , ['class'=>'form-control datepicker']) !!}
        </div>
            ";
            
            } elseif(substr($column, -5, 5) == '_time')
            {
                
            $create .= "
        <div class=\"form-group\">
            {!! Form::label('$column', '".str_replace('_',' ',ucfirst($column)).": ') !!}
            {!! Form::text('$column', old('$column') , ['class'=>'form-control timepicker']) !!}
        </div>
            ";
            
            } elseif(substr($column, -6) == '_photo' || substr($column, -5) == '_file')
            {
            
            $file_column = $column."s";
            $create .= "
        <div class=\"form-group\">
            {!! Form::label('$file_column', '".str_replace('_',' ',ucfirst($column)).": ') !!}
            {!! Form::file('$file_column', ['class'=>'form-control file']) !!}
        </div>
            ";
            
            } elseif(substr($column, -7) == '_images')
            {
            
            $file_column = substr($column, 0, -1);
            $create .= "
        <div class=\"form-group\">
            {!! Form::label('".$file_column."[]', '".str_replace('_',' ',ucfirst($column)).": ') !!}
            {!! Form::file('".$file_column."[]', ['class'=>'form-control file', 'multiple'=>'multiple']) !!}
        </div>
            ";
            
            } elseif(substr($column, -6) == '_files')
            {
            
            $file_column = substr($column, 0, -1);
            $create .= "
        <div class=\"form-group\">
            {!! Form::label('".$file_column."[]', '".str_replace('_',' ',ucfirst($column)).": ') !!}
            {!! Form::file('".$file_column."[]', ['class'=>'form-control file', 'multiple'=>'multiple']) !!}
        </div>
            ";
            
            }  elseif(substr($column, -7) == 'details')
            {
        $create .= "
        <div class=\"form-group\">
            {!! Form::label('$column', '".str_replace('_',' ',ucfirst($column)).": ') !!}
            {!! Form::textarea('$column', old('$column') , ['class'=>'form-control summernote']) !!}
        </div>
            ";
            } elseif($column != 'created_by' && $column != 'updated_by'){
                
            $create .= "
        <div class=\"form-group\">
            {!! Form::label('$column', '".str_replace('_',' ',ucfirst($column)).": ') !!}
            {!! Form::text('$column', old('$column') , ['class'=>'form-control']) !!}
        </div>
            ";
            
            } 
            
            
        }
        
    }
    
$create .= "
    <div class=\"form-group\">
        {!! Form::submit('Save ".str_replace('_',' ',$name_model)."', ['class'=>'form-control btn btn-info']) !!}
    </div>

{!! Form::close() !!}


</section>

@stop
        ";
        
        $model = $name_model;
        $edit  = "
@extends('admin.layout')

@section('title') Edit ".str_replace('_',' ',$controller)." @stop

@section('main')

<h1 class=\"page-title blue-bg white-text text-center\">Modify ".str_replace('_',' ',$model)."</h1>

{!! errors(\$errors) !!}

<section class=\"col-sm-6 col-sm-offset-3\">

{!! Form::open( ['method'=>'patch', 'url'=> action('$controller@update', \$".$sname."->id), 'enctype'=>'multipart/form-data' ]) !!}

    ";
    
    foreach( (array) $table_columns as $column)
    {
    
        if($column != 'created_at' && $column != 'updated_at' && $column != 'id'){
            
            if(substr($column, -3, 3) == '_id'){
                    
                $model = ucfirst(substr($column, 0, -3));
                $edit .= "
            <div class=\"form-group\">
                {!! Form::label('$column', '".str_replace('_',' ',substr(ucfirst($column), 0, count($column)-4)).": ') !!}
                {!! Form::select('$column', \App\\$model::lists('name', 'id'), \$".$sname."->$column , ['class'=>'form-control select2']) !!}
            </div>
                ";
                    
            } elseif(substr($column, 0, 3) == 'is_'){
                
            $edit .= "
            <div class=\"form-group\">
                {!! Form::label('$column', '".str_replace('_',' ',ucfirst($column)).": ') !!}
                {!! Form::select('$column', [ ''=>'-Select-','1'=>'Yes', '0'=>'No'], \$".$sname."->$column , ['class'=>'form-control']) !!}
            </div>
            ";
            
            } elseif(substr($column, -5, 5) == '_date'){
                    
                $edit .= "
            <div class=\"form-group\">
                {!! Form::label('$column', '".str_replace('_',' ',ucfirst($column)).": ') !!}
                {!! Form::text('$column', \$".$sname."->$column , ['class'=>'form-control datepicker']) !!}
            </div>
                ";
                
            } elseif(substr($column, -5, 5) == '_time'){
                    
                $edit .= "
            <div class=\"form-group\">
                {!! Form::label('$column', '".str_replace('_',' ',ucfirst($column)).": ') !!}
                {!! Form::text('$column', \$".$sname."->$column , ['class'=>'form-control timepicker']) !!}
            </div>
                ";
                
            } elseif(substr($column, -6) == '_photo' || substr($column, -5) == '_file'){
                
                $file_column = $column."s";
                $edit .= "
            <div class=\"form-group\">
                <label for=\"$file_column\">".str_replace('_',' ',ucfirst($column)).": <span class=\"badge badge-primary\"><input type=\"checkbox\" value=\"1\" name=\"".$column."_delete\" /> remove</span></label>
                {!! Form::file('$file_column' , ['class'=>'form-control file']) !!}
            </div>
                ";
                
            } elseif(substr($column, -7) == '_images'){
                
                $file_column = $column;
                $edit .= "
            <div class=\"form-group\">
                
                @if( is_array(\$".strtolower($model)."->$file_column) && count(\$".strtolower($model)."->$file_column) > 0)
                <h4>Select previous ".str_replace('_',' ',$file_column)." to remove</h4>
                <div class=\"gallery\">
                @foreach(\$".strtolower($model)."->$file_column as \$image)
                <a class=\"gallery-item\" href=\"{{\$image}}\" title=\"Image\" data-gallery>
                    <div class=\"image\">
                        {!! xs(\$image) !!}
                        <ul class=\"gallery-item-controls\">
                            <li><label class=\"check\"><input type=\"checkbox\" class=\"\" value=\"{{\$image}}\" name=\"".$column."_delete[]\" /></label></li>
                        </ul>                                                                    
                    </div>
                </a>
                @endforeach
                </div>
                @endif
                <label for=\"".substr($file_column, 0, -1)."[]\"><span class=\"badge badge-primary\">Add ".str_replace('_',' ', $file_column)."</span></label>
                {!! Form::file('".substr($file_column, 0, -1)."[]' , ['class'=>'form-control file', 'multiple'=> 'multiple']) !!}
            </div>
                ";
                
            } elseif(substr($column, -6) == '_files'){
                
                $file_column = $column;
                $edit .= "
            <div class=\"form-group\">
                @if( is_array(\$".strtolower($model)."->$file_column) && count(\$".strtolower($model)."->$file_column) > 0)
                <h4>Select previous ".str_replace('_',' ',$file_column)." to remove</h4>
                <ul class=\"list-group\">
                @foreach(\$".strtolower($model)."->$file_column as \$file)
                <li class=\"list-group-item\">
                    <input type=\"checkbox\" value=\"{{\$file}}\" name=\"".$column."_delete[]\" />
                    {{ucfirst(substr(\$file, -4))}} File
                </li>
                @endforeach
                </ul>
                @endif
                <label for=\"".substr($file_column, 0, -1)."[]\"><span class=\"badge badge-primary\">Add ".str_replace('_', ' ', $file_column)."</span></label>
                {!! Form::file('".substr($file_column, 0, -1)."[]' , ['class'=>'form-control file', 'multiple'=> 'multiple']) !!}
            </div>
                ";
                
            } elseif(substr($column, -7) == 'details'){
                
                $edit .= "
            <div class=\"form-group\">
                {!! Form::label('$column', '".str_replace('_',' ',ucfirst($column)).": ') !!}
                {!! Form::textarea('$column', \$".$sname."->$column , ['class'=>'form-control summernote']) !!}
            </div>
                ";
            } elseif($column != 'created_by' && $column != 'updated_by'){
                
                $edit .= "
            <div class=\"form-group\">
                {!! Form::label('$column', '".str_replace('_',' ',ucfirst($column)).": ') !!}
                {!! Form::text('$column', \$".$sname."->$column , ['class'=>'form-control']) !!}
            </div>
                ";
                
            } 
    
        }
        
    }

$edit .= "
    <div class=\"form-group\">
        {!! Form::submit('Update ".str_replace('_',' ',$name_model)."', ['class'=>'form-control btn btn-info']) !!}
    </div>

{!! Form::close() !!}


</section>

@stop
        ";
        
        $model = $name_model;
        $show  = "
@extends('admin.layout')

@section('title') ".str_replace('_',' ',$controller)." @stop

@section('main')

<h1 class=\"page-title\"><center>".str_singular(str_replace('_',' ',$controller))."</center></h1>

{!! errors(\$errors) !!}

@if(\$".$sname.")
<section class=\"row panel-body\">
    <table class=\"table table-bordered table-striped table-actions\">
        <tdead>
            <tr>
                <td width=\"200\">Title</td>
                <td>Details</td>
            </tr>
        </tdead>
        <tbody>";
        
        foreach( (array) $table_columns as $column)
        {
            
            if(substr($column, -3, 3) == '_id')
            {
                $model = substr($column, 0, count($column) -4);
                $show .= "
                <tr>
                    <td>".str_replace('_',' ',substr(ucfirst($column), 0, count($column)-4))."</td>
                    <td>@if(\$".$sname."->".$model.") {{\$".$sname."->".$model."->name}} @endif</td>
                </tr>
                ";
                
            } elseif(substr($column, -6) == '_photo' || substr($column, -5) == '_file'){
        
                $show .= "
                <tr>
                    <td>".str_replace('_',' ',ucfirst($column))."</td>
                    <td><a href=\"{{\$".$sname."->$column}}\" class=\"btn btn-default btn-rounded btn-xs\"><span class=\"fa fa-download\"></span></a></td>
                </tr>
                ";
                
            } elseif(substr($column, -7) == '_images'){
        
                $show .= "
                <tr>
                    <td>".str_replace('_',' ',ucfirst($column))."</td>
                    <td>
                    @if( is_array(\$".strtolower($model)."->$file_column) && count(\$".strtolower($model)."->$file_column) > 0)
                    <div class=\"gallery\">
                    @foreach(\$".strtolower($model)."->$file_column as \$image)
                    <a class=\"gallery-item\" href=\"{{\$image}}\" title=\"Image\" data-gallery>
                        <div class=\"image\">
                            {!! xs(\$image) !!}
                        </div>
                    </a>
                    @endforeach
                    </div>
                    @endif
                    </td>
                </tr>
                ";
                
            } elseif(substr($column, -6) == '_files'){
        
                $show .= "
                <tr>
                    <td>".str_replace('_',' ',ucfirst($column))."</td>
                    <td>
                    @if( is_array(\$".strtolower($model)."->$file_column) && count(\$".strtolower($model)."->$file_column) > 0)
                    <ul class=\"list-group\">
                    @foreach(\$".strtolower($model)."->$file_column as \$file)
                    <li class=\"list-group-item\" >
                        <a class=\"btn btn-primary\" href=\"{{\$file}}\" title=\"\$file\" >{{\$file}}</a>
                    </li>
                    @endforeach
                    </ul>
                    @endif
                    </td>
                </tr>
                ";
                
            } elseif( $column == 'created_by'){
                
                $show .= "
                <tr>
                    <td>Created By</td>
                    <td>@if(\$".$sname."->createdBy){{\$".$sname."->createdBy->name}} @endif</td>
                </tr>
                ";
                
            } elseif( $column == 'updated_by'){
                
                $show .= "
                <tr>
                    <td>Created By</td>
                    <td>@if(\$".$sname."->updatedBy){{\$".$sname."->updatedBy->name}} @endif</td>
                </tr>
                ";
                
            } elseif(substr($column, -7) == '_images'){
                
                $show .= "
                <tr>
                    <td>".str_replace('_',' ',ucfirst($column))."</td>
                    <td>{!! \$".$sname."->$column !!}</td>
                </tr>
                ";
                
            } else{
        
                $show .= "
                <tr>
                    <td>".str_replace('_',' ',ucfirst($column))."</td>
                    <td>{{\$".$sname."->$column}}</td>
                </tr>
                ";
                
            }
            
        }
        
        $show .="
            <tr>
                <td>
                    {!! edits('$controller', \$".$sname."->id, 'edit', ['class'=>'btn btn-warning btn-rounded']) !!}
            ";
            
        $show .="                
                </td>
                <td>
                    {!! deletes('$controller', \$".$sname."->id, '<span class=\'fa fa-times\'></span>', ['class'=>'btn btn-danger btn-rounded']) !!}
                </td>
            </tr>
        </tbody>
    </table>
</section>
";

$show .="
@else

    <h3>No data found.</h3>

@endif

@stop
        ";
        

        $this->file_write(base_path().'/resources/views/admin/'.$role['name'].'/create.blade.php', $create);
        $this->info('View created: /views/admin/'.$role['name'].'/create.blade.php');
        
        $this->file_write(base_path().'/resources/views/admin/'.$role['name'].'/edit.blade.php', $edit);
        $this->info('View created: /views/admin/'.$role['name'].'/edit.blade.php');
        
        $this->file_write(base_path().'/resources/views/admin/'.$role['name'].'/show.blade.php', $show);
        $this->info('View created: /views/admin/'.$role['name'].'/show.blade.php');
        
        $this->file_write(base_path().'/resources/views/admin/'.$role['name'].'/index.blade.php', $index);
        $this->info('View created: /views/admin/'.$role['name'].'/index.blade.php');
        
            }
            
        }
        
    }
    
    
    private function getRoutes()
    {
        
        $routes = "";
        
        if( count($this->roles) > 0 )
        {
            
            foreach($this->roles as $role)
            {
                
                $routes .='
    Route::post(\''.str_plural($role['name']).'/search\', \''.$role['controller'].'@searchIndex\');
    Route::get(\''.str_plural($role['name']).'/search\', \''.$role['controller'].'@index\' );
    Route::resource(\''.str_plural($role['name']).'\', \''.$role['controller'].'\');
    
                ';
                
            }
            
        }
        
        return $routes;
        
    }
    
    
    private function prepare($roles)
    {
        
        $table          = 'users';
        
        $this->columns  = \Schema::getColumnListing( $this->table );
        
        $roles          = \App\Role::whereIn('name', explode( ',', strtolower(preg_replace('/\s+/', '', $roles))))->lists('name','id')->toArray();
        
        if( count($roles) > 0 )
        {
            
            foreach($roles as $k=>$v)
            {
                
                $this->roles[] = [
                    'id'    => $k,
                    'name'  => $v,
                    'model' => 'User',
                    'controller' => ucfirst(str_plural($v)),
                    'request'    => strtolower($v)."StoreRequest",
                ];
                
            }
            
        }
        
        return $this->roles;
        
    }
    
    
    private function proceed()
    {
        
        $this->makeController();
        $this->makeRequest();
        $this->makeView();
        
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
        
        $roles = $this->argument('roles');
        
        $this->prepare($roles);
        
        $this->proceed();
        
        $routes = $this->getRoutes();
        
        return $this->info( $routes );
        
    }
}
