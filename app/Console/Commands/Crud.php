<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Crud extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    
    /**
     * {table}                  : the subject
     *
     * {--hasMany=}             : {table} has many {--hasMany=}
     * 
     * {--modelInjection=}      : Insert additional methods into model
     * 
     * {--controllerInjection=} : Insert additional methods into Controller
     * 
     * {--manyToMany=}          : {table} has many to many relationship with {--manyToMany=}
     * 
     * {--skipSearch=}          : Skip search at view > index.blade.php
     * 
     * {--simple=}              : Make crud in single page. In view > index.blade.php we make create, view, edit and delete. There is no search option in this page.
     * 
     */
    protected $signature = 'make:crud {table} {--hasMany=} {--modelInjection=} {--controllerInjection=} {--manyToMany=} {--skipSearch=} {--simple=} {--role=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make CRUD for any single table';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
    
    
    
    function file_write($dir, $contents)
    {
        $parts = explode('/', $dir);
        $file = array_pop($parts);
        $dir = '';
        foreach($parts as $part)
            if(!is_dir($dir .= "/$part")) mkdir($dir);
        file_put_contents("$dir/$file", $contents);
    }
    
    
    function make_model($table, $table_columns, $model, $controller, $request, $hasManys, $modelInjection, $manyToManys, $skipSearch, $simple)
    {
        
        $name = $model;
        $controller_name    = $controller;
        
        $data = "<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class $model extends Model
{

    protected \$table = \"$table\";
    
    protected \$fillable = ['".implode('\', \'',$table_columns)."'];
    ";
    
    $images = "
    protected \$casts = [";
    
    foreach( (array) $table_columns as $column)
    {
        
        if(substr($column, -7) == '_images' || substr($column, -6) == '_files')
        {
            
            $images .= "
        '$column'=> 'array',";
            
        }
    }
    
    $images .= "
    ];
    
    
    ";
    
    $data .= $images;
    
    
    $dates = "";
    
    foreach( (array) $table_columns as $column)
    {
        
        if(substr($column, -5, 5) == '_date')
        {
            
            $dates .= "'$column', ";
            
        }
    }
    
    $data .= ($dates) ? "\n\tprotected \$dates = [$dates];\n" : false;
    
    $link ="";
    
    foreach( (array) $table_columns as $column)
    {
        
        $dates = "";
        
        if(substr($column, -5, 5) == '_date')
        {
            
            $dates .= "$column,";
            
        }
        
        
        if(substr($column, -3, 3) == '_id')
        {
            
            $model = substr($column, 0, count($column)-4);
            
            $data .= "
    public function $model()
    {
        
        return \$this->belongsTo('\App\\".ucfirst($model)."');
        
    }
            ";
            
        }
        
        
        if(substr($column, 0, 3) == 'is_')
        {
            
            $scope = studly_case(substr($column, 3));
            
            $data .="
            
    public function scope$scope(\$query)
    {
        
        return \$query->where('$column', 1);
        
    }
            ";
            
        }
        
        
        if( substr($column, -4) == 'link' )
        {
            
            if(array_search('created_by', (array) $table_columns) != false)
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
    
    if($hasManys)
    {
    
    foreach($hasManys as $hasMany)
    {
        $data .="
        
    public function $hasMany()
    {
        
        return \$this->hasMany('\App\\".ucfirst(str_singular($hasMany))."');
        
    }
        ";
        
    }
        
    }
    
    if($manyToManys)
    {
    
    foreach($manyToManys as $manyToMany)
    {
        $data .="
        
    public function $manyToMany()
    {
        
        return \$this->belongsToMany('\App\\".ucfirst(str_singular($manyToMany))."');
        
    }
        
        ";
        
    }
    
    }
    
    foreach( (array) $table_columns as $column)
    {
        
        if($column == 'created_by')
        {
            
            $data .= "
    public function createdBy()
    {
        
        return \$this->belongsTo('\App\User', 'created_by');
        
    }
    
    
    public function updatedBy()
    {
        
        return \$this->belongsTo('\App\User', 'updated_by');
        
    }
    
    
    public static function boot()
    {
        
        parent::boot();
        
        static::creating(function(\$model)
        {
            if(auth()->user())
            {
                
                \$model->created_by = auth()->user()->id;
                
                \$model->updated_by = auth()->user()->id;
                
            }
            
            $link
            
        });
        
        static::updating(function(\$model)
        {
            if(auth()->user())
            {
                
                \$model->updated_by = auth()->user()->id;
                
            }
            
        });
        
    }
            ";
            
        }
    }
    
    foreach( (array) $table_columns as $column)
    {
        if( substr($column, -4) == 'link' && array_search('created_by', (array) $table_columns) == false)
        {
            
            $this->info('Got the link.');
            
            $data .="
    public static function boot()
    {
        
        parent::boot();
        
        static::creating(function(\$model)
        {
            
            /**
             * 
             * Prepare unique link for the blog
             * 
             */
            \$item = new self();
            
            \$link = str_slug(\$model->name);
            
            \$model->link = \$item->where('link', 'like', \$link)->first() ? \$link.'-'.(\$item->where('link', 'like', \$link.'%')->count()+1) : \$link;
            
        });
        
    }
            ";
            
        }
    }
    
    
    $data .="
    
    $modelInjection

}

        ";
        
        $this->file_write(app_path().'/'.$name.'.php', $data);
        $this->info('Model created: '.$name);
        
    }
    
    
    function make_controller($table, $table_columns, $model, $controller, $request, $hasManys, $controllerInjection, $manyToManys, $skipSearch, $simple)
    {
        
        $data = "<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\\$request;
use App\Http\Controllers\Controller;
use App\\$model;

class $controller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        return view('admin.$table.index', ['$table'=> $model::latest()->paginate(20)]);
        
    }
    
    ";
    
    if(strlen($simple) == 0){
    
    if(strlen($skipSearch) == 0){
    
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
        
        \$result =   new $model;
          
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
        
        return view('admin.$table.index', ['$table'=> \$result->latest()->paginate(20)]);
        
    }
    
    ";
    }
    
    
    $pass_many_to_many_to_view = "";
    
    $data .="

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {";
        
        if($manyToManys)
        {
            
            foreach ($manyToManys as $manyToMany) {
                
        $data .="
        
        \$".strtolower($manyToMany)." = \App\\".ucfirst(str_singular($manyToMany))."::pluck('name','id'); ";
            $pass_many_to_many_to_view .= "'$manyToMany',";
            
            }
            
        }
        
        $compact = (strlen($pass_many_to_many_to_view) > 0) ? ", compact(".substr($pass_many_to_many_to_view, 0, -1).")" : "";
        
        $data.="
        
        return view('admin.$table.create' $compact );
        
    }
    
    ";
    }
    
    $data .="

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  \$request
     * @return \Illuminate\Http\Response
     */
    public function store($request \$request)
    {
        
        ";
        
        foreach($table_columns as $column)
        {
            
            if(substr($column, -6) == '_photo')
            {
                
                $input_column   = $column."s";
                $folder         = substr($column, 0, strlen($column)-6);
                
                $data .="
        if(\$request->hasFile('$input_column'))
        {
            if(\$request->file('$input_column')->isValid())
            {
                
                
                /**
                 * SimpleImage can't make dir. It returns error if directory does not exist.
                 * Make directory (if it dows not exists) before putting file in it
                 */
                \$location   = public_path().'/img/$folder/';
                if(!is_dir(\$location))
                {
                    
                    mkdir(\$location, 0777, true);
                                    
                }
                
                
                /**
                *
                * Prepare names for file at different sizes
                * 
                */
                \$image_lg  = date('Ymdhis').'_lg.'.\$request->file('$input_column')->getClientOriginalExtension();
                \$image_md  = date('Ymdhis').'_md.'.\$request->file('$input_column')->getClientOriginalExtension();
                \$image_sm  = date('Ymdhis').'_sm.'.\$request->file('$input_column')->getClientOriginalExtension();
                \$image_xs  = date('Ymdhis').'_xs.'.\$request->file('$input_column')->getClientOriginalExtension();
                
                // Instantiate SimpleImage class
                \$image = new \App\Http\Controllers\SimpleImage(\$request->file('$input_column'));
                
                
                // Size:lg
                \$image->best_fit(1200,600);
                \$image->save(\$location.\$image_lg);
                
                // Size:md
                \$image->best_fit(640,400);
                \$image->save(\$location.\$image_md);
                
                // Size:sm
                \$image->best_fit(320,225);
                \$image->save(\$location.\$image_sm);
                
                // Size:xs
                \$image->best_fit(100,75);
                \$image->save(\$location.\$image_xs);
                
                \$request['$column'] = '/public/img/$folder/'.\$image_lg;
                
            }
                        
        }
                ";
                
            } elseif(substr($column, -7) == '_images')
            {
                
                $input_column   = substr($column, 0, -1);
                $folder         = substr($column, 0, strlen($column)-7);
                
                $data .="
        \$imagelist = [];
        
        if(\$request->hasFile('$input_column'))
        {
            
            for(\$i = 0; \$i < count(\$request->file('$input_column')); \$i++)
            {
            
                if(\$request->file('$input_column')[\$i]->isValid())
                {
                    
                    
                    /**
                     * SimpleImage can't make dir. It returns error if directory does not exist.
                     * Make directory (if it dows not exists) before putting file in it
                     */
                    \$location   = public_path().'/img/$folder/';
                    if(!is_dir(\$location))
                    {
                        
                        mkdir(\$location, 0777, true);
                                        
                    }
                    
                    
                    /**
                    *
                    * Prepare names for file at different sizes
                    * 
                    */
                    \$image_lg  = date('Ymdhis').\$i.'_lg.'.\$request->file('$input_column')[\$i]->getClientOriginalExtension();
                    \$image_md  = date('Ymdhis').\$i.'_md.'.\$request->file('$input_column')[\$i]->getClientOriginalExtension();
                    \$image_sm  = date('Ymdhis').\$i.'_sm.'.\$request->file('$input_column')[\$i]->getClientOriginalExtension();
                    \$image_xs  = date('Ymdhis').\$i.'_xs.'.\$request->file('$input_column')[\$i]->getClientOriginalExtension();
                    
                    // Instantiate SimpleImage class
                    \$image = new \App\Http\Controllers\SimpleImage(\$request->file('$input_column')[\$i]);
                    
                    
                    // Size:lg
                    \$image->best_fit(1200,600);
                    \$image->save(\$location.\$image_lg);
                    
                    // Size:md
                    \$image->best_fit(640,400);
                    \$image->save(\$location.\$image_md);
                    
                    // Size:sm
                    \$image->best_fit(320,225);
                    \$image->save(\$location.\$image_sm);
                    
                    // Size:xs
                    \$image->best_fit(100,75);
                    \$image->save(\$location.\$image_xs);
                    
                    \$imagelist[] = '/public/img/$folder/'.\$image_lg;
                    
                }
            
            }
                        
        }
        
        \$request['$column'] = \$imagelist;
        
                ";
                
            } elseif(substr($column, -6) == '_files')
            {
                
                $input_column   = substr($column, 0, -1);
                $folder         = substr($column, 0, strlen($column)-7);
                
                $data .="
        \$filelist = [];
        
        if(\$request->hasFile('$input_column'))
        {
            
            for(\$i = 0; \$i < count(\$request->file('$input_column')); \$i++)
            {
            
                if(\$request->file('$input_column')[\$i]->isValid())
                {
                    
                    
                    /**
                     * SimpleImage can't make dir. It returns error if directory does not exist.
                     * Make directory (if it dows not exists) before putting file in it
                     */
                    \$location   = public_path().'/file/$folder/';
                    if(!is_dir(\$location))
                    {
                        
                        mkdir(\$location, 0777, true);
                                        
                    }
                    
                    \$file  = date('Ymdhis').\$i.'.'.\$request->file('$input_column')[\$i]->getClientOriginalExtension();
                    
                    if(\$request->file('$input_column')[\$i]->move(public_path().'/file/$folder/', \$file))
                    {
                        
                        \$filelist[] = '/public/file/$folder/'.\$file;
                        
                    }
                    
                }
            
            }
                        
        }
        
        \$request['$column'] = \$filelist;
        
                ";
                
            } elseif(substr($column, -5) == '_file')
            {
                
                $input_column   = $column."s";
                $folder         = substr($column, 0, strlen($column)-5);
                
                $data .="
        if(\$request->hasFile('$input_column'))
        {
            if(\$request->file('$input_column')->isValid())
            {

                \$file  = date('Ymdhis').'.'.\$request->file('$input_column')->getClientOriginalExtension();
                
                if(\$request->file('$input_column')->move(public_path().'/file/$folder/', \$file))
                {
                    
                    \$request['$column'] = '/public/file/$folder/'.\$file;
                    
                }
                
            }
                        
        }
        
                ";
                
            }
            
        }
        
        $data .="
        
        \$save_success = $model::create(\$request->all());
        
        if(\$save_success){";
        
        if($manyToManys)
        {
            
            foreach ($manyToManys as $manyToMany) {
                $data .="
            
            if(array_key_exists('".strtolower(str_singular($manyToMany))."_id', \$request->all()))
            {
            
                \App\\$model::find(\$save_success->id)->$manyToMany()->sync(\$request['".strtolower(str_singular($manyToMany))."_id']);
            
            }
                ";
            }
            
        }
        
        $data .="
        
            return redirect()->action('$controller@index')->withErrors('Data has been stored successfully.');
        
        } else{
            
            return back()->withInput()->withErrors('Failed to store data. Please check data and retry.');
            
        }
    
    }
    ";
    
    if(strlen($simple) == 0){
    
    $data .="
    /**
     * Display the specified resource.
     *
     * @param  int  \$id
     * @return \Illuminate\Http\Response
     */
    public function show(\$id)
    {
    
        \$".strtolower($model)." = $model::find(\$id); ";
        
        if($manyToManys)
        {
            
            $pass_many_to_many_to_view = "";
            
            foreach ($manyToManys as $manyToMany) {
                
        $data .="
        
        \$".strtolower($manyToMany)." = $model::find(\$id)->$manyToMany; ";
            $pass_many_to_many_to_view .= ", '$manyToMany'";
            
            }
            
        }
        
        $data.="
        
        return view('admin.$table.show', compact('".strtolower($model)."'$pass_many_to_many_to_view) );
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  \$id
     * @return \Illuminate\Http\Response
     */
    public function edit(\$id)
    {
    
        \$".strtolower($model)." = $model::find(\$id); ";
        
        if($manyToManys)
        {
            
            $pass_many_to_many_to_view = "";
            
            foreach ($manyToManys as $manyToMany) {
                
        $data .="
        
        \$".strtolower($manyToMany)." = $model::find(\$id)->$manyToMany; ";
            
            $pass_many_to_many_to_view .= ", '$manyToMany'";
            
            }
            
        }
        
        $data.="
        
        return view('admin.$table.edit', compact('".strtolower($model)."'$pass_many_to_many_to_view) );
        
    }";
    }
    
    $data .="

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
        
    foreach($table_columns as $column)
    {
        
        if(substr($column, -6) == '_photo')
        {
            
            $input_column   = $column."s";
            $delete_photo   = $column."_delete";
            $folder         = substr($column, 0, strlen($column)-6);
            
            $data .="
        
        if(\$request->has('$delete_photo'))
        {
            
            if(\$".strtolower($model)."->$column)
            {
                
                \$image_to_delete_lg = \$".strtolower($model)."->$column;
                \$image_to_delete_md = substr(\$image_to_delete_lg, 0, strlen(\$image_to_delete_lg)-6).'md'.substr(\$image_to_delete_lg, -4);
                \$image_to_delete_sm = substr(\$image_to_delete_lg, 0, strlen(\$image_to_delete_lg)-6).'sm'.substr(\$image_to_delete_lg, -4);
                \$image_to_delete_xs = substr(\$image_to_delete_lg, 0, strlen(\$image_to_delete_lg)-6).'xs'.substr(\$image_to_delete_lg, -4);
                
                if(\Storage::has(\$image_to_delete_lg))
                {
                    
                    \Storage::delete(\$image_to_delete_lg);
                    
                }
                
                if(\Storage::has(\$image_to_delete_md))
                {
                    
                    \Storage::delete(\$image_to_delete_md);
                    
                }
                
                if(\Storage::has(\$image_to_delete_sm))
                {
                    
                    \Storage::delete(\$image_to_delete_sm);
                    
                }
                
                if(\Storage::has(\$image_to_delete_xs))
                {
                    
                    \Storage::delete(\$image_to_delete_xs);
                    
                }
                
            }
            
        }
        
        
        if(\$request->hasFile('$input_column'))
        {
            if(\$request->file('$input_column')->isValid())
            {
                
                /**
                *
                * At first, remove previous items, if they exist
                * 
                */
                if(\$".strtolower($model)."->$column)
                {
                    
                    \$image_to_delete_lg = \$".strtolower($model)."->$column;
                    \$image_to_delete_md = substr(\$image_to_delete_lg, 0, strlen(\$image_to_delete_lg)-6).'md'.substr(\$image_to_delete_lg, -4);
                    \$image_to_delete_sm = substr(\$image_to_delete_lg, 0, strlen(\$image_to_delete_lg)-6).'sm'.substr(\$image_to_delete_lg, -4);
                    \$image_to_delete_xs = substr(\$image_to_delete_lg, 0, strlen(\$image_to_delete_lg)-6).'xs'.substr(\$image_to_delete_lg, -4);
                    
                    if(\Storage::has(\$image_to_delete_lg))
                    {
                        
                        \Storage::delete(\$image_to_delete_lg);
                        
                    }
                    
                    if(\Storage::has(\$image_to_delete_md))
                    {
                        
                        \Storage::delete(\$image_to_delete_md);
                        
                    }
                    
                    if(\Storage::has(\$image_to_delete_sm))
                    {
                        
                        \Storage::delete(\$image_to_delete_sm);
                        
                    }
                    
                    if(\Storage::has(\$image_to_delete_xs))
                    {
                        
                        \Storage::delete(\$image_to_delete_xs);
                        
                    }
                    
                }
                
                /**
                 * SimpleImage can't make dir. It returns error if directory does not exist.
                 * Make directory (if it dows not exists) before putting file in it
                 */
                \$location   = public_path().'/img/$folder/';
                if(!is_dir(\$location))
                {
                    
                    mkdir(\$location, 0777, true);
                                    
                }
                
                
                /**
                *
                * Prepare names for file at different sizes
                * 
                */
                \$image_lg  = date('Ymdhis').'_lg.'.\$request->file('$input_column')->getClientOriginalExtension();
                \$image_md  = date('Ymdhis').'_md.'.\$request->file('$input_column')->getClientOriginalExtension();
                \$image_sm  = date('Ymdhis').'_sm.'.\$request->file('$input_column')->getClientOriginalExtension();
                \$image_xs  = date('Ymdhis').'_xs.'.\$request->file('$input_column')->getClientOriginalExtension();
                
                // Instantiate SimpleImage class
                \$image = new \App\Http\Controllers\SimpleImage(\$request->file('$input_column'));
                
                
                // Size:lg
                \$image->best_fit(1200,600);
                \$image->save(\$location.\$image_lg);
                
                // Size:md
                \$image->best_fit(640,400);
                \$image->save(\$location.\$image_md);
                
                // Size:sm
                \$image->best_fit(320,225);
                \$image->save(\$location.\$image_sm);
                
                // Size:xs
                \$image->best_fit(100,75);
                \$image->save(\$location.\$image_xs);
                
                \$request['$column'] = '/public/img/$folder/'.\$image_lg;
                
            }
                        
        }";
            
        } elseif(substr($column, -7) == '_images')
        {
            
            $input_column   = $column;
            $delete_photo   = $column."_delete";
            $request_input  = substr($column, 0, -1);
            $folder         = substr($column, 0, strlen($column)-7);
            
            $data .="
        
        if(\$request->has('$delete_photo'))
        {
            
            if( count(".$instance."->$input_column) > 0 && is_array(".$instance."->$input_column) && is_array(\$request->input('$delete_photo')) )
            {
            
                \$images = $instance->$input_column;
                
                foreach(\$request->input('$delete_photo') as \$image)
                {
                
                    \$image_index = array_search(\$image , \$images);
                    
                    if( \$image_index !== false )
                    {
                    
                        unset(\$images[\$image_index]);
            
                        \$image_to_delete_lg = \$image;
                        \$image_to_delete_md = substr(\$image_to_delete_lg, 0, strlen(\$image_to_delete_lg)-6).'md'.substr(\$image_to_delete_lg, -4);
                        \$image_to_delete_sm = substr(\$image_to_delete_lg, 0, strlen(\$image_to_delete_lg)-6).'sm'.substr(\$image_to_delete_lg, -4);
                        \$image_to_delete_xs = substr(\$image_to_delete_lg, 0, strlen(\$image_to_delete_lg)-6).'xs'.substr(\$image_to_delete_lg, -4);
                        
                        if(\Storage::has(\$image_to_delete_lg))
                        {
                            
                            \Storage::delete(\$image_to_delete_lg);
                            
                        }
                        
                        if(\Storage::has(\$image_to_delete_md))
                        {
                            
                            \Storage::delete(\$image_to_delete_md);
                            
                        }
                        
                        if(\Storage::has(\$image_to_delete_sm))
                        {
                            
                            \Storage::delete(\$image_to_delete_sm);
                            
                        }
                        
                        if(\Storage::has(\$image_to_delete_xs))
                        {
                            
                            \Storage::delete(\$image_to_delete_xs);
                            
                        }
                        
                    }
                    
                }
                
                ".$instance."->update(['$input_column'=> \$images]);
            
            }
            
        }
        
        
        if(\$request->hasFile('$request_input'))
        {
        
            \$images = ".$instance."->$input_column;
            
            for(\$i = 0; \$i < count(\$request->file('$request_input')); \$i++)
            {
            
                if(\$request->file('$request_input')[\$i]->isValid())
                {
                    
                    /**
                     * SimpleImage can't make dir. It returns error if directory does not exist.
                     * Make directory (if it does not exist) before putting file in it
                     */
                     
                    \$location   = public_path().'/img/$folder/';
                    if(!is_dir(\$location))
                    {
                        
                        mkdir(\$location, 0777, true);
                                        
                    }
                    
                    
                    /**
                    *
                    * Prepare names for file at different sizes
                    * 
                    */
                    \$image_lg  = date('Ymdhis').\$i.'_lg.'.\$request->file('$request_input')[\$i]->getClientOriginalExtension();
                    \$image_md  = date('Ymdhis').\$i.'_md.'.\$request->file('$request_input')[\$i]->getClientOriginalExtension();
                    \$image_sm  = date('Ymdhis').\$i.'_sm.'.\$request->file('$request_input')[\$i]->getClientOriginalExtension();
                    \$image_xs  = date('Ymdhis').\$i.'_xs.'.\$request->file('$request_input')[\$i]->getClientOriginalExtension();
                    
                    // Instantiate SimpleImage class
                    \$image = new \App\Http\Controllers\SimpleImage(\$request->file('$request_input')[\$i]);
                    
                    
                    // Size:lg
                    \$image->best_fit(1200,800);
                    \$image->save(\$location.\$image_lg);
                    
                    // Size:md
                    \$image->best_fit(640,400);
                    \$image->save(\$location.\$image_md);
                    
                    // Size:sm
                    \$image->best_fit(320,320);
                    \$image->save(\$location.\$image_sm);
                    
                    // Size:xs
                    \$image->best_fit(100,75);
                    \$image->save(\$location.\$image_xs);
                    
                    \$images[] = '/public/img/$folder/'.\$image_lg;
                    
                }
                
            }
            
            \$request['$input_column'] = \$images;
                        
        }";
            
        } elseif(substr($column, -6) == '_files')
        {
            
            $input_column   = $column;
            $delete_files   = $column."_delete";
            $request_input  = substr($column, 0, -1);
            $folder         = substr($column, 0, strlen($column)-7);
            
            $data .="
        
        if(\$request->has('$delete_files'))
        {
            
            if( count(".$instance."->$input_column) > 0 && is_array(".$instance."->$input_column) && is_array(\$request->input('$delete_files')) )
            {
            
                \$files = $instance->$input_column;
                
                foreach(\$request->input('$delete_files') as \$file)
                {
                
                    \$file_index = array_search(\$file , \$files);
                    
                    if( \$file_index !== false )
                    {
                    
                        unset(\$files[\$file_index]);
            
                        if(\Storage::has(\$file))
                        {
                            
                            \Storage::delete(\$file);
                            
                        }
                        
                    }
                    
                }
                
                ".$instance."->update(['$input_column'=> \$files]);
            
            }
            
        }
        
        
        if(\$request->hasFile('$request_input'))
        {
        
            \$files = ".$instance."->$input_column;
            
            for(\$i = 0; \$i < count(\$request->file('$request_input')); \$i++)
            {
            
                if(\$request->file('$request_input')[\$i]->isValid())
                {
                    
                    /**
                     * Make directory (if it does not exist) before putting file in it
                     */
                     
                    \$location   = public_path().'/file/$folder/';
                    if(!is_dir(\$location))
                    {
                        
                        mkdir(\$location, 0777, true);
                                        
                    }
                    
                    
                    /**
                    *
                    * Prepare names for files
                    * 
                    */
                    \$file  = date('Ymdhis').\$i.'.'.\$request->file('$request_input')[\$i]->getClientOriginalExtension();
                
                    if(\$request->file('$request_input')[\$i]->move(public_path().'/file/$folder/', \$file))
                    {
                        
                        \$files[] = '/public/file/$folder/'.\$file;
                        
                    }
                    
                }
                
            }
            
            \$request['$input_column'] = \$files;
                        
        }";
            
        } elseif(substr($column, -5) == '_file')
        {
                
            $input_column   = $column."s";
            $delete_file    = $column."_delete";
            $folder         = substr($column, 0, strlen($column)-5);
            
            $data .="
        
        if(\$request->has('$delete_file'))
        {
            
            if(\$".strtolower($model)."->$column)
            {
                
                \$file_to_delete = \$".strtolower($model)."->$column;
                
                if(\Storage::has(\$file_to_delete))
                {
                    
                    \Storage::delete(\$file_to_delete);
                    
                }
                
            }
            
        }
        
                
        if(\$request->hasFile('$input_column'))
        {
            if(\$request->file('$input_column')->isValid())
            {

                /**
                *
                * At first, remove previous items, if they exist
                * 
                */
                if(\$".strtolower($model)."->$column)
                {
                    
                    if(\Storage::has(\$".strtolower($model)."->$column))
                    {
                        
                        \Storage::delete(\$".strtolower($model)."->$column);
                        
                    }
                    
                }

                \$file  = date('Ymdhis').'.'.\$request->file('$input_column')->getClientOriginalExtension();
                
                if(\$request->file('$input_column')->move(public_path().'/file/$folder/', \$file))
                {
                    
                    \$request['$column'] = '/public/file/$folder/'.\$file;
                    
                }
                
            }
                        
        }
        
                ";
                
            }
    }
    
        $data .="
        
        \$save_success = $model::find(\$id)->update(\$request->all());
        
        if(\$save_success)
        {";
        
        if($manyToManys)
        {
            
            foreach ($manyToManys as $manyToMany) {
                $data .="
            
            if(array_key_exists('".strtolower(str_singular($manyToMany))."_id', \$request->all()))
            {
            
                \App\\$model::find(\$id)->$manyToMany()->sync(\$request['".strtolower(str_singular($manyToMany))."_id']);
            
            } else{
                
                \App\\$model::find(\$id)->$manyToMany()->sync([]);
                
            }
                ";
            }
            
        }
        
        $data .="
            return redirect()->action('$controller@index')->withErrors('Data has been updated successfully.');
        
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
        
        \$".strtolower($model)." = $model::find(\$id);
    
        
        if(\$".strtolower($model).")
        {
    ";
    
    foreach($table_columns as $column)
    {
        
        if(substr($column, -7) == '_images')
        {
            
        $input_column   = $column;
        
        $data .="
        
            \$images = ".$instance."->$input_column;
            
            if(is_array(\$images) && count(\$images) > 0 )
            {
                    
                foreach(\$images as \$image)
                {
                
                    \$image_to_delete_lg = \$image;
                    \$image_to_delete_md = substr(\$image_to_delete_lg, 0, strlen(\$image_to_delete_lg)-6).'md'.substr(\$image_to_delete_lg, -4);
                    \$image_to_delete_sm = substr(\$image_to_delete_lg, 0, strlen(\$image_to_delete_lg)-6).'sm'.substr(\$image_to_delete_lg, -4);
                    \$image_to_delete_xs = substr(\$image_to_delete_lg, 0, strlen(\$image_to_delete_lg)-6).'xs'.substr(\$image_to_delete_lg, -4);
                    
                    if(\Storage::has(\$image_to_delete_lg))
                    {
                        
                        \Storage::delete(\$image_to_delete_lg);
                        
                    }
                    
                    if(\Storage::has(\$image_to_delete_md))
                    {
                        
                        \Storage::delete(\$image_to_delete_md);
                        
                    }
                    
                    if(\Storage::has(\$image_to_delete_sm))
                    {
                        
                        \Storage::delete(\$image_to_delete_sm);
                        
                    }
                    
                    if(\Storage::has(\$image_to_delete_xs))
                    {
                        
                        \Storage::delete(\$image_to_delete_xs);
                        
                    }
                            
                }
                
            }
        
        ";
        
        } elseif(substr($column, -6) == '_photo')
        {
            
            $data .="
            if(\$".strtolower($model)."->$column)
            {
                \$image_to_delete_lg = \$".strtolower($model)."->$column;
                \$image_to_delete_md = substr(\$image_to_delete_lg, 0, strlen(\$image_to_delete_lg)-6).'md'.substr(\$image_to_delete_lg, -4);
                \$image_to_delete_sm = substr(\$image_to_delete_lg, 0, strlen(\$image_to_delete_lg)-6).'sm'.substr(\$image_to_delete_lg, -4);
                \$image_to_delete_xs = substr(\$image_to_delete_lg, 0, strlen(\$image_to_delete_lg)-6).'xs'.substr(\$image_to_delete_lg, -4);
                
                if(\Storage::has(\$image_to_delete_lg))
                {
                    
                    \Storage::delete(\$image_to_delete_lg);
                    
                }
                
                if(\Storage::has(\$image_to_delete_md))
                {
                    
                    \Storage::delete(\$image_to_delete_md);
                    
                }
                
                if(\Storage::has(\$image_to_delete_sm))
                {
                    
                    \Storage::delete(\$image_to_delete_sm);
                    
                }
                
                if(\Storage::has(\$image_to_delete_xs))
                {
                    
                    \Storage::delete(\$image_to_delete_xs);
                    
                }
                
            }
        
                    ";
                    
                    
        
        } elseif(substr($column, -6) == '_files')
        {
            
        $input_column   = $column;
        
        $data .="
        
            \$files = ".$instance."->$input_column;
            
            if(is_array(\$files) && count(\$files) > 0 )
            {
                    
                foreach(\$files as \$file)
                {
                
                    if(\Storage::has(\$file))
                    {
                        
                        \Storage::delete(\$file);
                        
                    }
                    
                }
                
            }
        
        ";
        
        } elseif(substr($column, -5) == '_file')
        {
            
            $data .="
            if(\$".strtolower($model)."->$column)
            {
                
                if(\Storage::has(\$".strtolower($model)."->$column))
                {
                    
                    \Storage::delete(\$".strtolower($model)."->$column);
                    
                }
                
            }
        
                    ";
                    
                    
        
        }
    
    }
    
    $data .="
    
            if(\$".strtolower($model)."->delete())
            {
            
                return redirect()->action('$controller@index')->withErrors('Data has been deleted successfully.');
            
            } else{
                
                return back()->withErrors('Failed to delete data. Please retry later.');
                
            }
        
        } else{
            
            return back()->withErrors('Failed to delete data. Please retry later.');
            
        }
        
        
    }
    ";
    
    if($hasManys)
    {
    foreach($hasManys as $hasMany)
    {
        $data .= "
    
    public function $hasMany(\$id)
    {
        
        return view('admin.$table.$hasMany', ['".strtolower($model)."' => $model::find(\$id) ,'$hasMany' => $model::find(\$id)->$hasMany()->latest()->paginate(20)]);
        
    }
    
    
    public function ".$hasMany."Create(\$id)
    {
        
        return view('admin.$table.".$hasMany."Create', ['".strtolower($model)."' => $model::find(\$id) ]);
        
    }
    
    
    public function ".$hasMany."Store(\$id, Request \$request)
    {
        ";
        $hasMany_table_columns  = \Schema::getColumnListing(strtolower($hasMany));
        
        foreach($hasMany_table_columns as $column)
        {
            
            if(substr($column, -6) == '_photo')
            {
                
                $input_column   = $column."s";
                $folder         = substr($column, 0, strlen($column)-6);
                
                $data .="
        if(\$request->hasFile('$input_column'))
        {
            if(\$request->file('$input_column')->isValid())
            {
                
                
                /**
                 * SimpleImage can't make dir. It returns error if directory does not exist.
                 * Make directory (if it dows not exists) before putting file in it
                 */
                \$location   = public_path().'/img/$folder/';
                if(!is_dir(\$location))
                {
                    
                    mkdir(\$location, 0777, true);
                                    
                }
                
                
                /**
                *
                * Prepare names for file at different sizes
                * 
                */
                \$image_lg  = date('Ymdhis').'_lg.'.\$request->file('$input_column')->getClientOriginalExtension();
                \$image_md  = date('Ymdhis').'_md.'.\$request->file('$input_column')->getClientOriginalExtension();
                \$image_sm  = date('Ymdhis').'_sm.'.\$request->file('$input_column')->getClientOriginalExtension();
                \$image_xs  = date('Ymdhis').'_xs.'.\$request->file('$input_column')->getClientOriginalExtension();
                
                // Instantiate SimpleImage class
                \$image = new \App\Http\Controllers\SimpleImage(\$request->file('$input_column'));
                
                
                // Size:lg
                \$image->best_fit(1200,600);
                \$image->save(\$location.\$image_lg);
                
                // Size:md
                \$image->best_fit(640,400);
                \$image->save(\$location.\$image_md);
                
                // Size:sm
                \$image->best_fit(320,225);
                \$image->save(\$location.\$image_sm);
                
                // Size:xs
                \$image->best_fit(100,75);
                \$image->save(\$location.\$image_xs);
                
                \$request['$column'] = '/public/img/$folder/'.\$image_lg;
                
            }
                        
        }
                ";
                
            } elseif(substr($column, -5) == '_file')
            {
                
                $input_column   = $column."s";
                $folder         = substr($column, 0, strlen($column)-5);
                
                $data .="
        if(\$request->hasFile('$input_column'))
        {
            if(\$request->file('$input_column')->isValid())
            {

                \$file  = date('Ymdhis').'.'.\$request->file('$input_column')->getClientOriginalExtension();
                
                if(\$request->file('$input_column')->move(public_path().'/file/$folder/', \$file))
                {
                    
                    \$request['$column'] = '/public/file/$folder/'.\$file;
                    
                }
                
            }
                        
        }
        
                ";
                
            }
            
        }
        $data .="
        \$request['".strtolower($model)."_id'] = \$id;
        
        if(\App\\".ucfirst(substr($hasMany, 0, -1))."::create(\$request->all()) )
        {
            
            return redirect()->action('$controller@$hasMany', \$id)->withErrors('".substr($hasMany, 0, -1)." has been added successfully.');
            
        } else{
            
            return back()->withErrors('Please check all the fields.')->withInput();
            
        }
        
    }
    
    
    
        ";
        
    }   // end foreach
        
    }   // end if
    
    $data .="
    
    $controllerInjection
    
}

        ";
        $this->file_write(app_path().'/Http/Controllers/'.$controller.'.php', $data);
        $this->info('Controller created: '.$controller);
        
    }
    
    
    function make_request($table, $table_columns, $model, $controller, $request, $hasManys, $manyToManys, $skipSearch, $simple)
    {
        
        $data = "<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class $request extends Request
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
            '".implode("'     => '',\n\t\t\t '", (array) $table_columns)."'      => ''
        ];
    }
}

        ";
        $this->file_write(app_path().'/Http/Requests/'.$request.'.php', $data);
        $this->info('Request created: '.$request.'.php');
        
    }
    
    
    function make_view($table, $table_columns, $model, $controller, $request, $hasManys, $manyToManys, $skipSearch, $simple)
    {
        
        $subject_table      = $table;
        $subject_model      = $model;
        $subject_controller = $controller;
        $fname              = strtolower($table);    // fullname with all lowercase
        $sname              = str_singular(strtolower($table),0,-1);   // short name; If the table name is 'users', short name is 'user', If the table name is 'children', short name is 'child', 
        $name_model     = $model;
        
        $index  = "
@extends('admin.layout')

@section('title') ".str_replace('_',' ',$model)." @stop

@section('main')

<h1><center>".str_replace('_',' ',$controller)." @if(\$".$table.") : {{\$".$table."->total()}} @endif</center></h1>
";

/**
 * For Single page CRUD
*/
if(strlen($simple) == 0)
{

/**
 * If We skip the Search area
*/
if(strlen($skipSearch) == 0)
{
    
$index .="
<section class=\"col-sm-10 col-sm-offset-1\">
    
    {!! Form::open(['class'=>'form form-inline', 'method' =>'post', 'url'=> action('$controller@searchIndex')]) !!} ";
        
        
    foreach( (array) $table_columns as $column)
    {
    
        if($column != 'created_at' && $column != 'updated_at' && $column != 'id' && substr($column, -6) != '_photo' && substr($column, -7) != '_images' && substr($column, -6) != '_files' && substr($column, -5) != '_file'){
            
            if(substr($column, -3, 3) == '_id'){
                
                $model_name = ucfirst(substr($column, 0, -3));
                $index .= "
        <div class=\"form-group\">
            {!! Form::label('$column', '".str_replace('_',' ',substr(ucfirst($column), 0, count($column)-4)).": ') !!}
            {!! Form::select('$column', \App\\$model_name::pluck('name', 'id'), old('$column') , ['class'=>'form-control select2']) !!}
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
}
} else
{
    
 $index .="
 <section class=\"col-md-10 col-md-offset-1 push-down-20\">
    
    <h4 class=\"page-title btn-info\">Create New</h4>
 
    {!! Form::open( ['url'=> action('$controller@store'), 'class'=> 'form form-inline', 'enctype'=>'multipart/form-data' ]) !!}

    ";
    
    foreach( (array) $table_columns as $column)
    {
    
        if($column != 'created_at' && $column != 'updated_at' && $column != 'id' && substr($column, -7) != '_images' && substr($column, -6) != '_files')
        {
            
            if(substr($column, -3, 3) == '_id'){
                
                $model = ucfirst(substr($column, 0, -3));
                $index .= "
        <div class=\"form-group\">
            {!! Form::label('$column', '".str_replace('_',' ',substr(ucfirst($column), 0, count($column)-4)).": ') !!}
            {!! Form::select('$column', \App\\$model::pluck('name', 'id'), old('$column') , ['class'=>'form-control select2']) !!}
        </div>
            ";
                
            } elseif(substr($column, 0, 3) == 'is_'){
                
            $index .= "
        <div class=\"form-group\">
            {!! Form::label('$column', '".str_replace('_',' ',ucfirst($column)).": ') !!}
            {!! Form::select('$column', [ ''=>'-Select-','1'=>'Yes', '0'=>'No'], old('$column') , ['class'=>'form-control']) !!}
        </div>
            ";
            
            } elseif(substr($column, -5, 5) == '_date'){
                
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
            
            } elseif(substr($column, -6) == '_photo' || substr($column, -5) == '_file'){
            
            $file_column = $column."s";
            $index .= "
        <div class=\"form-group\">
            {!! Form::label('$file_column', '".str_replace('_',' ',ucfirst($column)).": ') !!}
            {!! Form::file('$file_column', ['class'=>'form-control file']) !!}
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
    
if($manyToManys)
{
    
    foreach($manyToManys as $manyToMany)
    {
        
        $index .= "
        <div class=\"form-group\">
            {!! Form::label('$manyToMany', '".ucfirst($manyToMany).": ') !!}
            {!! Form::select('".str_singular($manyToMany)."_id[]', \App\\".ucfirst(str_singular($manyToMany))."::pluck('name', 'id'), old('".str_singular($manyToMany)."_id') , ['class'=>'form-control select2', 'multiple'=>'multiple']) !!}
        </div>

        ";
        
    }
    
}


$index .= "
    <div class=\"form-group\">
        {!! Form::submit('Save ".str_replace('_',' ',$name_model)."', ['class'=>'form-control btn btn-info']) !!}
    </div>

{!! Form::close() !!}

</section>

<section class=\"col-md-10 col-md-offset-1 push-down-20\">
    
    <h4 class=\"page-title btn-info\">List of All:</h4>
    
    <div class=\"col-xs-12\">
        
        <ul class=\"list-group\">
        
    @if(\$".$table.")
        @foreach(\$".$table." as \$".$sname.")
            <li class=\"list-group-item\">
                <ul class=\"list-inline\">";
            
            foreach( (array) $table_columns as $column)
            {
                
                if(substr($column, -3, 3) != '_id' && substr($column, -7) != '_images' && substr($column, -6) != '_files')
                {
                    
                    if(substr($column, 0, 3) == 'is_'){
                    
                        $index .= "\n\t\t\t\t\t<li>{{yn(\$".$sname."->".$column.")}}</li>";
                        
                    } elseif(substr($column, -6) == '_photo'){
                    
                        $index .= "\n\t\t\t\t\t<li><center><a href=\"{{\$".$sname."->".$column."}}\" class=\"btn btn-default btn-xs\">{!! thumb(\$".$sname."->".$column.") !!}</a></center></li>";
                        
                    } elseif(substr($column, -5) == '_file'){
                    
                        $index .= "\n\t\t\t\t\t<li><center><a href=\"{{\$".$sname."->".$column."}}\" class=\"btn btn-default btn-xs btn-rounded\"><span class=\"fa fa-download\"></span></a></center></li>";
                        
                    } elseif($column == 'created_at' || $column == 'updated_at'){
                    
                        
                    } else{
                    
                        $index .= "\n\t\t\t\t\t<li>{{\$".$sname."->".$column."}}</li>";
                        
                    }
                    
                } else{
                    
                    $model_name  = substr($column, 0, count($column) -4);
                    $index .= "\n\t\t\t\t\t<li>@if(\$".$sname."->".$model_name.") {{\$".$sname."->".$model_name."->name}} @endif</li>";
                    
                }
                
            }
        
        $index .="  
                    <li class=\"pull-right\">
                            <a class=\"btn btn-default btn-xs\" data-toggle=\"collapse\" data-target=\"#openme{{\$".$sname."->id}}\"><i class=\"fa fa-caret-down\"></i></a>
                            <a class=\"btn btn-default btn-xs\" data-toggle=\"collapse\" data-target=\"#editme{{\$".$sname."->id}}\"><i class=\"fa fa-pencil\"></i></a>
                            <span class=\"btn btn-link btn-xs\">
                                {!! deletes('$controller', $".$sname."['id'], '<span class=\'fa fa-times\'></span>', ['class'=>'btn btn-danger btn-xs']) !!}
                            </span>
                    </li>
                </ul>
                <ul class=\"list-inline collapse\" id=\"editme{{\$".$sname."->id}}\">
                    
                {!! Form::open( ['class'=> 'form form-inline','method'=>'patch', 'url'=> action('$controller@update', \$".$sname."->id), 'enctype'=>'multipart/form-data' ]) !!}
                
                    ";
                    
                    foreach( (array) $table_columns as $column)
                    {
                    
                        if($column != 'created_at' && $column != 'updated_at' && $column != 'id' && substr($column, -7) != '_images' && substr($column, -6) != '_files'){
                            
                            if(substr($column, -3, 3) == '_id'){
                                    
                                $model = ucfirst(substr($column, 0, -3));
                                $index .= "
                            <div class=\"form-group\">
                                {!! Form::label('$column', '".str_replace('_',' ',substr(ucfirst($column), 0, count($column)-4)).": ') !!}
                                {!! Form::select('$column', \App\\$model::pluck('name', 'id'), \$".$sname."->$column , ['class'=>'form-control select2']) !!}
                            </div>
                                ";
                                    
                            } elseif(substr($column, 0, 3) == 'is_'){
                                
                            $index .= "
                            <div class=\"form-group\">
                                {!! Form::label('$column', '".str_replace('_',' ',ucfirst($column)).": ') !!}
                                {!! Form::select('$column', [ ''=>'-Select-','1'=>'Yes', '0'=>'No'], \$".$sname."->$column , ['class'=>'form-control']) !!}
                            </div>
                            ";
                            
                            } elseif(substr($column, -5, 5) == '_date'){
                                    
                                $index .= "
                            <div class=\"form-group\">
                                {!! Form::label('$column', '".str_replace('_',' ',ucfirst($column)).": ') !!}
                                {!! Form::text('$column', \$".$sname."->$column , ['class'=>'form-control datepicker']) !!}
                            </div>
                                ";
                                
                            } elseif(substr($column, -5, 5) == '_time'){
                                    
                                $index .= "
                            <div class=\"form-group\">
                                {!! Form::label('$column', '".str_replace('_',' ',ucfirst($column)).": ') !!}
                                {!! Form::text('$column', \$".$sname."->$column , ['class'=>'form-control timepicker']) !!}
                            </div>
                                ";
                                
                            } elseif(substr($column, -6) == '_photo' || substr($column, -5) == '_file'){
                                
                                $file_column = $column."s";
                                $index .= "
                            <div class=\"form-group\">
                                <label for=\"$file_column\">".str_replace('_',' ',ucfirst($column)).": <span class=\"badge badge-primary\"><input type=\"checkbox\" value=\"1\" name=\"".$column."_delete\" /> remove</span></label>
                                {!! Form::file('$file_column' , ['class'=>'form-control file']) !!}
                            </div>
                                ";
                                
                            } else{
                                    
                                $index .= "
                            <div class=\"form-group\">
                                {!! Form::label('$column', '".str_replace('_',' ',ucfirst($column)).": ') !!}
                                {!! Form::text('$column', \$".$sname."->$column , ['class'=>'form-control']) !!}
                            </div>
                                ";
                                
                            } 
                    
                        }
                        
                    }
                
                if($manyToManys)
                {
                    
                    foreach($manyToManys as $manyToMany)
                    {
                        
                        $index .= "
                            <div class=\"form-group\">
                                {!! Form::label('$manyToMany', '".ucfirst($manyToMany).": ') !!}
                                {!! Form::select('".str_singular($manyToMany)."_id[]', \App\\".ucfirst(str_singular($manyToMany))."::pluck('name', 'id'), \$".$sname."->$manyToMany()->pluck('".strtolower(str_singular($manyToMany))."_id')->toArray() , ['class'=>'form-control select2', 'multiple'=>'multiple']) !!}
                            </div>
                
                        ";
                        
                    }
                    
                }
                
                $index .= "
                    <div class=\"form-group\">
                        {!! Form::submit('Update ".str_replace('_',' ',$name_model)."', ['class'=>'form-control btn btn-info']) !!}
                    </div>
                
                {!! Form::close() !!}

                
        ";
        
        $index .="
                </ul>
                <div class=\"row collapse\" id=\"openme{{\$".$sname."->id}}\">";
                    
                    if($hasManys)
                    {
                        foreach($hasManys as $hasMany){
                            $hasManyTable       = strtolower($hasMany);
                            $hasManySname       = strtolower(str_singular($hasManyTable));
                            $hasManyController  = ucfirst($hasManyTable);
                            $hasManyModel       = ucfirst(str_singular($hasManyTable));
                            $hasManyColumns     = $table_columns  = \Schema::getColumnListing($hasManyTable);
                            $index .="
                    <ul class=\"list-unstyled\">
                            <h4 class=\"push-up-10 push-down-10 text-success\">$hasManyController</h4>
                        @if(\$$sname->".strtolower($hasMany).")
                            @foreach(\$$sname->$hasManyTable as \$".str_singular($hasManyTable).")
                            <li>
                                <div class=\"col-xs-12\">
                                    {{\$".str_singular($hasManyTable)."->id}} {{\$".str_singular($hasManyTable)."->name}}
                                    <a class=\"btn btn-default btn-xs pull-right\" data-toggle=\"collapse\" data-target=\"#modifyme{{\$".$hasManySname."->id}}\"><i class=\"fa fa-pencil\"></i></a>
                                    <span class=\"btn btn-link btn-xs pull-right\">
                                        {!! deletes('$hasManyController', $".$hasManySname."['id'], '<span class=\'fa fa-times\'></span>', ['class'=>'btn btn-danger btn-xs']) !!}
                                    </span>
                                </div>
                                <div class=\"col-xs-12 collapse\" id=\"modifyme{{\$".$hasManySname."->id}}\">
                                    {!! Form::open( ['class'=> 'form form-inline','method'=>'patch', 'url'=> action('$hasManyController@update', \$".$hasManySname."->id), 'enctype'=>'multipart/form-data' ]) !!}";
                                    
                                    foreach( (array) $hasManyColumns as $column)
                                    {
                                    
                                        if($column != 'created_at' && $column != 'updated_at' && $column != 'id' && $column != 'created_by' && $column != 'updated_by'){
                                            
                                            if(substr($column, -3, 3) == '_id'){
                                                    
                                                $model = ucfirst(substr($column, 0, -3));
                                                $index .= "
                                            <div class=\"form-group\">
                                                {!! Form::label('$column', '".str_replace('_',' ',substr(ucfirst($column), 0, count($column)-4)).": ') !!}
                                                {!! Form::select('$column', \App\\$model::pluck('name', 'id'), \$".$hasManySname."->$column , ['class'=>'form-control select2']) !!}
                                            </div>
                                                ";
                                                    
                                            } elseif(substr($column, 0, 3) == 'is_'){
                                                
                                            $index .= "
                                            <div class=\"form-group\">
                                                {!! Form::label('$column', '".str_replace('_',' ',ucfirst($column)).": ') !!}
                                                {!! Form::select('$column', [ ''=>'-Select-','1'=>'Yes', '0'=>'No'], \$".$hasManySname."->$column , ['class'=>'form-control']) !!}
                                            </div>
                                            ";
                                            
                                            } elseif(substr($column, -5, 5) == '_date'){
                                                    
                                                $index .= "
                                            <div class=\"form-group\">
                                                {!! Form::label('$column', '".str_replace('_',' ',ucfirst($column)).": ') !!}
                                                {!! Form::text('$column', \$".$hasManySname."->$column , ['class'=>'form-control datepicker']) !!}
                                            </div>
                                                ";
                                                
                                            } elseif(substr($column, -5, 5) == '_time'){
                                                    
                                                $index .= "
                                            <div class=\"form-group\">
                                                {!! Form::label('$column', '".str_replace('_',' ',ucfirst($column)).": ') !!}
                                                {!! Form::text('$column', \$".$hasManySname."->$column , ['class'=>'form-control timepicker']) !!}
                                            </div>
                                                ";
                                                
                                            } elseif(substr($column, -6) == '_photo' || substr($column, -5) == '_file'){
                                                
                                                $file_column = $column."s";
                                                $index .= "
                                            <div class=\"form-group\">
                                                <label for=\"$file_column\">".str_replace('_',' ',ucfirst($column)).": <span class=\"badge badge-primary\"><input type=\"checkbox\" value=\"1\" name=\"".$column."_delete\" /> remove</span></label>
                                                {!! Form::file('$file_column' , ['class'=>'form-control file']) !!}
                                            </div>
                                                ";
                                                
                                            } else{
                                                    
                                                $index .= "
                                            <div class=\"form-group\">
                                                {!! Form::label('$column', '".str_replace('_',' ',ucfirst($column)).": ') !!}
                                                {!! Form::text('$column', \$".$hasManySname."->$column , ['class'=>'form-control']) !!}
                                            </div>
                                                ";
                                                
                                            } 
                                    
                                        }
                                        
                                    }
                                
                                
                                $index .= "
                                            <div class=\"form-group\">
                                                {!! Form::submit('Update ".str_replace('_',' ',$hasManyModel)."', ['class'=>'form-control btn btn-info']) !!}
                                            </div>
                                
                                    {!! Form::close() !!}
                                </div>
                            </li>
                            @endforeach
                        @endif
                    </ul>
                            ";
                        }
                    }
                    
                    $index .="
                </div>
            </li>
        @endforeach
    @endif
                
            <ul>
    </div>
</section>
";

}


$index .="{!! errors(\$errors) !!}";

if(strlen($simple) == 0)
{
$index .="

<section class=\"col-sm-10 col-sm-offset-1\">
    
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
}

$index .="

@stop
        ";

if(strlen($simple) == 0){

        $create  = "
@extends('admin.layout')

@section('title') Create new ".str_replace('_',' ',$model)." @stop

@section('main')

<h1 class=\"page-title blue-bg white-text\"><center>".str_replace('_',' ',$controller)."</center></h1>

{!! errors(\$errors) !!}

<section class=\"col-sm-6 col-sm-offset-3\">

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
            {!! Form::select('$column', \App\\$model::pluck('name', 'id'), old('$column') , ['class'=>'form-control select2']) !!}
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
    
if($manyToManys)
{
    
    foreach($manyToManys as $manyToMany)
    {
        
        $create .= "
        <div class=\"form-group\">
            {!! Form::label('$manyToMany', '".ucfirst($manyToMany).": ') !!}
            {!! Form::select('".str_singular($manyToMany)."_id[]', \App\\".ucfirst(str_singular($manyToMany))."::pluck('name', 'id'), old('".str_singular($manyToMany)."_id') , ['class'=>'form-control select2', 'multiple'=>'multiple']) !!}
        </div>

        ";
        
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

<h1 class=\"page-title blue-bg white-text\"><center>Modify ".str_replace('_',' ',$model)."</center></h1>

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
                {!! Form::select('$column', \App\\$model::pluck('name', 'id'), \$".$sname."->$column , ['class'=>'form-control select2']) !!}
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

if($manyToManys)
{
    
    foreach($manyToManys as $manyToMany)
    {
        
        $edit .= "
            <div class=\"form-group\">
                {!! Form::label('$manyToMany', '".ucfirst($manyToMany).": ') !!}
                {!! Form::select('".str_singular($manyToMany)."_id[]', \App\\".ucfirst(str_singular($manyToMany))."::pluck('name', 'id'), \$".$sname."->$manyToMany()->pluck('".strtolower(str_singular($manyToMany))."_id')->toArray() , ['class'=>'form-control select2', 'multiple'=>'multiple']) !!}
            </div>

        ";
        
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

@section('title') ".str_replace('_',' ',$model)." @stop

@section('main')

<h1 class=\"page-title\"><center>".str_replace('_',' ',$model)."</center></h1>

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
            
        if($hasManys)
        {
            
            foreach($hasManys as $hasMany)
            {
                $show .= "
                        <a href=\"{{action('$controller@$hasMany', \$".$sname."->id)}}\" class=\"btn btn-info btn-sm\">".str_replace('_',' ',$hasMany)."</a>
                        <a href=\"{{action('$controller@".$hasMany."Create', \$".$sname."->id)}}\" class=\"btn btn-info btn-sm\">add ".str_replace('_',' ',$hasMany)."</a>
                        ";
            }
            
        }
        
        
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

if($manyToManys)
{
    foreach ($manyToManys as $manyToMany) {
    $show .="
@if(\$$manyToMany)
<section class=\"row panel-body\">
    
    <div class=\"col-xs-12\">
        <h4 class=\"page-title btn-info\">Skillitems</h4>
    </div>
    <div class=\"col-xs-12\">
        <ul class=\"list-group border-bottom\">
            @foreach(\$$manyToMany as \$item)
            <li class=\"list-group-item\">{{\$item->name}}</li>
            @endforeach
        </ul>
    </div>
</section>
@endif
";
    }
    
}



$show .="
@else

    <h3>No data found.</h3>

@endif

@stop
        ";
        

if($hasManys)
{

foreach($hasManys as $hasMany)
{

$table          = $hasMany;
$fname          = strtolower($table);    // fullname with all lowercase
$sname          = substr(strtolower($table), 0, -1);   // short name; If the table name is 'users', short name is 'user'
$model          = ucfirst(str_singular($table)); //ucfirst(substr($table, 0, -1));
$controller     = ucfirst(str_plural($model));
$table_columns  = \Schema::getColumnListing(strtolower($table));

$name_model     = $model;
        
        $hasManyView  = "@extends('admin.layout')

@section('title') ".str_replace('_',' ',$model)." @stop

@section('main')

<h1><center>".str_replace('_',' ',$controller)." @if(\$".$table.") : {{\$".$table."->total()}} @endif</center></h1>

<section class=\"col-xs-12\">
    
    {!! Form::open(['class'=>'form form-inline', 'method' =>'post', 'url'=> action('$controller@searchIndex')]) !!} ";
        
        
    foreach( (array) $table_columns as $column)
    {
    
        if($column != 'created_at' && $column != 'updated_at' && $column != 'id' && substr($column, -6) != '_photo' && substr($column, -5) != '_file'){
            
            if(substr($column, -3, 3) == '_id'){
                
                $model_name = ucfirst(substr($column, 0, -3));
                $hasManyView .= "
        <div class=\"form-group\">
            {!! Form::label('$column', '".str_replace('_',' ',substr(ucfirst($column), 0, count($column)-4)).": ') !!}
            {!! Form::select('$column', \App\\$model_name::pluck('name', 'id'), old('$column') , ['class'=>'form-control select2']) !!}
        </div>
            ";
                
            } elseif(substr($column, 0, 3) == 'is_'){
                
            $hasManyView .= "
        <div class=\"form-group\">
            {!! Form::label('$column', '".str_replace('_',' ',ucfirst($column)).": ') !!}
            {!! Form::select('$column', [ ''=>'-Select-','1'=>'Yes', '0'=>'No'], old('$column') , ['class'=>'form-control']) !!}
        </div>
            ";
            
            }  elseif(substr($column, -5, 5) == '_date'){
                
            $hasManyView .= "
        <div class=\"form-group\">
            {!! Form::label('$column', '".str_replace('_',' ',ucfirst($column)).": ') !!}
            {!! Form::text('$column', old('$column') , ['class'=>'form-control datepicker']) !!}
        </div>
            ";
            
            } elseif(substr($column, -5, 5) == '_time'){
                
            $hasManyView .= "
        <div class=\"form-group\">
            {!! Form::label('$column', '".str_replace('_',' ',ucfirst($column)).": ') !!}
            {!! Form::text('$column', old('$column') , ['class'=>'form-control timepicker']) !!}
        </div>
            ";
            
            } else{
                
            $hasManyView .= "
        <div class=\"form-group\">
            {!! Form::label('$column', '".str_replace('_',' ',ucfirst($column)).": ') !!}
            {!! Form::text('$column', old('$column') , ['class'=>'form-control']) !!}
        </div>
            ";
            
            } 
            
            
        }
        
    }
        
        $hasManyView .="
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

{!! errors(\$errors) !!}

<section class=\"col-sm-11\">
    <h2>
        <a class=\"btn btn-warning pull-right\" href=\"{{action('".ucfirst($subject_table)."@".$table."Create', \$".strtolower($subject_model)."->id)}}\">Create new ".str_singular($table)."</a>
        <br>
    </h2>
    
    <table class=\"table table-responsive\">
        <thead>
            <tr>"; 
            
            foreach( (array) $table_columns as $column)
            {
                
                if(substr($column, -3, 3) == '_id')
                {
                    
                    $hasManyView .= "\n\t\t\t\t<th>".str_replace('_', ' ', substr(ucfirst($column), 0, count($column)-4))."</th>";
                    
                } else{
                    
                    $hasManyView .= "\n\t\t\t\t<th>".str_replace('_', ' ', ucfirst($column) )."</th>";
                    
                }
                
            }
            
            $hasManyView .="
                <th>Show</th>
                <th>Modify</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
            @if(\$".$table.")
                @foreach(\$".$table." as \$".$sname.")
                    <tr>";
                    
                    foreach( (array) $table_columns as $column)
                    {
                        
                        if(substr($column, -3, 3) != '_id')
                        {
                            
                            if(substr($column, 0, 3) == 'is_'){
                            
                                $hasManyView .= "\n\t\t\t\t\t\t<td>{{yn(\$".$sname."->".$column.")}}</td>";
                                
                            } elseif(substr($column, -6) == '_photo'){
                            
                                $hasManyView .= "\n\t\t\t\t\t\t<td><center><a href=\"{{\$".$sname."->".$column."}}\" class=\"btn btn-default btn-xs\">{!! thumb(\$".$sname."->".$column.") !!}</a></center></td>";
                                
                            } elseif(substr($column, -5) == '_file'){
                            
                                $hasManyView .= "\n\t\t\t\t\t\t<td><center><a href=\"{{\$".$sname."->".$column."}}\" class=\"btn btn-default btn-xs btn-rounded\"><span class=\"fa fa-download\"></span></a></center></td>";
                                
                            } else{
                            
                                $hasManyView .= "\n\t\t\t\t\t\t<td>{{\$".$sname."->".$column."}}</td>";
                                
                            }
                            
                        } else{
                            
                            $model_name  = substr($column, 0, count($column) -4);
                            $hasManyView .= "\n\t\t\t\t\t\t<td>@if(\$".$sname."->".$model_name.") {{\$".$sname."->".$model_name."->name}} @endif</td>";
                            
                        }
                        
                    }
                
                $hasManyView .="
                        <td>
                            <a href=\"{{action('$controller@show', \$".$sname."->id)}}\" class=\"btn btn-default btn-sm btn-rounded\" title=\"Edit role\"><span class=\"fa fa-pencil\"></span></a>
                        </td>
                        <td>
                            <a href=\"{{action('$controller@edit', \$".$sname."['id'])}}\" class=\"btn btn-default btn-sm btn-rounded\" title=\"Edit role\"><span class=\"fa fa-pencil\"></span></a>
                        </td>
                        <td>
                            {!! Form::open(['method'=>'delete', 'url'=> action('$controller@destroy', $".$sname."->id) ]) !!}
                            {!! Form::hidden('id', \$".$sname."->id ) !!}
                            <button href=\"{{action('$controller@edit',[\$".$sname."->id])}}\" class=\"btn btn-danger btn-sm btn-rounded\" title=\"Delete $sname \">
                                <span class=\"fa fa-times\"></span>
                            </button>
                            {!! Form::close() !!}
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
    {!! \$".$table."->render() !!}
</section>

@stop
        ";
        
        
        $hasManyCreate  = "
@extends('admin.layout')

@section('title') Create new ".str_replace('_',' ',$model)." @stop

@section('main')

<h1><center>".str_replace('_',' ',$controller)."</center></h1>


{!! errors(\$errors) !!}


<section class=\"col-sm-11\">

<h3>Create ".str_replace('_',' ',$model)."</h3>


{!! Form::open( ['url'=> action('$subject_controller@".$hasMany."Store', \$".strtolower($subject_model)."->id), 'class'=>'form form-horizontal', 'enctype'=>'multipart/form-data' ]) !!}

    ";
    
    foreach( (array) $table_columns as $column)
    {
    
        if($column != 'created_at' && $column != 'updated_at' && $column != 'id'){
            
            if(substr($column, -3, 3) == '_id'){
                
                if($column != strtolower($subject_model).'_id')
                {
                
                $model = ucfirst(substr($column, 0, -3));
                $hasManyCreate .= "
        <div class=\"form-group\">
            {!! Form::label('$column', '".str_replace('_',' ',substr(ucfirst($column), 0, count($column)-4)).": ') !!}
            {!! Form::select('$column', \App\\$model::pluck('name', 'id'), old('$column') , ['class'=>'form-control select2']) !!}
        </div>
            ";
                }
                
            } elseif(substr($column, 0, 3) == 'is_'){
                
            $hasManyCreate .= "
        <div class=\"form-group\">
            {!! Form::label('$column', '".str_replace('_',' ',ucfirst($column)).": ') !!}
            {!! Form::select('$column', [ ''=>'-Select-','1'=>'Yes', '0'=>'No'], old('$column') , ['class'=>'form-control']) !!}
        </div>
            ";
            
            } elseif(substr($column, -5, 5) == '_date'){
                
            $hasManyCreate .= "
        <div class=\"form-group\">
            {!! Form::label('$column', '".str_replace('_',' ',ucfirst($column)).": ') !!}
            {!! Form::text('$column', old('$column') , ['class'=>'form-control datepicker']) !!}
        </div>
            ";
            
            } elseif(substr($column, -5, 5) == '_time'){
                
            $hasManyCreate .= "
        <div class=\"form-group\">
            {!! Form::label('$column', '".str_replace('_',' ',ucfirst($column)).": ') !!}
            {!! Form::text('$column', old('$column') , ['class'=>'form-control timepicker']) !!}
        </div>
            ";
            
            } elseif(substr($column, -6) == '_photo' || substr($column, -5) == '_file'){
            
            $file_column = $column."s";
            $hasManyCreate .= "
        <div class=\"form-group\">
            {!! Form::label('$file_column', '".str_replace('_',' ',ucfirst($column)).": ') !!}
            {!! Form::file('$file_column', ['class'=>'form-control file']) !!}
        </div>
            ";
            
            } else{
                
            $hasManyCreate .= "
        <div class=\"form-group\">
            {!! Form::label('$column', '".str_replace('_',' ',ucfirst($column)).": ') !!}
            {!! Form::text('$column', old('$column') , ['class'=>'form-control']) !!}
        </div>
            ";
            
            } 
            
            
        }
        
    }
    

$hasManyCreate .= "
    <div class=\"form-group\">
        {!! Form::submit('Save ".str_replace('_',' ',$name_model)."', ['class'=>'form-control btn btn-info']) !!}
    </div>

{!! Form::close() !!}


</section>

@stop
        ";
        
        $this->file_write(base_path().'/resources/views/admin/'.$subject_table.'/'.$hasMany.'.blade.php', $hasManyView);
        $this->info('View created: /views/admin/'.$subject_table.'/'.$hasMany.'/show.blade.php');
        
        $this->file_write(base_path().'/resources/views/admin/'.$subject_table.'/'.$hasMany.'Create.blade.php', $hasManyCreate);
        $this->info('View created: /views/admin/'.$subject_table.'/'.$hasMany.'/show.blade.php');
    
}   // foreach loop for $hasmays end here
    
}   // if $hasManys end here
        
        $this->file_write(base_path().'/resources/views/admin/'.$subject_table.'/create.blade.php', $create);
        $this->info('View created: /views/admin/'.$subject_table.'/create.blade.php');
        
        $this->file_write(base_path().'/resources/views/admin/'.$subject_table.'/edit.blade.php', $edit);
        $this->info('View created: /views/admin/'.$subject_table.'/edit.blade.php');
        
        $this->file_write(base_path().'/resources/views/admin/'.$subject_table.'/show.blade.php', $show);
        $this->info('View created: /views/admin/'.$subject_table.'/show.blade.php');
        
}
        
        $this->file_write(base_path().'/resources/views/admin/'.$subject_table.'/index.blade.php', $index);
        $this->info('View created: /views/admin/'.$subject_table.'/index.blade.php');
        
        
        
    }
    

    public function crud($table)
    {
        $table_columns  = \Schema::getColumnListing(strtolower($table));
        $request        = strtolower($table)."StoreRequest";
        $model          = ucfirst(str_singular($table));
        $controller     = ucfirst(str_plural($model));
        $hasManys       = (strlen($this->option('hasMany')) > 1) ? explode(' ', $this->option('hasMany')) : [] ;
        $manyToManys    = (strlen($this->option('manyToMany')) > 1) ? explode(' ', $this->option('manyToMany')) : [] ;
        $modelInjection = $this->option('modelInjection');
        $controllerInjection = $this->option('controllerInjection');
        $skipSearch     = $this->option('skipSearch');
        $simple         = $this->option('simple');
        $view           = '';
        
        
        $this->make_request($table, $table_columns, $model, $controller, $request, $hasManys, $manyToManys, $skipSearch, $simple);
        $this->make_model($table, $table_columns, $model, $controller, $request, $hasManys, $modelInjection, $manyToManys, $skipSearch, $simple);
        $this->make_controller($table, $table_columns, $model, $controller, $request, $hasManys, $controllerInjection, $manyToManys, $skipSearch, $simple);
        $this->make_view($table, $table_columns, $model, $controller, $request, $hasManys, $manyToManys, $skipSearch, $simple);
        
        $output = "Operation is complete. Add Route to auth > admin";
        
        if(strlen($simple) == 0){
        if(strlen($skipSearch) == 0)
        {
        $output .="
        Route::post('$table/search', '".$controller."@searchIndex');
        Route::get('$table/search', function(){ return redirect()->action('".$controller."@index'); });";
        }

        if($hasManys)
        {
            foreach($hasManys as $hasMany)
            {
            $output .= "
        Route::get('$table/{id}/$hasMany','$controller@$hasMany');   
        Route::get('$table/{id}/$hasMany/create','$controller@".$hasMany."Create');  
        Route::post('$table/{id}/$hasMany/create','$controller@".$hasMany."Store');";   
            }
        }
        }
        $output .= "
        Route::resource('$table', '".$controller."');";
        
        $this->info($output);
        
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        
        $this->crud($this->argument('table'));
        
    }
    
}
